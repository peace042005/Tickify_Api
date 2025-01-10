<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nom
 * @property float $prix
 * @property int $evenement_id
 * @property Evenement $evenement
 * @property string $created_at
 * @property string $updated_at
 */
class TypeTicket extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'nom',
        'prix',
        'evenement_id',
    ];

    protected $casts = [
        'prix' => 'float',
    ];

    /**
     * Get the evenement that owns the Type_ticket
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function evenement()
    {
        return $this->belongsTo(Evenement::class);
    }
}
