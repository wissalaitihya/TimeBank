<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceOfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'titre'          => $this->titre,
            'description'    => $this->description,
            'duree_estimee'  => $this->duree_estimee,
            'disponibilites' => $this->disponibilites,
            'statut'         => $this->statut,
            'created_at'     => $this->created_at->format('d/m/Y H:i'),
            'user'           => [
                'id'               => $this->user->id,
                'name'             => $this->user->name,
                'score_reputation' => $this->user->score_reputation,
                'niveau'           => $this->user->niveau,
            ],
        ];
    }
}
