<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Program extends Model
{
    protected $fillable = [
        'title','slug','short_description','full_description','icon','image',
        'duration','eligibility','benefits','curriculum','is_active','sort_order',
    ];

    protected $casts = [
        'benefits'   => 'array',
        'curriculum' => 'array',
        'is_active'  => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($m) {
            if (empty($m->slug)) $m->slug = Str::slug($m->title);
        });
    }

    public function scopeActive($q) { return $q->where('is_active', true)->orderBy('sort_order'); }
}
