<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id','type','title','message','data','action_url','is_read','read_at',
    ];

    protected $casts = [
        'data'    => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead(): void
    {
        $this->update(['is_read' => true, 'read_at' => now()]);
    }

    public function getIconAttribute(): string
    {
        return match($this->type) {
            'new_application' => 'fa-file-alt',
            'application_status' => 'fa-check-circle',
            'new_message' => 'fa-envelope',
            default => 'fa-bell',
        };
    }

    public function getIconColorAttribute(): string
    {
        return match($this->type) {
            'new_application' => 'text-primary',
            'application_status' => 'text-success',
            'new_message' => 'text-warning',
            default => 'text-info',
        };
    }

    public static function notifyAdmins(string $type, string $title, string $message, array $data = [], ?string $actionUrl = null): void
    {
        $admins = User::whereIn('role', ['super_admin', 'admin'])->where('is_active', true)->get();
        foreach ($admins as $admin) {
            static::create([
                'user_id'    => $admin->id,
                'type'       => $type,
                'title'      => $title,
                'message'    => $message,
                'data'       => $data,
                'action_url' => $actionUrl,
            ]);
        }
    }
}
