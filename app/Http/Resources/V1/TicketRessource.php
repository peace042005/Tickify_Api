<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type_ticket' => [
                'id' => $this->typeTicket->id,
                'nom' => $this->typeTicket->nom,
                'prix' => $this->typeTicket->prix,
                'evenement' => [
                    'id' => $this->typeTicket->evenement->id,
                    'nom' => $this->typeTicket->evenement->nom,
                ],
            ],
        ];
    }
}
