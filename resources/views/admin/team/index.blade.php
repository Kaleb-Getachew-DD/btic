{{-- FILE: resources/views/admin/team/index.blade.php --}}
@extends('layouts.admin')
@section('title','Team Members')
@section('breadcrumb')<span class="topbar-breadcrumb-item current">Team Members</span>@endsection
@section('content')
<div class="page-header">
    <div><h1 class="page-title">Team Members</h1><p class="page-subtitle">Manage BTIC team members displayed on the website</p></div>
    <a href="{{ route('admin.team.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Member</a>
</div>
<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead><tr><th>Member</th><th>Title</th><th>Department</th><th>Contact</th><th>Status</th><th>Order</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($members as $member)
            <tr>
                <td><div class="td-avatar">
                    @if($member->photo)<img src="{{ asset('storage/'.$member->photo) }}" alt="" class="td-avatar-img" style="border-radius:50%;">
                    @else<div class="td-avatar-placeholder" style="border-radius:50%;">{{ strtoupper(substr($member->name,0,1)) }}</div>@endif
                    <div class="td-name">{{ $member->name }}</div>
                </div></td>
                <td class="muted">{{ $member->title }}</td>
                <td>@if($member->department)<span class="badge badge-primary">{{ $member->department }}</span>@else—@endif</td>
                <td class="muted" style="font-size:0.78rem;">{{ $member->email ?? '—' }}</td>
                <td>@if($member->is_active)<span class="badge badge-success badge-dot">Active</span>@else<span class="badge badge-secondary">Hidden</span>@endif</td>
                <td class="muted">{{ $member->sort_order }}</td>
                <td><div class="td-actions">
                    <a href="{{ route('admin.team.edit',$member) }}" class="btn btn-xs btn-secondary"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{ route('admin.team.destroy',$member) }}" onsubmit="return confirm('Remove this team member?')">@csrf @method('DELETE')<button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button></form>
                </div></td>
            </tr>
            @empty
            <tr><td colspan="7"><div class="empty-state"><div class="empty-state-icon"><i class="fas fa-users"></i></div><div class="empty-state-title">No team members</div><a href="{{ route('admin.team.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add First Member</a></div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($members->hasPages())<div style="margin-top:20px;">{{ $members->links() }}</div>@endif
@endsection
