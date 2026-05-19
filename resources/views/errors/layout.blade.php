<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — DDU BTIC</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --crimson: #8C1D35;
            --gold: #C8A032;
            --navy: #1C2854;
            --text: #0F172A;
            --muted: #64748B;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(145deg, #f8fafc 0%, #eef2f7 45%, #fff 100%);
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .error-card {
            max-width: 520px;
            width: 100%;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(28, 40, 84, 0.12);
            overflow: hidden;
            text-align: center;
        }
        .error-banner {
            background: linear-gradient(135deg, var(--navy) 0%, var(--crimson) 100%);
            padding: 36px 28px 28px;
            color: #fff;
        }
        .error-code {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -2px;
            opacity: 0.95;
        }
        .error-icon {
            font-size: 2rem;
            margin-top: 12px;
            color: var(--gold);
        }
        .error-body { padding: 28px 32px 32px; }
        .error-title {
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--navy);
        }
        .error-message {
            font-size: 0.95rem;
            color: var(--muted);
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .error-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 20px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s;
        }
        .btn:hover { transform: translateY(-1px); }
        .btn-primary {
            background: var(--crimson);
            color: #fff;
            box-shadow: 0 4px 14px rgba(140, 29, 53, 0.35);
        }
        .btn-secondary {
            background: #f1f5f9;
            color: var(--navy);
        }
        .error-brand {
            margin-top: 20px;
            font-size: 0.75rem;
            color: #94a3b8;
            letter-spacing: 0.04em;
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-banner">
            <div class="error-code">@yield('code')</div>
            <div class="error-icon"><i class="fas @yield('icon', 'fa-circle-exclamation')"></i></div>
        </div>
        <div class="error-body">
            <h1 class="error-title">@yield('heading')</h1>
            <p class="error-message">@yield('message')</p>
            <div class="error-actions">
                @php
                    $isAdmin = auth('admin')->check();
                    $homeUrl = $isAdmin ? route('admin.dashboard') : route('home');
                    $homeLabel = $isAdmin ? 'Back to Dashboard' : 'Back to Home';
                @endphp
                <a href="{{ $homeUrl }}" class="btn btn-primary">
                    <i class="fas fa-gauge-high"></i> {{ $homeLabel }}
                </a>
                <button type="button" class="btn btn-secondary" onclick="history.length > 1 ? history.back() : window.location.href='{{ $homeUrl }}'">
                    <i class="fas fa-arrow-left"></i> Go Back
                </button>
            </div>
            <p class="error-brand">Dire Dawa University · Business &amp; Technology Incubation Center</p>
        </div>
    </div>
</body>
</html>
