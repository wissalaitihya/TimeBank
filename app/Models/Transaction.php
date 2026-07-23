<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'service_match_id',
        'from_user_id',
        'to_user_id',
        'heures',
        'type',
        'description',
    ];

    protected $casts = [
        'heures' => 'decimal:2',
    ];

    public function match()
    {
        return $this->belongsTo(ServiceMatch::class, 'service_match_id');
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}