<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
     protected $table = 'dispute';
    protected $fillable = [
        'service_match_id',
        'opened_by',
        'resolved_by',
        'reason',
        'description',
        'status',
        'admin_decision',
        'approved_duration',
        'opened_at',
        'resolved_at',
    ];

   protected $casts = [
        'opened_at'         => 'datetime',
        'resolved_at'       => 'datetime',
        'approved_duration' => 'decimal:2',
    ];

    public function match()
    {
        return $this->belongsTo(ServiceMatch::class, 'service_match_id');
    }

    public function openedBy()
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    public function resolvedBy()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
}
