<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class EvenementFilter extends ApiFilter
{
    protected $safeParams = [
        'id' => ['eq'],
        'nom' => ['eq', 'like'],
        'description' => ['eq', 'like'],
        'lieu' => ['eq', 'like'],
        'dateDebut' => ['eq', 'gt', 'lt'],
        'dateFin' => ['eq', 'gt', 'lt'],
        'nombreTickets' => ['eq', 'gt', 'lt'],
    ];

    protected $columnMap = [
        'dateDebut' => 'date_debut',
        'dateFin' => 'date_fin',
        'nombreTickets' => 'nombre_tickets',
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'like' => 'like',
    ];
}
