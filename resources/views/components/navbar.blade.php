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
            <li><a href="{{ route('home') }}" class="nav-link">Home</a></li>
            <li><a href="{{ route('about') }}" class="nav-link">About</a></li>
            <li><a href="{{ route('programs.index') }}" class="nav-link">Programs</a></li>
            <li><a href="{{ route('startups.index') }}" class="nav-link">Startups</a></li>
            <li><a href="{{ route('news.index') }}" class="nav-link">News</a></li>
            <li><a href="{{ route('contact.index') }}" class="nav-link">Contact</a></li>
            <li><a href="{{ route('apply.track') }}" class="nav-link">Track Application</a></li>
        </ul>

        <div class="navbar-cta">
            <a href="{{ route('apply.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-paper-plane"></i> Apply Now
            </a>
        </div>

        <button class="navbar-toggle" id="navbarToggle" aria-label="Toggle menu">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</nav>
