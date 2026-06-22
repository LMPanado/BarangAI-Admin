<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay 419 | Official Information Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brgyGreen: '#1d4ed8',
                        brgyGold: '#dc2626',
                        darkGreen: '#1e3a8a',
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
        .hero-gradient { background: linear-gradient(135deg, #1d4ed8 0%, #1e3a8a 100%); }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 font-sans">

    <nav class="fixed top-0 w-full glass shadow-[0_2px_20px_rgba(0,0,0,0.02)] z-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            {{-- Left Side: Brand --}}
            <a href="/" class="flex items-center gap-3 group">
                <div class="relative">
                    <img src="{{ asset('images/brgy_logo.png') }}" 
                         alt="Barangay 419 Logo" 
                         class="w-12 h-12 object-contain rounded-full shadow-sm group-hover:scale-110 transition-transform duration-300">
                </div>
                <div class="flex flex-col">
                    <span class="font-extrabold tracking-tight text-brgyGreen text-lg uppercase leading-none">Barangay 419</span>
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em]">Official Information Portal</span>
                </div>
            </a>
            
            {{-- Right Side: Navigation --}}
            <div class="hidden md:flex items-center gap-8 text-[11px] font-black text-slate-400 uppercase tracking-widest h-full">
                <a href="/" class="h-20 flex items-center border-b-2 transition {{ request()->is('/') ? 'text-brgyGreen border-brgyGreen' : 'border-transparent hover:text-brgyGreen' }}">Home</a>
                
                {{-- Dropdown Services --}}
                <div class="relative h-20 flex items-center" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="flex items-center gap-1 transition hover:text-brgyGreen uppercase tracking-widest cursor-default">
                        Services
                        <svg class="w-3 h-3 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute top-full left-0 w-64 bg-white shadow-2xl border border-slate-100 rounded-2xl py-3 z-50"
                         x-cloak>
                        <a href="{{ route('services.show', 'barangay-id') }}" class="block px-5 py-3 hover:bg-slate-50 hover:text-brgyGreen transition">Barangay I.D.</a>
                        <a href="{{ route('services.show', 'business-permit') }}" class="block px-5 py-3 hover:bg-slate-50 hover:text-brgyGreen transition">Business Permit</a>
                        <a href="{{ route('services.show', 'cedula') }}" class="block px-5 py-3 hover:bg-slate-50 hover:text-brgyGreen transition">Cedula</a>
                        <a href="{{ route('services.show', 'barangay-clearance') }}" class="block px-5 py-3 hover:bg-slate-50 hover:text-brgyGreen transition">Barangay Clearance</a>
                    </div>
                </div>

                <a href="/#officials" class="h-20 flex items-center border-b-2 border-transparent hover:text-brgyGreen transition">Officials</a>
                <a href="/#schedule" class="h-20 flex items-center border-b-2 border-transparent hover:text-brgyGreen transition">Announcements</a>
                <a href="{{ route('about') }}" class="h-20 flex items-center border-b-2 transition {{ request()->routeIs('about') ? 'text-brgyGreen border-brgyGreen' : 'border-transparent hover:text-brgyGreen' }}">About</a>
                
                {{-- Admin Login link has been removed from here --}}
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-darkGreen text-white pt-24 pb-12 rounded-t-[3rem] mt-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('images/brgy_logo.png') }}" alt="Barangay 419 Logo" class="w-14 h-14 object-contain rounded-full border border-white/10">
                        <span class="font-extrabold tracking-tight text-white text-xl uppercase">Barangay 419</span>
                    </div>
                    <p class="text-white/40 text-xs leading-relaxed font-medium">
                        Serving the residents of Zone 43, District IV with integrity and digital innovation.
                    </p>
                </div>

                <div>
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-white/20 mb-6">Quick Links</h4>
                    <ul class="space-y-4 text-xs font-bold uppercase tracking-widest text-white/60">
                        <li><a href="/" class="hover:text-brgyGold transition">Home</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-brgyGold transition">About Us</a></li>
                        <li><a href="/#schedule" class="hover:text-brgyGold transition">Announcements</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-white/20 mb-6">Community Info</h4>
                    <ul class="space-y-4 text-xs font-bold uppercase tracking-widest text-white/60">
                        <li><a href="/#services" class="hover:text-brgyGold transition">Barangay Services</a></li>
                        <li><a href="/#officials" class="hover:text-brgyGold transition">Barangay Officials</a></li>
                        <li><a href="#" class="hover:text-brgyGold transition">Emergency Hotlines</a></li>
                        <li><a href="{{ route('admin.login') }}" class="hover:text-brgyGold transition">Admin Login</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-white/20 mb-6">Office Location</h4>
                    <p class="text-xs font-bold text-white/60 leading-relaxed uppercase tracking-wider">
                        123 Barangay Hall St.<br>
                        Zone 43, District IV<br>
                        Sampaloc, Manila
                    </p>
                </div>
            </div>

            <div class="pt-12 border-t border-white/5 text-center text-[10px] font-bold text-white/20 uppercase tracking-[0.3em]">
                <p>&copy; 2026 Barangay 419, Zone 43. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>