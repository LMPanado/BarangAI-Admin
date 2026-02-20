<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay 419 | Resident Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/csp@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brgyGreen: '#2d5a27',
                        brgyGold: '#f1c40f',
                        darkGreen: '#1e3d1a',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); }
        .hero-gradient { background: linear-gradient(135deg, #2d5a27 0%, #1e3d1a 100%); }
        /* Prevent flicker before Alpine loads */
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 font-sans">

    <nav class="fixed top-0 w-full glass shadow-[0_2px_20px_rgba(0,0,0,0.02)] z-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-brgyGreen rounded-xl flex items-center justify-center font-bold text-white shadow-lg shadow-brgyGreen/20">419</div>
                <span class="font-extrabold tracking-tight text-brgyGreen text-lg uppercase">Barangay 419</span>
            </div>
            
            <div class="hidden md:flex items-center gap-10 text-sm font-semibold text-slate-600 uppercase tracking-widest">
                <a href="/" class="hover:text-brgyGreen transition">Home</a>
                <a href="/#services" class="hover:text-brgyGreen transition">Services</a>
                <a href="/#officials" class="hover:text-brgyGreen transition">Officials</a>
                <a href="/#schedule" class="hover:text-brgyGreen transition">Schedule</a>
                
                @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 group focus:outline-none">
                            <span class="text-slate-700 group-hover:text-brgyGreen transition uppercase tracking-widest">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-brgyGreen transition-transform duration-300" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" 
                             x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                             class="absolute right-0 mt-4 w-52 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 z-50">
                            
                            <a href="{{ route('client.requests') }}" class="block px-5 py-3 text-[10px] font-black text-slate-400 hover:text-brgyGreen hover:bg-slate-50 transition uppercase tracking-widest">My Requests</a>
                            <a href="{{ route('client.profile') }}" class="block px-5 py-3 text-[10px] font-black text-slate-400 hover:text-brgyGreen hover:bg-slate-50 transition uppercase tracking-widest border-b border-slate-50">Profile Settings</a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-5 py-3 text-[10px] font-black text-red-500 hover:bg-red-50 transition uppercase tracking-widest">
                                    Logout Account
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="bg-brgyGreen text-white px-6 py-2.5 rounded-xl hover:bg-darkGreen transition shadow-lg shadow-brgyGreen/20">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-darkGreen text-white pt-24 pb-12 rounded-t-[3rem] mt-20">
        <div class="max-w-7xl mx-auto px-6 text-center text-[10px] font-bold text-white/30 uppercase tracking-[0.3em]">
            <p>&copy; 2026 Barangay 419, Zone 43. Built for the People.</p>
        </div>
    </footer>
</body>
</html>