<?php

namespace App\Filters;

use Illuminate\Http\Request;
use InvalidArgumentException;

class ApiFilter
{
    protected $safeParams = [ ];

    protected $columnMap = [ ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'like' => 'like',
    ];

    /**
     * Transform the request query parameters into database query conditions
     *
     * @return array
     *
     * @throws InvalidArgumentException
     */
    public function transform(Request $request)
    {
        $eloQuery = [];

        foreach ($this->safeParams as $key => $operators) {
            $query = $request->query($key);

            if (! isset($query)) {
                continue;
            }

            $column = $this->columnMap[$key] ?? $key;

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    // Validate operator
                    if (! isset($this->operatorMap[$operator])) {
                        throw new InvalidArgumentException("Invalid operator: {$operator}");
                    }

                    // Special handling for LIKE queries
                    $value = $query[$operator];
                    if ($operator === 'like') {
                        $value = '%'.$value.'%';
                    }

                    // Special handling for date fields
                    if (in_array($key, ['dateDebut', 'dateFin'])) {
                        if (! strtotime($value)) {
                            throw new InvalidArgumentException("Invalid date format for {$key}");
                        }
                    }

                    // Special handling for numeric fields
                    if ($key === 'nombreTickets' || $key === 'id') {
                        if (! is_numeric($value)) {
                            throw new InvalidArgumentException("Numeric value required for {$key}");
                        }
                    }

                    $eloQuery[] = [$column, $this->operatorMap[$operator], $value];
                }
            }
        }

        return $eloQuery;
    }

    /**
     * Apply the query conditions to a query builder instance
     *
     * @param  \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function apply($query, array $conditions)
    {
        foreach ($conditions as $condition) {
            $query->where(...$condition);
        }

        return $query;
    }
}
