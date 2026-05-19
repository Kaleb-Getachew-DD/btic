<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title','description','icon','image','category','features','is_active','sort_order',
    ];

    protected $casts = [
        'features'  => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($q) { return $q->where('is_active', true)->orderBy('sort_order'); }
}
