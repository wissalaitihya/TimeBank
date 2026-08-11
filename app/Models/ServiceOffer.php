<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceOffer extends Model
{
    Use SoftDeletes;

    protected $fillable = [
      'user_id',
      'skill_id',
      'titre',
      'description',
      'duree_estimee',
      'disponibilities',
      'statut',
    ];

    protected $casts =[
        'disponibilities' => 'array',
        'duree_estimee' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skill()
    {
        return$this->belongsTo(Skill::class);
    }

    public function matches()
    {
        return $this->hasMany(ServiceMatch::class, 'offer_id');
    }
}






