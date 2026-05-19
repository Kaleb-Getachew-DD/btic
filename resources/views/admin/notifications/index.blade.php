@extends('layouts.admin')
@section('title', 'Notifications')
@section('breadcrumb')<span class="topbar-breadcrumb-item current">Notifications</span>@endsection

@section('content')
<div class="page-header">
    <div><h1 class="page-title">Notifications</h1><p class="page-subtitle">System alerts and activity feed</p></div>
    <div class="page-actions">
        <form method="POST" action="{{ route('admin.notifications.read-all') }}">
            @csrf
            <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-check-double"></i> Mark All Read</button>
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <div class="admin-card-title">All Notifications</div>
        @php $unread = $notifications->where('is_read', false)->count(); @endphp
        @if($unread > 0)
            <span class="badge badge-primary">{{ $unread }} unread</span>
        @endif
    </div>
    @forelse($notifications as $notif)
    <div class="notification-item {{ !$notif->is_read ? 'unread' : '' }}">
        <div class="notification-icon {{ ['new_application'=>'red','application_status'=>'green','new_message'=>'yellow'][$notif->type] ?? 'blue' }}">
            <i class="fas {{ $notif->icon }}"></i>
        </div>
        <div class="notification-body">
            <div class="notification-title">{{ $notif->title }}</div>
            <div class="notification-message">{{ $notif->message }}</div>
            <div class="notification-time">
                <i class="fas fa-clock" style="margin-right:4px;"></i>{{ $notif->created_at->diffForHumans() }}
                @if($notif->action_url)
                    · <a href="{{ $notif->action_url }}" style="color:var(--crimson);font-weight:500;">View Details →</a>
                @endif
            </div>
        </div>
        <div class="notification-actions">
            @if(!$notif->is_read)
                <div class="notification-unread-dot"></div>
                <form method="POST" action="{{ route('admin.notifications.mark-read', $notif) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-xs btn-secondary" title="Mark as read"><i class="fas fa-check"></i></button>
                </form>
            @endif
            <form method="POST" action="{{ route('admin.notifications.destroy', $notif) }}" onsubmit="return confirm('Delete notification?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
            </form>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <div class="empty-state-icon"><i class="fas fa-bell-slash"></i></div>
        <div class="empty-state-title">No notifications</div>
        <div class="empty-state-desc">You're all caught up!</div>
    </div>
    @endforelse
</div>
@if($notifications->hasPages())<div style="margin-top:20px;">{{ $notifications->links() }}</div>@endif
@endsection
