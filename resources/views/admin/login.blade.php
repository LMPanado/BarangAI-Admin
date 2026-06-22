<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Barangay 419</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc; /* Matches the light grey of your public site */
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
        
        {{-- Simplified Header --}}
        <div class="mb-8 text-center">
            <a href="/">
                <img src="{{ asset('images/brgy_logo.png') }}" 
                     class="w-20 h-20 mx-auto mb-4 drop-shadow-sm" 
                     alt="Logo">
            </a>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800">Admin Login</h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">Barangay 419 Management System</p>
        </div>

        {{-- Clean Card --}}
        <div class="w-full max-w-[400px] brgy-card p-8 sm:p-10 rounded-[2rem]">
            
            @if (session('status'))
                <div class="mb-6 p-3 rounded-xl bg-green-50 border border-green-100 text-xs font-bold text-green-700 text-center uppercase tracking-wider">
                    {{ session('status') }}
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
                    @error('email')
                        <p class="text-[10px] font-bold text-red-500 mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label for="password" class="text-[11px] font-bold uppercase tracking-widest text-slate-400">Password</label>
                    </div>
                    <input id="password" 
                           class="input-field block w-full rounded-xl py-3.5 px-5 outline-none text-sm"
                           type="password"
                           name="password"
                           placeholder="••••••••••••"
                           required />
                </div>

                {{-- Remember & Forgot --}}
                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-brgyGreen focus:ring-0 focus:ring-offset-0">
                        <span class="ms-2 text-xs font-medium text-slate-500">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-xs font-bold text-slate-400 hover:text-brgyGreen transition-colors" href="{{ route('password.request') }}">
                            Forgot?
                        </a>
                    @endif
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
        <a href="/" class="mt-8 text-slate-400 text-xs font-bold uppercase tracking-widest hover:text-brgyGreen transition-colors">
            ← Back to Home
        </a>
    </div>
</body>
</html>