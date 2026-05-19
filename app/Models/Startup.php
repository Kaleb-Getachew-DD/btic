<?php
// FILE: app/Models/Startup.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Startup extends Model
{
    protected $fillable = [
        'name','slug','tagline','description','full_story','sector','logo','cover_image',
        'gallery','website','email','phone','founded_year','location','founder_name',
        'founder_title','founder_photo','founder_bio','team_size','stage','cohort_batch',
        'linkedin','twitter','facebook','achievements','metrics','is_featured','is_active','sort_order',
    ];

    protected $casts = [
        'gallery' => 'array',
        'achievements' => 'array',
        'metrics' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($startup) {
            if (empty($startup->slug)) {
                $startup->slug = Str::slug($startup->name);
            }
        });
    }

    public function getLogoUrlAttribute(): string
    {
        return $this->logo ? asset('storage/' . $this->logo) : asset('images/default-startup.png');
    }

    public function getCoverUrlAttribute(): string
    {
        return $this->cover_image ? asset('storage/' . $this->cover_image) : asset('images/default-cover.jpg');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
