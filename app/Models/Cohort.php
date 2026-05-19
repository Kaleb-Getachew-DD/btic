<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cohort extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'batch_number', 'application_start',
        'application_end', 'program_start', 'program_end', 'max_startups',
        'status', 'focus_areas', 'image',
    ];

    protected $casts = [
        'focus_areas' => 'array',
        'application_start' => 'date',
        'application_end' => 'date',
        'program_start' => 'date',
        'program_end' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($cohort) {
            if (empty($cohort->slug)) {
                $cohort->slug = Str::slug($cohort->name);
            }
        });
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function isOpen(): bool
    {
        return $this->status === 'open'
            && now()->between($this->application_start, $this->application_end);
    }

    public function getApplicationsCountAttribute(): int
    {
        return $this->applications()->count();
    }

    public function getApprovedCountAttribute(): int
    {
        return $this->applications()->where('status', 'approved')->count();
    }
}
