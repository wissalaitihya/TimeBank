<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
            'id'                   => $this->id,
            'titre'                => $this->titre,
            'description'          => $this->description,
            'description_originale'=> $this->description_originale,
            'duree_estimee'        => $this->duree_estimee,
            'urgence'              => $this->urgence,
            'urgence_label'        => $this->urgenceLabel(),
            'statut'               => $this->statut,
            'ai_status'            => $this->ai_status,
            'ai_suggestion'        => $this->ai_suggestion,
            'created_at'           => $this->created_at->format('d/m/Y H:i'),
            'user'                 => [
                'id'               => $this->user->id,
                'name'             => $this->user->name,
                'score_reputation' => $this->user->score_reputation,
                'niveau'           => $this->user->niveau,
            ],
            'skill'                => [
                'id'        => $this->skill->id,
                'nom'       => $this->skill->nom,
                'categorie' => $this->skill->categorie,
            ],
        ];
    }

    private function urgenceLabel(): string
    {
        return match($this->urgence) {
            'low'    => 'Faible',
            'normal' => 'Normale',
            'high'   => 'Haute',
            default  => 'Normale',
        };
}
