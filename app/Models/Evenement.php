<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nom
 * @property string $description
 * @property string $lieu
 * @property string $date_debut
 * @property string $date_fin
 * @property int $nombre_tickets
 * @property int $created_by
 * @property User $createdBy
 * @property TypeTicket[] $typeTickets
 * @property Image[] $images
 */
class Evenement extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'nom',
        'created_by',
        'description',
        'lieu',
        'date_debut',
        'date_fin',
        'nombre_tickets',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
    ];

    /**
     * Get the user that created the Evenement
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
    * Get all of the types of ticket for the Evenement.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function typeTickets()
    {
        return $this->hasMany(TypeTicket::class);
    }

    /**
    * Get all of the images linked to the Evenement.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
