<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password — DDU BTIC</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="admin-login-body">
    <div class="admin-login-bg"></div>
    <div class="admin-login-grid-lines"></div>

    <div class="admin-login-left">
        <div class="admin-login-brand">
            <x-site-logo variant="login" />
            <h1 class="admin-login-brand-name">DDU BTIC<br>Password Help</h1>
            <p class="admin-login-brand-desc">
                Enter your email and we will notify the administrator to reset your password.
            </p>
        </div>
    </div>

    <div class="admin-login-right">
        <div class="admin-login-form-container">
            <div class="admin-login-form-header">
                <h2 class="admin-login-form-title">Forgot password</h2>
                <p class="admin-login-form-sub">We’ll send your email to the admin</p>
            </div>

            @if($errors->any())
                <div class="admin-alert error" style="margin-bottom:20px;">
                    <i class="fas fa-exclamation-triangle admin-alert-icon"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.forgot-password.store') }}">
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
                            placeholder="you@example.com"
                            autocomplete="email"
                            required
                        >
                    </div>
                    @error('email')
                        <div style="font-size:0.75rem;color:#EF4444;margin-top:5px;">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="login-btn">
                    <i class="fas fa-paper-plane" style="margin-right:8px;"></i>
                    Send Request
                </button>
            </form>

            <div class="login-back-link" style="justify-content:center;">
                <a href="{{ route('admin.login') }}" style="display:inline-flex;gap:8px;align-items:center;">
                    <i class="fas fa-arrow-left"></i>
                    Back to login
                </a>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>

