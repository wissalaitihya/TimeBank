<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceMatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                          => $this->id,
            'statut'                      => $this->statut,
            'statut_label'                => $this->statutLabel(),
            'message'                     => $this->message,
            'scheduled_at'                => $this->scheduled_at?->format('d/m/Y H:i'),
            'session_link'                => $this->session_link,
            'platform'                    => $this->platform,
            'estimated_duration'          => $this->estimated_duration,
            'helper_declared_duration'    => $this->helper_declared_duration,
            'requester_declared_duration' => $this->requester_declared_duration,
            'actual_duration'             => $this->actual_duration,
            'helper_confirmed_at'         => $this->helper_confirmed_at?->format('d/m/Y H:i'),
            'requester_confirmed_at'      => $this->requester_confirmed_at?->format('d/m/Y H:i'),
            'both_confirmed'              => $this->isBothConfirmed(),
            'created_at'                  => $this->created_at->format('d/m/Y H:i'),
            'helper'                      => [
                'id'               => $this->helper->id,
                'name'             => $this->helper->name,
                'score_reputation' => $this->helper->score_reputation,
            ],
            'requester'                   => [
                'id'               => $this->requester->id,
                'name'             => $this->requester->name,
                'score_reputation' => $this->requester->score_reputation,
            ],
            'offer'                       => [
                'id'    => $this->offer->id,
                'titre' => $this->offer->titre,
                'skill' => $this->offer->skill->nom,
            ],
            'request'                     => [
                'id'    => $this->request->id,
                'titre' => $this->request->titre,
            ],
        ];
    }

    private function statutLabel(): string 
    {
        return match($this->statut) {
            'pending'   => 'En attente',
            'accepted'  => 'Accepté',
            'refused'   => 'Refusé',
            'completed' => 'Terminé',
            'disputed'  => 'En litige',
            default     => 'Inconnu',
        };
    }
}
