<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $path
 * @property string $created_at
 * @property string $updated_at
 * @property int $evenement_id
 * @property Evenement $evenement
 */
class Image extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'nom',
        'path',
        'evenement_id',
    ];

    /**
     * Get the evenement that owns the Image
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function evenement()
    {
        return $this->belongsTo(Evenement::class);
    }
}
