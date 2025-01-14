<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    public function modify(User $user, Ticket $ticket): Response
    {
        return $user->id === $ticket->user_id
            ? Response::allow()
            : Response::deny('You do not own this ticket.');
    }
}
