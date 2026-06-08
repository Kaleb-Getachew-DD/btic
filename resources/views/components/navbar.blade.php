<nav class="navbar" id="mainNavbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="navbar-brand">
            <x-site-logo variant="navbar" />
            <div class="navbar-brand-text">
                <div class="brand-name">DDU BTIC</div>
                <div class="brand-sub">Incubation Center</div>
            </div>
        </a>

        <ul class="navbar-nav">
            <li><a href="{{ route('home') }}" class="nav-link{{ request()->routeIs('home') ? ' active' : '' }}">Home</a></li>
            <li><a href="{{ route('about') }}" class="nav-link{{ request()->routeIs('about') ? ' active' : '' }}">About</a></li>
            <li><a href="{{ route('programs.index') }}" class="nav-link{{ request()->routeIs('programs.*') ? ' active' : '' }}">Programs</a></li>
            <li><a href="{{ route('startups.index') }}" class="nav-link{{ request()->routeIs('startups.*') ? ' active' : '' }}">Startups</a></li>
            <li><a href="{{ route('news.index') }}" class="nav-link{{ request()->routeIs('news.*') ? ' active' : '' }}">News</a></li>
            <li><a href="{{ route('contact.index') }}" class="nav-link{{ request()->routeIs('contact.*') ? ' active' : '' }}">Contact</a></li>
            <li><a href="{{ route('apply.track') }}" class="nav-link{{ request()->routeIs('apply.track*') ? ' active' : '' }}">Track Application</a></li>
        </ul>

        <div class="navbar-cta">
            <x-university-badge variant="navbar" :animated="false" />
        </div>

        <button class="navbar-toggle" id="navbarToggle" aria-label="Toggle menu">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</nav>
