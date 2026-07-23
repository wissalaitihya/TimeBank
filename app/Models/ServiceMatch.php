<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceMatch extends Model
{
    protected $fillable = [
        'offer_id',
        'request_id',
        'helper_id',
        'requester_id',
        'proposed_by',
        'message',
        'statut',
        'scheduled_at',
        'session_link',
        'platform',
        'estimated_duration',
        'helper_declared_duration',
        'requester_declared_duration',
        'actual_duration',
        'helper_confirmed_at',
        'requester_confirmed_at',
    ];

    protected $casts = [
        'scheduled_at'               => 'datetime',
        'helper_confirmed_at'        => 'datetime',
        'requester_confirmed_at'     => 'datetime',
        'estimated_duration'         => 'decimal:2',
        'helper_declared_duration'   => 'decimal:2',
        'requester_declared_duration'=> 'decimal:2',
        'actual_duration'            => 'decimal:2',
    ];

    public function offer()
    {
        return $this->belongsTo(ServiceOffer::class, 'offer_id');
    }

    public function request()
    {
        return $this->belongsTo(ServiceRequests::class, 'request_id');
    }

    public function helper()
    {
        return $this->belongsTo(User::class, 'helper_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function proposedBy()
    {
        return $this->belongsTo(User::class, 'proposed_by');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'service_match_id');
    }

    public function dispute()
    {
        return $this->hasOne(Dispute::class, 'service_match_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'service_match_id');
    }

    public function isBothConfirmed(): bool
    {
        return $this->helper_confirmed_at !== null
            && $this->requester_confirmed_at !== null;
    }

    public function isDisputed(): bool
    {
        return $this->statut === 'disputed';
    }
}

