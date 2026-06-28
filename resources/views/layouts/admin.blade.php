<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay 419 Admin Portal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/brgy_logo.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brgyGreen: '#1d4ed8',
                        brgyGold: '#ffffff',
                        darkGreen: '#1e3a8a'
                    }
                }
            }
        }
    </script>
    <style>
        /* Preserve exact layout on all screen sizes */
        html { min-width: 1280px; }

        .sidebar-gradient { background: linear-gradient(180deg, #1e3a8a 0%, #0f1f5c 100%); }
        .sidebar-black { background: linear-gradient(180deg, #111111 0%, #000000 100%); }
        .sidebar-red   { background: linear-gradient(180deg, #991b1b 0%, #5c0a0a 100%); }

        /* Hexagonal chevron pattern overlay for sidebar */
        .sidebar-pattern::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Cg fill='none' stroke='rgba(255,255,255,0.15)' stroke-width='1'%3E%3Cpath d='M30 0 L60 15 L60 45 L30 60 L0 45 L0 15 Z'/%3E%3Cpath d='M30 10 L50 20 L50 40 L30 50 L10 40 L10 20 Z'/%3E%3Cpath d='M15 7 L30 0 M45 7 L60 15 M60 30 L45 37 M30 60 L15 53 M0 30 L15 23'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 60px 60px;
            opacity: 0.32;
            pointer-events: none;
            z-index: 0;
        }

        .sidebar-pattern > * { position: relative; z-index: 1; }

        /* Turbo Drive progress bar */
        .turbo-progress-bar {
            height: 3px;
            background: #60a5fa;
            box-shadow: 0 0 8px #60a5fa;
        }

        /* Sidebar nav scrollbar */
        .sidebar-nav::-webkit-scrollbar { width: 3px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 10px; }
    </style>
    <script type="module" src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.12/dist/turbo.es2017.esm.js"></script>
</head>
<body class="bg-[#f8fafc] flex h-screen overflow-hidden text-slate-900 font-sans antialiased">

    @php
        $role         = Auth::user()->role;
        $sidebarClass = $role == 1 ? 'sidebar-black' : ($role == 2 ? 'sidebar-red' : 'sidebar-gradient');
        $firstName    = Auth::user()->first_name ?? Auth::user()->name ?? 'Admin';
        $lastName     = Auth::user()->last_name ?? '';
        $initials     = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
        $roleLabel    = match((int) $role) {
            1 => 'I.T. Administrator',
            2 => 'Punong Barangay',
            3 => 'Barangay Official',
            default => 'Staff',
        };
    @endphp

    <aside class="w-72 {{ $sidebarClass }} sidebar-pattern text-white flex-shrink-0 flex flex-col z-30 relative overflow-hidden shadow-[5px_0_30px_rgba(0,0,0,0.15)]">

        {{-- Logo + Branding --}}
        <div class="px-5 py-5 border-b border-white/10 flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 flex-shrink-0 bg-white/10 rounded-2xl p-1.5 border border-white/10">
                    <img src="{{ asset('images/brgy_logo.png') }}" alt="Barangay 419" class="w-full h-full object-contain drop-shadow-lg">
                </div>
                <div class="min-w-0">
                    <h1 class="text-white font-extrabold text-sm tracking-tight leading-tight">Barangay 419</h1>
                    <div class="flex items-center gap-1.5 mt-1">
                        <div class="w-1.5 h-1.5 bg-green-400 rounded-full"></div>
                        <span class="text-[9px] text-white/50 font-bold uppercase tracking-widest">Admin Portal</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-grow px-3 py-4 overflow-y-auto sidebar-nav space-y-0.5">

            <p class="px-3 pb-1.5 text-[8px] font-black text-white/30 uppercase tracking-[0.3em]">Main Menu</p>

            @php
                $navItems = [
                    ['route' => 'dashboard',             'label' => 'Dashboard', 'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z', 'roles' => [1,2,3], 'check' => 'dashboard'],
                    ['route' => 'admin.residents.index', 'label' => 'Residents',  'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'roles' => [2,3], 'check' => 'admin.residents.*'],
                    ['route' => 'admin.schedules.index', 'label' => 'Schedules',  'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'roles' => [2,3], 'check' => 'admin.schedules.*'],
                ];
            @endphp

            @foreach($navItems as $item)
            @if(in_array(Auth::user()->role, $item['roles']))
            @php $isActive = request()->routeIs($item['check']); @endphp
            <a href="{{ route($item['route']) }}"
               class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[10px] font-bold transition-all duration-200 border-l-[3px]
                      {{ $isActive ? 'border-white bg-white/15 text-white' : 'border-transparent text-white/60 hover:bg-white/10 hover:text-white hover:border-white/30' }}">
                <div class="p-1.5 rounded-xl flex-shrink-0 transition-all {{ $isActive ? 'bg-white/25 text-white' : 'text-white/40 group-hover:text-white/90 group-hover:bg-white/10' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $item['icon'] }}"></path></svg>
                </div>
                <span class="uppercase tracking-widest leading-none">{{ $item['label'] }}</span>
            </a>
            @endif
            @endforeach

            {{-- Announcements: Role 2 and 3 --}}
            @if(Auth::user()->role == 2 || Auth::user()->role == 3)
            @php $isActive = request()->routeIs('admin.announcements.*'); @endphp
            <a href="{{ route('admin.announcements.index') }}"
               class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[10px] font-bold transition-all duration-200 border-l-[3px]
                      {{ $isActive ? 'border-white bg-white/15 text-white' : 'border-transparent text-white/60 hover:bg-white/10 hover:text-white hover:border-white/30' }}">
                <div class="p-1.5 rounded-xl flex-shrink-0 transition-all {{ $isActive ? 'bg-white/25 text-white' : 'text-white/40 group-hover:text-white/90 group-hover:bg-white/10' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                </div>
                <span class="uppercase tracking-widest leading-none">Announcements</span>
            </a>
            @endif

            {{-- Requests: Role 2 and 3 --}}
            @if(Auth::user()->role == 2 || Auth::user()->role == 3)
            @php $isActive = request()->routeIs('admin.documents.*'); @endphp
            <a href="{{ route('admin.documents.index') }}"
               class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[10px] font-bold transition-all duration-200 border-l-[3px]
                      {{ $isActive ? 'border-white bg-white/15 text-white' : 'border-transparent text-white/60 hover:bg-white/10 hover:text-white hover:border-white/30' }}">
                <div class="p-1.5 rounded-xl flex-shrink-0 transition-all {{ $isActive ? 'bg-white/25 text-white' : 'text-white/40 group-hover:text-white/90 group-hover:bg-white/10' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <span class="uppercase tracking-widest leading-none">Requests</span>
            </a>
            @endif

            {{-- Verification: Role 3 only --}}
            @if(Auth::user()->role == 3)
            @php
                $verificationPending = \App\Models\User::where('role', 0)->where('verification_status', 'pending')->count();
                $isActive = request()->routeIs('admin.verification.*');
            @endphp
            <a href="{{ route('admin.verification.index') }}"
               class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[10px] font-bold transition-all duration-200 border-l-[3px]
                      {{ $isActive ? 'border-white bg-white/15 text-white' : 'border-transparent text-white/60 hover:bg-white/10 hover:text-white hover:border-white/30' }}">
                <div class="p-1.5 rounded-xl flex-shrink-0 transition-all {{ $isActive ? 'bg-white/25 text-white' : 'text-white/40 group-hover:text-white/90 group-hover:bg-white/10' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <span class="uppercase tracking-widest leading-none flex-1">Verification</span>
                @if($verificationPending > 0)
                    <span id="verification-badge"
                          class="min-w-[18px] h-[18px] px-1 bg-amber-400 text-white text-[8px] font-black rounded-full flex items-center justify-center leading-none flex-shrink-0">
                        {{ $verificationPending }}
                    </span>
                @endif
            </a>
            @endif

            {{-- System Section: Role 1 only --}}
            @if(Auth::user()->role == 1)
            <div class="border-t border-white/10 mx-1 my-3"></div>
            <p class="px-3 pb-1.5 text-[8px] font-black text-white/30 uppercase tracking-[0.3em]">System</p>

            @php $isActive = request()->routeIs('admin.roles.*'); @endphp
            <a href="{{ route('admin.roles.index') }}"
               class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[10px] font-bold transition-all duration-200 border-l-[3px]
                      {{ $isActive ? 'border-white bg-white/15 text-white' : 'border-transparent text-white/60 hover:bg-white/10 hover:text-white hover:border-white/30' }}">
                <div class="p-1.5 rounded-xl flex-shrink-0 transition-all {{ $isActive ? 'bg-white/25 text-white' : 'text-white/40 group-hover:text-white/90 group-hover:bg-white/10' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <span class="uppercase tracking-widest leading-none">Manage Roles</span>
            </a>

            @php $isActive = request()->routeIs('admin.audit-logs.*'); @endphp
            <a href="{{ route('admin.audit-logs.index') }}"
               class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[10px] font-bold transition-all duration-200 border-l-[3px]
                      {{ $isActive ? 'border-white bg-white/15 text-white' : 'border-transparent text-white/60 hover:bg-white/10 hover:text-white hover:border-white/30' }}">
                <div class="p-1.5 rounded-xl flex-shrink-0 transition-all {{ $isActive ? 'bg-white/25 text-white' : 'text-white/40 group-hover:text-white/90 group-hover:bg-white/10' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </div>
                <span class="uppercase tracking-widest leading-none">Manage Logs</span>
            </a>

            @php $isActive = request()->routeIs('admin.document-activity.*'); @endphp
            <a href="{{ route('admin.document-activity.index') }}"
               class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[10px] font-bold transition-all duration-200 border-l-[3px]
                      {{ $isActive ? 'border-white bg-white/15 text-white' : 'border-transparent text-white/60 hover:bg-white/10 hover:text-white hover:border-white/30' }}">
                <div class="p-1.5 rounded-xl flex-shrink-0 transition-all {{ $isActive ? 'bg-white/25 text-white' : 'text-white/40 group-hover:text-white/90 group-hover:bg-white/10' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <span class="uppercase tracking-widest leading-none">Doc. Activity</span>
            </a>
            @endif

            {{-- Analytics Section --}}
            <div class="border-t border-white/10 mx-1 my-3"></div>
            <p class="px-3 pb-1.5 text-[8px] font-black text-white/30 uppercase tracking-[0.3em]">Analytics</p>

            {{-- Reports: Role 2 only --}}
            @if(Auth::user()->role == 2)
            @php $isActive = request()->routeIs('admin.reports.*'); @endphp
            <a href="{{ route('admin.reports.index') }}"
               class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[10px] font-bold transition-all duration-200 border-l-[3px]
                      {{ $isActive ? 'border-white bg-white/15 text-white' : 'border-transparent text-white/60 hover:bg-white/10 hover:text-white hover:border-white/30' }}">
                <div class="p-1.5 rounded-xl flex-shrink-0 transition-all {{ $isActive ? 'bg-white/25 text-white' : 'text-white/40 group-hover:text-white/90 group-hover:bg-white/10' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <span class="uppercase tracking-widest leading-none">Reports</span>
            </a>
            @endif

            {{-- Complaints: Role 2 only --}}
            @if(Auth::user()->role == 2)
            @php $isActive = request()->routeIs('admin.complaints.*'); @endphp
            <a href="{{ route('admin.complaints.index') }}"
               class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[10px] font-bold transition-all duration-200 border-l-[3px]
                      {{ $isActive ? 'border-white bg-white/15 text-white' : 'border-transparent text-white/60 hover:bg-white/10 hover:text-white hover:border-white/30' }}">
                <div class="p-1.5 rounded-xl flex-shrink-0 transition-all {{ $isActive ? 'bg-white/25 text-white' : 'text-white/40 group-hover:text-white/90 group-hover:bg-white/10' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <span class="uppercase tracking-widest leading-none">Complaints</span>
            </a>
            @endif

            {{-- Feedback: All roles --}}
            @php $isActive = request()->routeIs('admin.feedback.*'); @endphp
            <a href="{{ route('admin.feedback.index') }}"
               class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[10px] font-bold transition-all duration-200 border-l-[3px]
                      {{ $isActive ? 'border-white bg-white/15 text-white' : 'border-transparent text-white/60 hover:bg-white/10 hover:text-white hover:border-white/30' }}">
                <div class="p-1.5 rounded-xl flex-shrink-0 transition-all {{ $isActive ? 'bg-white/25 text-white' : 'text-white/40 group-hover:text-white/90 group-hover:bg-white/10' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                </div>
                <span class="uppercase tracking-widest leading-none">Feedback</span>
            </a>

        </nav>

        {{-- User Profile + Logout --}}
        <div class="flex-shrink-0 border-t border-white/10 p-4 space-y-2">
            {{-- User card --}}
            <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10">
                <div class="w-8 h-8 rounded-xl bg-white/15 text-white flex items-center justify-center font-black text-[10px] flex-shrink-0 border border-white/10">
                    {{ $initials }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-[10px] font-extrabold text-white leading-tight truncate">{{ $firstName }} {{ $lastName }}</p>
                    <p class="text-[8px] text-white/40 font-bold uppercase tracking-wider truncate mt-0.5">{{ $roleLabel }}</p>
                </div>
            </div>
            {{-- Logout button --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="group w-full flex items-center justify-center gap-2 px-4 py-3 text-[9px] bg-white/10 text-white/60 hover:bg-red-500 hover:text-white rounded-xl transition-all duration-200 font-black tracking-[0.2em] border border-white/10 hover:border-red-400">
                    <svg class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Sign Out
                </button>
            </form>
        </div>

    </aside>

    <div class="flex-grow flex flex-col min-w-0">
        <header class="h-16 bg-white border-b border-slate-100 flex items-center justify-end px-12 z-20 shadow-sm">
            {{-- Right: time + user info --}}
            @php
                [$dotColor, $badgeBg, $badgeText] = match((int) Auth::user()->role) {
                    1 => ['bg-violet-500', 'bg-violet-50', 'text-violet-600'],
                    2 => ['bg-blue-500',   'bg-blue-50',   'text-blue-700'],
                    3 => ['bg-sky-500',    'bg-sky-50',    'text-sky-600'],
                    default => ['bg-slate-400', 'bg-slate-50', 'text-slate-500'],
                };
            @endphp
            <div class="hidden md:flex items-center gap-3">
                {{-- Live time --}}
                <p id="header-time" class="text-[11px] font-semibold text-slate-400 tabular-nums leading-none whitespace-nowrap"></p>
                <div class="w-px h-4 bg-slate-200"></div>
                {{-- Name --}}
                <p class="text-[11px] font-extrabold text-slate-700 leading-none whitespace-nowrap">
                    {{ $firstName }} {{ $lastName }}
                </p>
                {{-- Initials avatar --}}
                <div class="w-7 h-7 rounded-lg {{ $badgeBg }} {{ $badgeText }} flex items-center justify-center font-black text-[10px] flex-shrink-0">
                    {{ $initials }}
                </div>
            </div>
        </header>
        <script>
        (function () {
            function updateClock() {
                const now = new Date();
                const time = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true });
                const t = document.getElementById('header-time');
                if (t) t.textContent = time;
            }
            updateClock();
            setInterval(updateClock, 1000);
        })();
        </script>

        <main class="flex-grow overflow-y-auto p-12">
            @yield('content')
        </main>
    </div>

    {{-- Global Toast --}}
    @if(session('success'))
    <div id="global-toast"
         class="fixed top-6 right-6 z-[200] flex items-center gap-3 bg-white border border-gray-100 shadow-2xl shadow-black/10 px-5 py-4 rounded-2xl transition-all duration-500">
        <div class="w-8 h-8 bg-emerald-500 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <p class="text-xs font-black text-gray-700 uppercase tracking-widest">{{ session('success') }}</p>
        <button onclick="document.getElementById('global-toast').remove()" class="ml-2 text-gray-300 hover:text-gray-500 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <script>setTimeout(() => { const t = document.getElementById('global-toast'); if(t) t.style.opacity = '0'; setTimeout(() => t && t.remove(), 500); }, 4000);</script>
    @endif

    {{-- Global Delete Confirm Modal --}}
    <div id="delete-modal" class="fixed inset-0 z-[300] hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-sm p-8 text-center">
            <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <h3 class="text-base font-extrabold text-gray-800 mb-2">Confirm Deletion</h3>
            <p id="delete-modal-message" class="text-sm text-gray-400 font-medium mb-8">This action cannot be undone.</p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()"
                        class="flex-1 py-3 border-2 border-gray-100 text-gray-500 text-xs font-black uppercase tracking-widest rounded-2xl hover:border-gray-200 hover:text-gray-700 transition-all">
                    Cancel
                </button>
                <button id="delete-confirm-btn"
                        class="flex-1 py-3 bg-red-500 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-red-600 transition-all shadow-lg shadow-red-500/20">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <script>
    let _deleteForm = null;

    function confirmDelete(formId, message) {
        _deleteForm = document.getElementById(formId);
        document.getElementById('delete-modal-message').textContent = message || 'This action cannot be undone.';
        const modal = document.getElementById('delete-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        _deleteForm = null;
    }

    // Attach modal listeners once; Turbo keeps the layout alive between navigations
    if (!window._deleteModalBound) {
        window._deleteModalBound = true;
        document.getElementById('delete-confirm-btn').addEventListener('click', function () {
            if (_deleteForm) _deleteForm.submit();
        });
        document.getElementById('delete-modal').addEventListener('click', function (e) {
            if (e.target === this) closeDeleteModal();
        });
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDeleteModal(); });
    }
    </script>

    {{-- Tab-close session guard --}}
    {{-- sessionStorage is wiped when the tab closes, unlike cookies which browsers restore. --}}
    {{-- If the flag is missing on load, the tab was closed and reopened → destroy the session. --}}
    {{-- Hidden form used by JS to POST force-logout (GET would be vulnerable to prefetch/link preview) --}}
    <form id="force-logout-form" action="{{ route('admin.force-logout') }}" method="POST" class="hidden">
        @csrf
    </form>
    <script>
    (function () {
        @if(session('just_logged_in'))
            sessionStorage.setItem('admin_tab_active', '1');
        @else
            if (!sessionStorage.getItem('admin_tab_active')) {
                document.getElementById('force-logout-form').submit();
                return;
            }
        @endif
        sessionStorage.setItem('admin_tab_active', '1');
    })();
    </script>
</body>
</html>
