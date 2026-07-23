<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'nom',
        'categorie',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_skill')
                    ->withPivot('niveau', 'source', 'confidence_score')
                    ->withTimestamps();
    }

    public function serviceOffers()
    {
        return $this->hasMany(ServiceOffer::class);
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }
}



