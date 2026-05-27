<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand">
        <x-site-logo variant="sidebar" />
        <div class="sidebar-brand-text">
            <div class="name">DDU BTIC</div>
            <div class="sub">Admin Panel</div>
        </div>
    </div>

    <nav class="sidebar-nav">

        <div class="sidebar-group">
            <div class="sidebar-group-label">Overview</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                <i class="fas fa-th-large sidebar-icon"></i>
                Dashboard
            </a>
        </div>

        <div class="sidebar-group">
            <div class="sidebar-group-label">Applications</div>
            <a href="{{ route('admin.applications.index') }}" class="sidebar-link">
                <i class="fas fa-file-alt sidebar-icon"></i>
                Applications
                @php $pending = \App\Models\Application::where('status','pending')->count(); @endphp
                @if($pending > 0)
                    <span class="sidebar-badge">{{ $pending }}</span>
                @endif
            </a>
            <a href="{{ route('admin.cohorts.index') }}" class="sidebar-link">
                <i class="fas fa-layer-group sidebar-icon"></i>
                Cohorts
            </a>
        </div>

        <div class="sidebar-group">
            <div class="sidebar-group-label">Portfolio</div>
            <a href="{{ route('admin.startups.index') }}" class="sidebar-link">
                <i class="fas fa-rocket sidebar-icon"></i>
                Startups
            </a>
            <a href="{{ route('admin.news.index') }}" class="sidebar-link">
                <i class="fas fa-newspaper sidebar-icon"></i>
                News & Blog
            </a>
        </div>

        <div class="sidebar-group">
            <div class="sidebar-group-label">Content</div>
            <a href="{{ route('admin.programs.index') }}" class="sidebar-link">
                <i class="fas fa-graduation-cap sidebar-icon"></i>
                Programs
            </a>
            <a href="{{ route('admin.services.index') }}" class="sidebar-link">
                <i class="fas fa-concierge-bell sidebar-icon"></i>
                Services
            </a>
            <a href="{{ route('admin.team.index') }}" class="sidebar-link">
                <i class="fas fa-users sidebar-icon"></i>
                Team Members
            </a>
        </div>

        <div class="sidebar-group">
            <div class="sidebar-group-label">System</div>
            <a href="{{ route('admin.profile.edit') }}" class="sidebar-link">
                <i class="fas fa-user-circle sidebar-icon"></i>
                My Profile
            </a>
            <a href="{{ route('admin.password-resets.index') }}" class="sidebar-link">
                <i class="fas fa-key sidebar-icon"></i>
                Password Requests
                @php $pendingResets = \App\Models\PasswordResetRequest::where('status','pending')->count(); @endphp
                @if($pendingResets > 0)
                    <span class="sidebar-badge">{{ $pendingResets }}</span>
                @endif
            </a>
            <a href="{{ route('admin.notifications.index') }}" class="sidebar-link">
                <i class="fas fa-bell sidebar-icon"></i>
                Notifications
                @php $unread = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count(); @endphp
                @if($unread > 0)
                    <span class="sidebar-badge">{{ $unread }}</span>
                @endif
            </a>
            <a href="{{ route('admin.settings.index') }}" class="sidebar-link">
                <i class="fas fa-cog sidebar-icon"></i>
                Settings
            </a>
        </div>

    </nav>

    <div class="sidebar-footer">
        <a href="{{ route('home') }}" class="sidebar-user" target="_blank">
            <div class="sidebar-user-avatar">
                <i class="fas fa-globe" style="font-size:0.8rem;"></i>
            </div>
            <div>
                <div class="sidebar-user-name">View Website</div>
                <div class="sidebar-user-role">Public View</div>
            </div>
            <i class="fas fa-external-link-alt sidebar-user-action" style="font-size:0.65rem;"></i>
        </a>

        <div style="height:8px;"></div>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="sidebar-user" style="width:100%;background:none;border:none;cursor:pointer;text-align:left;">
                <div class="sidebar-user-avatar" style="background:linear-gradient(135deg,#EF4444,#DC2626);">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                    <div class="sidebar-user-role">{{ str_replace('_', ' ', auth()->user()->role) }}</div>
                </div>
                <i class="fas fa-sign-out-alt sidebar-user-action"></i>
            </button>
        </form>
    </div>
</aside>
