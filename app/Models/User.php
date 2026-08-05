<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\ServiceOffer;
use App\Models\ServiceRequest;
use App\Models\Skill;
use App\Models\ServiceMatch;
use App\Models\Transaction;
use App\Models\Review;
use App\Models\Dispute;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'username',
    'email',
    'password',
    'bio',
    'niveau',
    'disponibilites',
    'solde_heures',
    'score_reputation',
    'statut_compte',
    'github_id',
    'github_username',
    'github_access_token',
    'ai_generated_bio',
    'ai_bio_metadata',
    'api_token',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'bio',
        'niveau',
        'disponibilites',
        'solde_heures',
        'score_reputation',
        'statut_compte',
        'github_id',
        'github_username',
        'github_access_token',
        'ai_generated_bio',
        'ai_bio_metadata',
        'api_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'github_access_token',
        'api_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'disponibilites' => 'array',
        'ai_generated_bio' => 'array',
        'ai_bio_metadata' => 'array',
        'solde_heures' => 'decimal:2',
        'score_reputation' => 'integer',
    ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skill')
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

    public function matchesAsHelper()
    {
        return $this->hasMany(ServiceMatch::class, 'helper_id');
    }

    public function matchesAsRequester()
    {
        return $this->hasMany(ServiceMatch::class, 'requester_id');
    }

    public function transactionsSent()
    {
        return $this->hasMany(Transaction::class, 'from_user_id');
    }

    public function transactionsReceived()
    {
        return $this->hasMany(Transaction::class, 'to_user_id');
    }

    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'reviewed_id');
    }

    public function disputes()
    {
        return $this->hasMany(Dispute::class, 'opened_by');
    }

    public function isGele(): bool
    {
        return $this->statut_compte === 'gele';
    }

    public function isSoldeWarning(): bool
    {
        return $this->solde_heures < 0.5;
    }

    public function updateReputation(): void
    {
        $avg = $this->reviewsReceived()->avg('note');
        $this->update([
            'score_reputation' => $avg ? round($avg * 20) : 0,
        ]);
    }

    public function checkAndFreeze(): void
    {
        if ($this->solde_heures < -2.00) {
            $this->update(['statut_compte' => 'gele']);
        } else {
            $this->update(['statut_compte' => 'actif']);
        }
    }

}






