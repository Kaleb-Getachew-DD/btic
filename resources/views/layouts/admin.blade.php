<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — DDU BTIC Admin</title>

    @php $faviconUrl = \App\Models\Setting::assetUrl('site_favicon'); @endphp
    <link rel="icon" href="{{ $faviconUrl ?? asset('images/favicon.ico') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="admin-shell">

    {{-- Sidebar --}}
    @include('components.admin.sidebar')

    {{-- Main --}}
    <div class="admin-main">

        {{-- Topbar --}}
        @include('components.admin.topbar')

        {{-- Content --}}
        <div class="admin-content">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="admin-alert success" data-auto-dismiss="4000">
                    <i class="fas fa-check-circle admin-alert-icon"></i>
                    <div class="admin-alert-content">{{ session('success') }}</div>
                </div>
            @endif
            @if(session('error'))
                <div class="admin-alert error" data-auto-dismiss="5000">
                    <i class="fas fa-exclamation-circle admin-alert-icon"></i>
                    <div class="admin-alert-content">{{ session('error') }}</div>
                </div>
            @endif
            @if($errors->any())
                <div class="admin-alert error">
                    <i class="fas fa-exclamation-triangle admin-alert-icon"></i>
                    <div class="admin-alert-content">
                        <div class="admin-alert-title">Please fix the following errors:</div>
                        @foreach($errors->all() as $error)
                            <div>• {{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<script src="{{ asset('js/admin.js') }}"></script>
@stack('scripts')
</body>
</html>
