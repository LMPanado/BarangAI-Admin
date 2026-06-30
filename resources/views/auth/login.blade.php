<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Barangay 419</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brgy_logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }

        .brgy-card {
            background: white;
            border: 1px solid #e2e8f0;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
        }

        .input-field {
            background: #f1f5f9;
            border: 1px solid transparent;
            transition: all 0.2s ease;
        }

        .input-field:focus {
            background: white;
            border-color: #1e3a8a;
            box-shadow: 0 0 0 4px rgba(30, 61, 26, 0.05);
        }

        .btn-primary {
            background-color: #1e3a8a;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="antialiased text-slate-900">
    <div class="min-h-screen flex flex-col items-center justify-center px-6">

        {{-- Header --}}
        <div class="mb-8 text-center">
            <a href="/">
                <img src="{{ asset('images/brgy_logo.png') }}"
                     class="w-20 h-20 mx-auto mb-4 drop-shadow-sm"
                     alt="Logo">
            </a>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800">Admin Login</h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">Barangay 419 Management System</p>
        </div>

        {{-- Login Card --}}
        <div class="w-full max-w-[400px] brgy-card p-8 sm:p-10 rounded-[2rem]">

            @if (session('error'))
                <div class="mb-6 flex items-start gap-3 p-4 rounded-2xl bg-red-50 border border-red-100">
                    <div class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-extrabold text-red-600 uppercase tracking-widest">Notice</p>
                        <p class="text-xs text-red-500 font-medium mt-0.5">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                @php $isThrottle = str_contains(strtolower($errors->first()), 'too many'); @endphp
                <div class="mb-6 flex items-start gap-3 p-4 rounded-2xl border {{ $isThrottle ? 'bg-orange-50 border-orange-100' : 'bg-red-50 border-red-100' }}">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5 {{ $isThrottle ? 'bg-orange-100' : 'bg-red-100' }}">
                        @if($isThrottle)
                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @else
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-widest {{ $isThrottle ? 'text-orange-600' : 'text-red-600' }}">
                            {{ $isThrottle ? 'Too Many Attempts' : 'Login Failed' }}
                        </p>
                        <p class="text-xs font-medium mt-0.5 {{ $isThrottle ? 'text-orange-500' : 'text-red-500' }}">
                            {{ $errors->first() }}
                        </p>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                @csrf

                {{-- Email --}}
                <div class="space-y-2">
                    <label for="email" class="text-[11px] font-bold uppercase tracking-widest text-slate-400 ml-1">Email Address</label>
                    <input id="email"
                           class="input-field block w-full rounded-xl py-3.5 px-5 outline-none text-sm"
                           type="email"
                           name="email"
                           placeholder="admin@barangay419.ph"
                           value="{{ old('email') }}"
                           required autofocus />
                </div>

                {{-- Password --}}
                <div class="space-y-2">
                    <label for="password" class="text-[11px] font-bold uppercase tracking-widest text-slate-400 ml-1">Password</label>
                    <div class="relative">
                        <input id="password"
                               class="input-field block w-full rounded-xl py-3.5 pl-5 pr-12 outline-none text-sm"
                               type="password"
                               name="password"
                               placeholder="••••••••••••"
                               onpaste="return false"
                               required />
                        <button type="button" onclick="togglePassword()"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eyeOffIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Action Button --}}
                <div class="pt-2">
                    <button type="submit" class="btn-primary w-full text-white font-bold py-4 rounded-xl shadow-lg shadow-green-900/10 active:scale-[0.98]">
                        Sign In
                    </button>
                </div>
            </form>
        </div>

        {{-- Simple Back Link --}}
        <a href="/" class="mt-8 text-slate-400 text-xs font-bold uppercase tracking-widest hover:text-[#1e3a8a] transition-colors">
            ← Back to Home
        </a>
    </div>
<script>
function togglePassword() {
    const input = document.getElementById('password');
    const eyeOn  = document.getElementById('eyeIcon');
    const eyeOff = document.getElementById('eyeOffIcon');
    if (input.type === 'password') {
        input.type = 'text';
        eyeOn.classList.add('hidden');
        eyeOff.classList.remove('hidden');
    } else {
        input.type = 'password';
        eyeOn.classList.remove('hidden');
        eyeOff.classList.add('hidden');
    }
}
</script>
</body>
</html>
