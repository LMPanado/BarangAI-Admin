<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay 419 Admin Portal</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { 
                extend: { 
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: { 
                        brgyGreen: '#2d5a27', 
                        brgyGold: '#f1c40f',
                        darkGreen: '#1e3d1a'
                    } 
                } 
            }
        }
    </script>
    <style>
        @if(Auth::user()->role == 1)
            .sidebar-gradient { background: linear-gradient(180deg, #2d5a27 0%, #1e3d1a 100%); }
        @elseif(Auth::user()->role == 2)
            .sidebar-gradient { background: linear-gradient(180deg, #991b1b 0%, #7f1d1d 100%); }
        @elseif(Auth::user()->role == 3)
            .sidebar-gradient { background: linear-gradient(180deg, #1e40af 0%, #1e3a8a 100%); }
        @else
            .sidebar-gradient { background: linear-gradient(180deg, #2d5a27 0%, #1e3d1a 100%); }
        @endif
    </style>
</head>
<body class="bg-[#f8fafc] flex h-screen overflow-hidden text-slate-900 font-sans antialiased">
    
    <aside class="w-72 sidebar-gradient text-white flex-shrink-0 flex flex-col shadow-[10px_0_40px_rgba(0,0,0,0.1)] z-30 relative overflow-hidden">
        <div class="px-8 py-8">
            <div class="flex flex-col items-center text-center">
                <div class="w-20 h-20 mb-3 transition-transform hover:scale-110 duration-300 ease-out">
                    <img src="{{ asset('images/brgy_logo.png') }}" alt="Barangay 419 Logo" class="w-full h-full object-contain drop-shadow-2xl">
                </div>
                <div>
                    <h1 class="text-white font-extrabold text-lg tracking-tight leading-none">Barangay 419</h1>
                    <div class="inline-block px-3 py-1 bg-white/10 rounded-full mt-2 border border-white/20">
                        <p class="text-[8px] text-white font-black uppercase tracking-[0.2em]">Admin Portal</p>
                    </div>
                </div>
            </div>
        </div>

        <nav class="flex-grow px-6 space-y-1">
            <p class="px-4 text-[9px] font-black text-white/30 uppercase tracking-[0.3em] mb-2">Main Menu</p>
            
            @php
                $navItems = [
                    ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'],
                    ['route' => 'admin.residents.index', 'label' => 'Residents', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                    ['route' => 'admin.schedules.index', 'label' => 'Schedules', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ];
            @endphp

            @foreach($navItems as $item)
            <a href="{{ route($item['route']) }}" 
               class="group flex items-center px-4 py-3 text-[10px] font-bold transition-all duration-300 rounded-xl
               {{ request()->routeIs($item['route']) ? 'bg-white/20 text-white shadow-lg backdrop-blur-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <div class="p-1.5 rounded-lg mr-3 transition-all duration-300 {{ request()->routeIs($item['route']) ? 'bg-white text-darkGreen' : 'bg-white/5 text-white/40 group-hover:bg-brgyGold group-hover:text-brgyGreen' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $item['icon'] }}"></path></svg>
                </div>
                <span class="uppercase tracking-widest">{{ $item['label'] }}</span>
            </a>
            @endforeach

            {{-- Requests: Only for Role 1, 2, and 3 --}}
            @if(Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 3)
            <a href="{{ route('admin.documents.index') }}" 
               class="group flex items-center px-4 py-3 text-[10px] font-bold transition-all duration-300 rounded-xl mt-1
               {{ request()->routeIs('admin.documents.*') ? 'bg-white/20 text-white shadow-lg backdrop-blur-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <div class="p-1.5 rounded-lg mr-3 transition-all duration-300 {{ request()->routeIs('admin.documents.*') ? 'bg-white text-darkGreen' : 'bg-white/5 text-white/40 group-hover:bg-brgyGold group-hover:text-brgyGreen' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <span class="uppercase tracking-widest">Requests</span>
            </a>
            @endif

            @if(Auth::user()->role == 1)
            <div class="pt-4 pb-2">
                <p class="px-4 text-[9px] font-black text-white/30 uppercase tracking-[0.3em] mb-2">System</p>
                <a href="{{ route('admin.roles.index') }}" 
                   class="group flex items-center px-4 py-3 text-[10px] font-bold transition-all duration-300 rounded-xl
                   {{ request()->routeIs('admin.roles.*') ? 'bg-white/20 text-white shadow-lg backdrop-blur-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <div class="p-1.5 rounded-lg mr-3 transition-all duration-300 {{ request()->routeIs('admin.roles.*') ? 'bg-white text-darkGreen' : 'bg-white/5 text-white/40 group-hover:bg-brgyGold group-hover:text-brgyGreen' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <span class="uppercase tracking-widest">Manage Roles</span>
                </a>
            </div>
            @endif

            <div class="pt-4">
                <p class="px-4 text-[9px] font-black text-white/30 uppercase tracking-[0.3em] mb-2">Analytics</p>
                
                {{-- Reports: Only for Role 1 and 2 --}}
                @if(Auth::user()->role == 1 || Auth::user()->role == 2)
                <a href="{{ route('admin.reports.index') }}" class="group flex items-center px-4 py-3 text-[10px] font-bold transition-all duration-300 rounded-xl
                    {{ request()->routeIs('admin.reports.*') ? 'bg-white/20 text-white shadow-lg backdrop-blur-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <div class="p-1.5 rounded-lg mr-3 transition-all duration-300 {{ request()->routeIs('admin.reports.*') ? 'bg-white text-darkGreen' : 'bg-white/5 text-white/40 group-hover:bg-brgyGold group-hover:text-brgyGreen' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <span class="uppercase tracking-widest">Reports</span>
                </a>
                @endif

                {{-- Feedback: Still visible for everyone (1, 2, 3) --}}
                <a href="{{ route('admin.feedback.index') }}" class="group flex items-center px-4 py-3 text-[10px] font-bold transition-all duration-300 rounded-xl mt-1
                    {{ request()->routeIs('admin.feedback.*') ? 'bg-white/20 text-white shadow-lg backdrop-blur-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <div class="p-1.5 rounded-lg mr-3 transition-all duration-300 {{ request()->routeIs('admin.feedback.*') ? 'bg-white text-darkGreen' : 'bg-white/5 text-white/40 group-hover:bg-brgyGold group-hover:text-brgyGreen' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    </div>
                    <span class="uppercase tracking-widest">Feedback</span>
                </a>
            </div>
        </nav>

        <div class="p-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="group w-full flex items-center justify-center px-4 py-4 text-[9px] bg-white/10 text-white hover:bg-red-500 hover:text-white rounded-xl transition-all duration-300 font-black tracking-[0.2em] border border-white/10">
                    <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    LOGOUT
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-grow flex flex-col min-w-0">
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-12 z-20">
            <div><h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.3em]"></h2></div>
            <div class="flex items-center gap-6">
                <div class="hidden md:block text-right">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] font-black text-brgyGreen uppercase">
                        @if(Auth::user()->role == 1) Administrator @elseif(Auth::user()->role == 2) Captain @elseif(Auth::user()->role == 3) Official @else Resident @endif
                    </p>
                </div>
                <div class="relative group">
                    <div class="w-11 h-11 bg-white rounded-xl border-2 border-slate-50 p-0.5 shadow-sm group-hover:border-brgyGold transition-all duration-300 cursor-pointer overflow-hidden">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2d5a27&color=fff&bold=true" class="rounded-lg w-full h-full object-cover" alt="Avatar">
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-grow overflow-y-auto p-12">
            @if(session('success'))
                <div class="mb-10 p-6 bg-emerald-50 border border-emerald-100 text-emerald-700 text-[10px] font-black rounded-3xl shadow-sm flex items-center uppercase tracking-widest">
                    <div class="w-8 h-8 bg-emerald-500 text-white rounded-xl flex items-center justify-center mr-4 shadow-lg shadow-emerald-500/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>