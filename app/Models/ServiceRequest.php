<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $fillable = [
        'user_id',
        'skill_id',
        'titre',
        'duree_estimee',
        'description',
        'urgence',
        'statut',
        'ai_status',
        'ai_suggestion',
    ];

    protected $casts = [
        'ai_suggestion' => 'array',
        'duree_estimee' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function matches()
    {
        return $this->hasMany(ServiceMatch::class, 'request_id');
    }
}
