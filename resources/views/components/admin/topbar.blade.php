<header class="admin-topbar">
    <div class="topbar-left">
        <button class="topbar-menu-btn" id="sidebarToggle" aria-label="Toggle sidebar">
            <i class="fas fa-bars"></i>
        </button>
        <div class="topbar-breadcrumb">
            <span class="topbar-breadcrumb-item">
                <i class="fas fa-home" style="font-size:0.75rem;"></i>
            </span>
            <span class="topbar-breadcrumb-sep">/</span>
            @yield('breadcrumb', '<span class="topbar-breadcrumb-item current">Dashboard</span>')
        </div>
    </div>

    <div class="topbar-right">
        <a href="{{ route('home') }}" class="topbar-btn" title="View Website" target="_blank">
            <i class="fas fa-external-link-alt"></i>
        </a>

        <a href="{{ route('admin.notifications.index') }}" class="topbar-btn" title="Notifications">
            <i class="fas fa-bell"></i>
            @php $unreadCount = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count(); @endphp
            @if($unreadCount > 0)
                <span class="topbar-notif-dot"></span>
            @endif
        </a>

        <div style="position:relative;" id="userDropdownWrapper">
            <div class="topbar-user" id="topbarUserBtn">
                <div class="topbar-user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="topbar-user-name">{{ auth()->user()->name }}</span>
                <i class="fas fa-chevron-down topbar-user-arrow"></i>
            </div>
            <div id="userDropdown" style="display:none;position:absolute;top:calc(100% + 8px);right:0;background:white;border:1px solid rgba(29,64,154,0.14);border-radius:10px;box-shadow:0 10px 30px rgba(29,64,154,0.12);min-width:200px;z-index:200;overflow:hidden;">
                <div style="padding:14px 16px;border-bottom:1px solid rgba(29,64,154,0.14);">
                    <div style="font-size:0.85rem;font-weight:700;color:#000000;">{{ auth()->user()->name }}</div>
                    <div style="font-size:0.75rem;color:#5A6B8C;">{{ auth()->user()->email }}</div>
                </div>
                <a href="{{ route('admin.settings.index') }}" style="display:flex;align-items:center;gap:10px;padding:11px 16px;font-size:0.85rem;color:#2C3E6B;transition:all 0.2s;">
                    <i class="fas fa-cog" style="width:14px;color:#5A6B8C;"></i> Settings
                </a>
                <div style="border-top:1px solid rgba(29,64,154,0.14);"></div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" style="display:flex;align-items:center;gap:10px;padding:11px 16px;font-size:0.85rem;color:#142D6E;background:none;border:none;cursor:pointer;width:100%;text-align:left;">
                        <i class="fas fa-sign-out-alt" style="width:14px;"></i> Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

@push('scripts')
<script>
    (function() {
        const btn = document.getElementById('topbarUserBtn');
        const dropdown = document.getElementById('userDropdown');
        if (!btn || !dropdown) return;
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        });
        document.addEventListener('click', () => { dropdown.style.display = 'none'; });
    })();
</script>
@endpush
