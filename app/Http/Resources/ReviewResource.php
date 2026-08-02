<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'note'        => $this->note,
            'stars'       => str_repeat('★', $this->note) . str_repeat('☆', 5 - $this->note),
            'commentaire' => $this->commentaire,
            'tags'        => $this->tags ?? [],
            'created_at'  => $this->created_at->format('d/m/Y'),
            'reviewer'    => [
                'id'    => $this->reviewer->id,
                'name'  => $this->reviewer->name,
                'niveau'=> $this->reviewer->niveau,
        ],
        'reviewed'    => [
                'id'               => $this->reviewed->id,
                'name'             => $this->reviewed->name,
                'score_reputation' => $this->reviewed->score_reputation,
            ],
            'match'       => [
                'id'     => $this->match->id,
                'statut' => $this->match->statut,
            ],
        ];
    }
}
