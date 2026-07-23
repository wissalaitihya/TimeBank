<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'service_match_id',
        'reviewer_id',
        'reviewed_id',
        'note',
        'commentaire',
        'tags',
    ];

    protected $casts = [
        'tags' => 'array',
        'note' => 'integer',
    ];

    public function match()
    {
        return $this->belongsTo(ServiceMatch::class, 'service_match_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function reviewed()
    {
        return $this->belongsTo(User::class, 'reviewed_id');
    }
}