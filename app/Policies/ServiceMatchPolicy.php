<?php

namespace App\Policies;

use App\Models\ServiceMatch;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ServiceMatchPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ServiceMatch $match): bool
    {
        return $user->id === $match->helper_id || $user->id ===$match->requester_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->statut_compte === 'actif';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function accept(User $user, ServiceMatch $match): bool
    {
        return $user->id === $match->requester_id && $match->statut === 'pending';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function refuse(User $user, ServiceMatch $match): bool
    {
        return $user->id === $match->requester_id && $match->statut === 'pending';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function scheldule(User $user, ServiceMatch $match): bool
    {
        return ($user->id === $match->helper_id || $user->id === $match->requester_id) && $match->statut === 'accepted';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function confirm(User $user, ServiceMatch $match): bool
    {
        if ($user->id === $match->helper_id){
            return $match->statut === 'accepted' && $match->helper_confirmed_at === null;
        }

        if ($user->id === $match->requester_id){
            return $match->statut === 'accepted' && $match->requester_confirmed_at === null;
        }

        return false;
    }

    public function dispute(User $user, ServiceMatch $match):bool 
    {
     return ($user->id === $match->helper_id || $user->id === $match->requester_id) && $match->statut === 'accepted';
    }
}
