<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DDU BTIC') — Dire Dawa University Incubation Center</title>
    <meta name="description" content="@yield('meta_description', 'Dire Dawa University Business and Technology Incubation Center — nurturing innovative startups across Ethiopia.')">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- App CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')
</head>
<body>

    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Mobile Menu --}}
    <div class="mobile-menu" id="mobileMenu">
        <a href="{{ route('home') }}" class="mobile-nav-link">
            <i class="fas fa-home"></i> Home
        </a>
        <a href="{{ route('about') }}" class="mobile-nav-link">
            <i class="fas fa-info-circle"></i> About Us
        </a>
        <a href="{{ route('programs.index') }}" class="mobile-nav-link">
            <i class="fas fa-rocket"></i> Programs & Services
        </a>
        <a href="{{ route('startups.index') }}" class="mobile-nav-link">
            <i class="fas fa-lightbulb"></i> Startups
        </a>
        <a href="{{ route('news.index') }}" class="mobile-nav-link">
            <i class="fas fa-newspaper"></i> News
        </a>
        <a href="{{ route('contact.index') }}" class="mobile-nav-link">
            <i class="fas fa-envelope"></i> Contact
        </a>
        <div style="padding: 24px 16px;">
            <a href="{{ route('apply.create') }}" class="btn btn-primary" style="width:100%;justify-content:center;">
                <i class="fas fa-paper-plane"></i> Apply for Incubation
            </a>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="container" style="padding-top:12px;">
            <div class="alert alert-success" data-auto-dismiss="5000">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

    {{-- App JS --}}
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
