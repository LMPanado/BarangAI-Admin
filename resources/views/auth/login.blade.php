<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Barangay 419</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brgy_logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800&display=swap');
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            background: #0f172a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-panel {
            display: flex;
            width: 900px;
            max-width: 96vw;
            min-height: 520px;
            border-radius: 2rem;
            overflow: hidden;
            box-shadow: 0 40px 80px rgba(0,0,0,0.5);
        }

        /* Left decorative panel */
        .login-left {
            flex: 1;
            background: linear-gradient(160deg, #1e3a8a 0%, #0f172a 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: repeating-linear-gradient(
                60deg,
                transparent,
                transparent 38px,
                rgba(255,255,255,0.03) 38px,
                rgba(255,255,255,0.03) 39px
            );
        }

        .login-left::after {
            content: '';
            position: absolute;
            bottom: -80px;
            right: -80px;
            width: 260px;
            height: 260px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }

        /* Right form panel */
        .login-right {
            width: 400px;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3.5rem 3rem;
        }

        .input-field {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            transition: all 0.2s ease;
            width: 100%;
            padding: 0.85rem 1.1rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            outline: none;
            color: #1e293b;
        }

        .input-field:focus {
            background: #fff;
            border-color: #1e3a8a;
            box-shadow: 0 0 0 4px rgba(30, 58, 138, 0.08);
        }

        .btn-signin {
            width: 100%;
            background: #1e3a8a;
            color: white;
            font-weight: 700;
            font-size: 0.875rem;
            letter-spacing: 0.05em;
            padding: 0.9rem;
            border-radius: 0.75rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 0.5rem;
        }

        .btn-signin:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(30,58,138,0.25);
        }

        .btn-signin:active { transform: scale(0.98); }

        @media (max-width: 640px) {
            .login-left { display: none; }
            .login-right { width: 100%; padding: 2.5rem 2rem; border-radius: 2rem; }
        }
    </style>
</head>
<body class="antialiased">

    <div class="login-panel">

        {{-- Left: Branding --}}
        <div class="login-left">
            <div style="position:relative;z-index:1;text-align:center;">
                <img src="{{ asset('images/brgy_logo.png') }}"
                     style="width:88px;height:88px;margin:0 auto 1.5rem;filter:drop-shadow(0 4px 16px rgba(0,0,0,0.4));"
                     alt="Barangay 419 Logo">
                <h1 style="color:#fff;font-size:1.5rem;font-weight:800;letter-spacing:-0.02em;margin-bottom:0.5rem;">Barangay 419</h1>
                <p style="color:rgba(255,255,255,0.5);font-size:0.75rem;font-weight:600;letter-spacing:0.12em;text-transform:uppercase;">Sampaloc, Manila</p>
                <div style="width:40px;height:2px;background:rgba(255,255,255,0.2);margin:1.75rem auto;"></div>
                <p style="color:rgba(255,255,255,0.4);font-size:0.7rem;font-weight:500;line-height:1.7;max-width:200px;">
                    Authorized personnel only.<br>This portal contains sensitive<br>barangay data.
                </p>
            </div>
        </div>

        {{-- Right: Form --}}
        <div class="login-right">
            <div style="margin-bottom:2rem;">
                <p style="font-size:0.65rem;font-weight:800;letter-spacing:0.18em;text-transform:uppercase;color:#94a3b8;margin-bottom:0.4rem;">Admin Portal</p>
                <h2 style="font-size:1.6rem;font-weight:800;color:#0f172a;letter-spacing:-0.02em;line-height:1.2;">Sign In</h2>
            </div>

            {{-- Error / Session Messages --}}
            @if (session('error'))
                <div style="margin-bottom:1.25rem;padding:0.85rem 1rem;background:#fef2f2;border:1px solid #fecaca;border-radius:0.75rem;display:flex;align-items:flex-start;gap:0.6rem;">
                    <svg style="width:16px;height:16px;color:#ef4444;flex-shrink:0;margin-top:1px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                    <p style="font-size:0.75rem;font-weight:600;color:#dc2626;">{{ session('error') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div style="margin-bottom:1.25rem;padding:0.75rem 1rem;background:#fef2f2;border:1px solid #fecaca;border-radius:0.75rem;">
                    <p style="font-size:0.75rem;font-weight:700;color:#dc2626;text-align:center;">{{ $errors->first() }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div style="margin-bottom:1.1rem;">
                    <label for="email" style="display:block;font-size:0.65rem;font-weight:800;letter-spacing:0.14em;text-transform:uppercase;color:#94a3b8;margin-bottom:0.5rem;">Email Address</label>
                    <input id="email"
                           class="input-field"
                           type="email"
                           name="email"
                           placeholder="admin@barangay419.ph"
                           value="{{ old('email') }}"
                           required autofocus />
                </div>

                <div style="margin-bottom:1.5rem;">
                    <label for="password" style="display:block;font-size:0.65rem;font-weight:800;letter-spacing:0.14em;text-transform:uppercase;color:#94a3b8;margin-bottom:0.5rem;">Password</label>
                    <input id="password"
                           class="input-field"
                           type="password"
                           name="password"
                           placeholder="••••••••••••"
                           required />
                </div>

                <button type="submit" class="btn-signin">Sign In</button>
            </form>

            <a href="/" style="display:block;text-align:center;margin-top:1.75rem;font-size:0.65rem;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;color:#cbd5e1;text-decoration:none;transition:color 0.2s;"
               onmouseover="this.style.color='#1e3a8a'" onmouseout="this.style.color='#cbd5e1'">
                ← Back to Home
            </a>
        </div>

    </div>

</body>
</html>
