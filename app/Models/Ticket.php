<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property User $user
 * @property string $status
 * @property int $type_ticket_id
 * @property TypeTicket $typeTicket
 * @property string $created_at
 * @property string $updated_at
 */
class Ticket extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'status',
        'type_ticket_id',
    ];

    /**
     * Get the user that owns the Ticket
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the TypeTicket that owns the Ticket
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeTicket()
    {
        return $this->belongsTo(TypeTicket::class);
    }
}
