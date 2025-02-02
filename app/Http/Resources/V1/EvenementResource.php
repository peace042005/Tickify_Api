<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EvenementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        // Calculer le nombre de tickets vendus pour l'événement
        $soldTickets = $this->typeTickets->sum(function ($typeTicket) {
            return $typeTicket->tickets()->count();
        });

        // Déduire le nombre de tickets restants
        $remainingTickets = $this->nombre_tickets - $soldTickets;

        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'description' => $this->description,
            'lieu' => $this->lieu,
            'dateDebut' => $this->date_debut,
            'dateFin' => $this->date_fin,
            // 'nombreTickets' => $this->nombre_tickets,
            'nombreTickets' => $remainingTickets,
            'images' => $this->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'url' => asset('storage/'.$image->path),
                ];
            }),
            'typesTickets' => TypeTicketRessource::collection($this->whenLoaded('typeTickets')),  // Updated to match the relationship name
        ];
    }
}
