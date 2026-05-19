<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Application extends Model
{
    protected $fillable = [
        'cohort_id', 'startup_name', 'tagline', 'description', 'sector', 'stage',
        'website', 'founder_name', 'founder_email', 'founder_phone', 'founder_gender',
        'founder_age_range', 'founder_education', 'university_affiliation',
        'team_size', 'team_background', 'problem_statement', 'solution',
        'target_market', 'business_model', 'competitive_advantage',
        'current_traction', 'monthly_revenue', 'has_funding', 'funding_details',
        'support_needed', 'why_btic', 'goals', 'pitch_deck', 'business_plan',
        'status', 'review_notes', 'reviewed_by', 'reviewed_at', 'reference_number',
    ];

    protected $casts = [
        'support_needed' => 'array',
        'has_funding' => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($application) {
            $application->reference_number = 'BTIC-' . strtoupper(Str::random(8));
        });
    }

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'pending'      => 'badge-warning',
            'under_review' => 'badge-info',
            'shortlisted'  => 'badge-primary',
            'approved'     => 'badge-success',
            'rejected'     => 'badge-danger',
            'withdrawn'    => 'badge-secondary',
            default        => 'badge-secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'      => 'Pending',
            'under_review' => 'Under Review',
            'shortlisted'  => 'Shortlisted',
            'approved'     => 'Approved',
            'rejected'     => 'Rejected',
            'withdrawn'    => 'Withdrawn',
            default        => ucfirst($this->status),
        };
    }
}
