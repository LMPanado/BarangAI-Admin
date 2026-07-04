<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/brgy_logo.png') }}">
    <title>Barangay 419 | Official Information Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Responsive for all screen sizes */

        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); }
        .hero-gradient { background: linear-gradient(135deg, #1d4ed8 0%, #1e3a8a 100%); }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 font-sans">

    <nav x-data="{ mobileOpen: false, servicesOpen: false }" class="fixed top-0 w-full glass shadow-[0_2px_20px_rgba(0,0,0,0.04)] z-50 border-b border-slate-100/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 md:h-20 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3 group">
                <img src="{{ asset('images/brgy_logo.png') }}"
                     alt="Barangay 419 Logo"
                     class="w-9 h-9 md:w-11 md:h-11 object-contain rounded-full group-hover:scale-110 transition-transform duration-300">
                <div class="flex flex-col">
                    <span class="font-extrabold tracking-tight text-brgyGreen text-sm md:text-base uppercase leading-none mb-0">Barangay 419</span>
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em] -mt-0.5">Official Information Portal</span>
                </div>
            </a>

            {{-- Desktop nav --}}
            <div class="hidden md:flex items-center gap-1 text-[11px] font-black text-slate-500 uppercase tracking-widest h-full">
                <a href="/" class="h-20 flex items-center px-4 border-b-2 transition {{ request()->is('/') ? 'text-brgyGreen border-brgyGreen' : 'border-transparent hover:text-brgyGreen hover:border-brgyGreen/30' }}">Home</a>

                <div class="relative h-20 flex items-center" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="h-20 flex items-center gap-1 px-4 border-b-2 border-transparent hover:text-brgyGreen hover:border-brgyGreen/30 transition">
                        SERVICES
                        <svg class="w-3 h-3 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute top-full left-0 w-56 bg-white shadow-xl border border-slate-100 rounded-2xl py-2 z-50"
                         x-cloak>
                        <a href="{{ route('services.show', 'barangay-id') }}"        class="flex items-center gap-3 px-5 py-3 text-slate-600 hover:bg-brgyGreen/5 hover:text-brgyGreen transition text-xs font-bold">Barangay I.D.</a>
                        <a href="{{ route('services.show', 'business-permit') }}"    class="flex items-center gap-3 px-5 py-3 text-slate-600 hover:bg-brgyGreen/5 hover:text-brgyGreen transition text-xs font-bold">Business Permit</a>
                        <a href="{{ route('services.show', 'barangay-clearance') }}" class="flex items-center gap-3 px-5 py-3 text-slate-600 hover:bg-brgyGreen/5 hover:text-brgyGreen transition text-xs font-bold">Barangay Clearance</a>
                        <a href="{{ route('services.show', 'certificate-of-indigency') }}" class="flex items-center gap-3 px-5 py-3 text-slate-600 hover:bg-brgyGreen/5 hover:text-brgyGreen transition text-xs font-bold">Certificate of Indigency</a>
                    </div>
                </div>

                <a href="/#officials"     class="h-20 flex items-center px-4 border-b-2 border-transparent hover:text-brgyGreen hover:border-brgyGreen/30 transition">Officials</a>
                <a href="/#announcements" class="h-20 flex items-center px-4 border-b-2 border-transparent hover:text-brgyGreen hover:border-brgyGreen/30 transition">Announcements</a>
                <a href="{{ route('about') }}" class="h-20 flex items-center px-4 border-b-2 transition {{ request()->routeIs('about') ? 'text-brgyGreen border-brgyGreen' : 'border-transparent hover:text-brgyGreen hover:border-brgyGreen/30' }}">About</a>
            </div>

            {{-- Hamburger (mobile only) --}}
            <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 rounded-xl text-slate-500 hover:text-brgyGreen hover:bg-brgyGreen/5 transition-all">
                <svg x-show="!mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="mobileOpen"  class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Mobile menu --}}
        <div x-show="mobileOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden bg-white border-t border-slate-100 shadow-lg"
             x-cloak>
            <div class="px-4 py-4 space-y-1 text-[11px] font-black uppercase tracking-widest text-slate-500">
                <a href="/" @click="mobileOpen=false" class="block px-4 py-3 rounded-xl hover:bg-brgyGreen/5 hover:text-brgyGreen transition">Home</a>

                <div>
                    <button @click="servicesOpen = !servicesOpen" class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-brgyGreen/5 hover:text-brgyGreen transition">
                        Services
                        <svg class="w-3 h-3 transition-transform duration-200" :class="{'rotate-180': servicesOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="servicesOpen" x-cloak class="ml-4 mt-1 space-y-1 border-l-2 border-brgyGreen/10 pl-3">
                        <a href="{{ route('services.show', 'barangay-id') }}"        @click="mobileOpen=false" class="block px-3 py-2.5 rounded-lg text-slate-500 hover:text-brgyGreen hover:bg-brgyGreen/5 transition">Barangay I.D.</a>
                        <a href="{{ route('services.show', 'business-permit') }}"    @click="mobileOpen=false" class="block px-3 py-2.5 rounded-lg text-slate-500 hover:text-brgyGreen hover:bg-brgyGreen/5 transition">Business Permit</a>
                        <a href="{{ route('services.show', 'barangay-clearance') }}" @click="mobileOpen=false" class="block px-3 py-2.5 rounded-lg text-slate-500 hover:text-brgyGreen hover:bg-brgyGreen/5 transition">Barangay Clearance</a>
                        <a href="{{ route('services.show', 'certificate-of-indigency') }}" @click="mobileOpen=false" class="block px-3 py-2.5 rounded-lg text-slate-500 hover:text-brgyGreen hover:bg-brgyGreen/5 transition">Certificate of Indigency</a>
                    </div>
                </div>

                <a href="/#officials"     @click="mobileOpen=false" class="block px-4 py-3 rounded-xl hover:bg-brgyGreen/5 hover:text-brgyGreen transition">Officials</a>
                <a href="/#announcements" @click="mobileOpen=false" class="block px-4 py-3 rounded-xl hover:bg-brgyGreen/5 hover:text-brgyGreen transition">Announcements</a>
                <a href="{{ route('about') }}" @click="mobileOpen=false" class="block px-4 py-3 rounded-xl hover:bg-brgyGreen/5 hover:text-brgyGreen transition">About</a>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-darkGreen text-white pt-20 pb-10 rounded-t-[2.5rem] mt-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-14">
                <div class="space-y-5 md:col-span-1">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/brgy_logo.png') }}" alt="Barangay 419 Logo" class="w-12 h-12 object-contain rounded-full border border-white/10">
                        <div>
                            <p class="font-extrabold text-white text-base uppercase leading-none">Barangay 419</p>
                            <p class="text-white/40 text-[10px] font-bold uppercase tracking-widest mt-0.5">Zone 43, District IV</p>
                        </div>
                    </div>
                    <p class="text-white/40 text-xs leading-relaxed font-medium max-w-xs">
                        Serving the residents of Sampaloc, Manila with integrity and digital innovation.
                    </p>
                </div>

                <div>
                    <h4 class="text-[9px] font-black uppercase tracking-[0.25em] text-white/25 mb-5">Navigation</h4>
                    <ul class="space-y-3 text-xs font-bold uppercase tracking-widest">
                        <li><a href="/" class="text-white/50 hover:text-white transition">Home</a></li>
                        <li><a href="/#services" class="text-white/50 hover:text-white transition">Services</a></li>
                        <li><a href="/#officials" class="text-white/50 hover:text-white transition">Officials</a></li>
                        <li><a href="/#announcements" class="text-white/50 hover:text-white transition">Announcements</a></li>
                        <li><a href="{{ route('about') }}" class="text-white/50 hover:text-white transition">About Us</a></li>
                    </ul>
                </div>

                <div class="space-y-5">
                    <h4 class="text-[9px] font-black uppercase tracking-[0.25em] text-white/25">Contact & Hours</h4>

                    <div class="flex items-start gap-3">
                        <svg class="w-3.5 h-3.5 text-white/30 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <p class="text-xs font-medium text-white/50 leading-relaxed">
                            Loreto St., Zone 43, District IV<br>
                            Sampaloc, Manila 1008
                        </p>
                    </div>

                    <div class="flex items-start gap-3">
                        <svg class="w-3.5 h-3.5 text-white/30 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <p class="text-[10px] font-black text-white/25 uppercase tracking-widest mb-1">Office Hours</p>
                            <p class="text-xs font-medium text-white/50">Mon – Sun &nbsp;·&nbsp; 8:00 AM – 5:00 PM</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="https://www.facebook.com/profile.php?id=61562239220224" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/20 border border-white/10 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all text-white/70 hover:text-white">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            Facebook Page
                        </a>
                        <a href="{{ route('admin.login') }}"
                           class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/20 border border-white/10 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all text-white/70 hover:text-white">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Admin
                        </a>
                    </div>
                </div>
            </div>

            {{-- QR Code --}}
            <div class="pt-10 pb-6 border-t border-white/5 flex flex-col items-center gap-4">
                <img src="{{ asset('images/qr-code.png') }}" alt="QR Code" class="w-28 h-28 object-contain bg-white rounded-xl p-2">
                <p class="text-[11px] font-bold text-white/40 uppercase tracking-widest text-center">Scan the QR Code to Download the Barangay 419 Mobile App</p>
            </div>

            <div class="pt-8 border-t border-white/5 flex flex-col md:flex-row items-center justify-between gap-3">
                <p class="text-[10px] font-bold text-white/20 uppercase tracking-[0.25em]">&copy; 2026 Barangay 419, Zone 43. All Rights Reserved.</p>
                <p class="text-[10px] font-bold text-white/15 uppercase tracking-widest">BarangAI System</p>
            </div>
        </div>
    </footer>
</body>
</html>