<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'description' => $this->description,
            'lieu' => $this->lieu,
            'dateDebut' => $this->date_debut,
            'dateFin' => $this->date_fin,
            'nombreTickets' => $this->nombre_tickets,
            'images' => $this->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'nom' => $image->nom,
                    // 'url' => Storage::url($image->path),
                    'url' => asset('storage/' . $image->path) ,
                ];
            }),
        ];
    }
}
