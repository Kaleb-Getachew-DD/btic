<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $table = 'team_members';

    protected $fillable = [
        'name','title','bio','photo','email','phone',
        'linkedin','twitter','department','is_active','sort_order',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function getPhotoUrlAttribute(): string
    {
        return $this->photo ? asset('storage/' . $this->photo) : asset('images/default-avatar.png');
    }

    public function scopeActive($q) { return $q->where('is_active', true)->orderBy('sort_order'); }
}
