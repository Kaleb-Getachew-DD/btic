<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — DDU BTIC</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="admin-login-body">
    <div class="admin-login-bg"></div>
    <div class="admin-login-grid-lines"></div>

    {{-- Left Panel --}}
    <div class="admin-login-left">
        <div class="admin-login-brand">
            <x-site-logo variant="login" />
            <h1 class="admin-login-brand-name">DDU BTIC<br>Admin Panel</h1>
            <p class="admin-login-brand-desc">
                Manage applications, startups, news, and all content for Dire Dawa University's
                Business and Technology Incubation Center.
            </p>
            <div class="admin-login-features">
                <div class="admin-login-feature">
                    <div class="admin-login-feature-icon"><i class="fas fa-file-alt"></i></div>
                    <div class="admin-login-feature-text">
                        <div class="title">Application Management</div>
                        <div class="sub">Review and process startup incubation applications</div>
                    </div>
                </div>
                <div class="admin-login-feature">
                    <div class="admin-login-feature-icon"><i class="fas fa-rocket"></i></div>
                    <div class="admin-login-feature-text">
                        <div class="title">Startup Portfolio</div>
                        <div class="sub">Showcase successful incubatees to investors</div>
                    </div>
                </div>
                <div class="admin-login-feature">
                    <div class="admin-login-feature-icon"><i class="fas fa-sliders-h"></i></div>
                    <div class="admin-login-feature-text">
                        <div class="title">Full CMS Control</div>
                        <div class="sub">Customize every aspect of the public website</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Form Panel --}}
    <div class="admin-login-right">
        <div class="admin-login-form-container">
            <div class="admin-login-form-header">
                <h2 class="admin-login-form-title">Welcome back</h2>
                <p class="admin-login-form-sub">Sign in to access the BTIC admin dashboard</p>
            </div>

            @if(session('success'))
                <div class="admin-alert success" style="margin-bottom:20px;" data-auto-dismiss="4000">
                    <i class="fas fa-check-circle admin-alert-icon"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="admin-alert error" style="margin-bottom:20px;">
                    <i class="fas fa-exclamation-circle admin-alert-icon"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf

                <div class="login-form-group">
                    <label class="login-label" for="email">Email Address</label>
                    <div class="login-input-wrapper">
                        <i class="fas fa-envelope login-input-icon"></i>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="login-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            value="{{ old('email') }}"
                            placeholder="admin@ddu.edu.et"
                            autocomplete="email"
                            required
                        >
                    </div>
                    @error('email')
                        <div style="font-size:0.75rem;color:#EF4444;margin-top:5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="login-form-group">
                    <label class="login-label" for="password">Password</label>
                    <div class="login-input-wrapper">
                        <i class="fas fa-lock login-input-icon"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="login-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >
                        <button type="button" class="login-toggle-pwd" id="togglePwd">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div style="font-size:0.75rem;color:#EF4444;margin-top:5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="login-options">
                    <label class="login-remember">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Remember me
                    </label>
                </div>

                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt" style="margin-right:8px;"></i>
                    Sign In to Dashboard
                </button>
            </form>

            <div class="login-back-link">
                <i class="fas fa-arrow-left"></i>
                <span>Back to</span>
                <a href="{{ route('home') }}">public website</a>
            </div>

            <div style="margin-top:32px;padding:14px;background:#F8FAFC;border-radius:8px;border:1px solid #E2E8F0;">
                <p style="font-size:0.72rem;color:#94A3B8;text-align:center;margin-bottom:6px;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;">Demo Credentials</p>
                <p style="font-size:0.75rem;color:#64748B;text-align:center;">admin@ddu.edu.et / Admin@2024!</p>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/admin.js') }}"></script>
@if(session('logged_out'))
<script>
    (function () {
        if (window.history && window.history.replaceState) {
            window.history.replaceState(null, document.title, window.location.href);
        }
        window.addEventListener('popstate', function () {
            window.location.replace('{{ route('admin.login') }}');
        });
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    })();
</script>
@endif
</body>
</html>
