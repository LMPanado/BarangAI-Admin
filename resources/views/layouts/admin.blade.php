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
        .sidebar-gradient { background: linear-gradient(180deg, #1d4ed8 0%, #1e3a8a 100%); }

        /* Turbo Drive progress bar */
        .turbo-progress-bar {
            height: 3px;
            background: #60a5fa;
            box-shadow: 0 0 8px #60a5fa;
        }
    </style>
    <script type="module" src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.12/dist/turbo.es2017.esm.js"></script>
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

            {{-- Announcements: Only for Role 1, 2, and 3 --}}
            @if(Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 3)
            <a href="{{ route('admin.announcements.index') }}" 
               class="group flex items-center px-4 py-3 text-[10px] font-bold transition-all duration-300 rounded-xl mt-1
               {{ request()->routeIs('admin.announcements.*') ? 'bg-white/20 text-white shadow-lg backdrop-blur-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <div class="p-1.5 rounded-lg mr-3 transition-all duration-300 {{ request()->routeIs('admin.announcements.*') ? 'bg-white text-darkGreen' : 'bg-white/5 text-white/40 group-hover:bg-brgyGold group-hover:text-brgyGreen' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                </div>
                <span class="uppercase tracking-widest">Announcements</span>
            </a>
            @endif

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

            {{-- Account Verification: Role 3 (Barangay Official) only --}}
            @if(Auth::user()->role == 3)
            @php
                $verificationPending = \App\Models\User::where('role', 0)
                    ->where('verification_status', 'pending')
                    ->count();
            @endphp
            <a href="{{ route('admin.verification.index') }}"
               class="group flex items-center px-4 py-3 text-[10px] font-bold transition-all duration-300 rounded-xl mt-1
               {{ request()->routeIs('admin.verification.*') ? 'bg-white/20 text-white shadow-lg backdrop-blur-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <div class="p-1.5 rounded-lg mr-3 transition-all duration-300 {{ request()->routeIs('admin.verification.*') ? 'bg-white text-darkGreen' : 'bg-white/5 text-white/40 group-hover:bg-brgyGold group-hover:text-brgyGreen' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <span class="uppercase tracking-widest flex-1">Verification</span>
                @if($verificationPending > 0)
                    <span id="verification-badge"
                          class="ml-2 min-w-[20px] h-5 px-1.5 bg-amber-400 text-white text-[9px] font-black rounded-full flex items-center justify-center">
                        {{ $verificationPending }}
                    </span>
                @endif
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
                <a href="{{ route('admin.audit-logs.index') }}"
                   class="group flex items-center px-4 py-3 mt-1 text-[10px] font-bold transition-all duration-300 rounded-xl
                   {{ request()->routeIs('admin.audit-logs.*') ? 'bg-white/20 text-white shadow-lg backdrop-blur-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <div class="p-1.5 rounded-lg mr-3 transition-all duration-300 {{ request()->routeIs('admin.audit-logs.*') ? 'bg-white text-darkGreen' : 'bg-white/5 text-white/40 group-hover:bg-brgyGold group-hover:text-brgyGreen' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    </div>
                    <span class="uppercase tracking-widest">Audit Logs</span>
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
            <div class="flex items-center gap-4">
                @php
                    $roleLabel = match((int) Auth::user()->role) {
                        1 => 'I.T. Administrator',
                        2 => 'Punong Barangay',
                        3 => 'Barangay Official',
                        default => 'Staff',
                    };
                    [$dotColor, $badgeBg, $badgeText] = match((int) Auth::user()->role) {
                        1 => ['bg-violet-500', 'bg-violet-50 border-violet-100', 'text-violet-600'],
                        2 => ['bg-blue-500',   'bg-blue-50 border-blue-100',     'text-blue-700'],
                        3 => ['bg-sky-500',    'bg-sky-50 border-sky-100',       'text-sky-600'],
                        default => ['bg-slate-400', 'bg-slate-50 border-slate-100', 'text-slate-500'],
                    };
                    $firstName = Auth::user()->first_name ?? Auth::user()->name ?? 'Admin';
                    $lastName  = Auth::user()->last_name ?? '';
                    $initials  = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
                @endphp
                <div class="hidden md:flex items-center gap-3 bg-white border border-slate-100 shadow-sm rounded-2xl px-4 py-2.5">
                    {{-- Initials avatar --}}
                    <div class="w-9 h-9 rounded-xl {{ $badgeBg }} border {{ $badgeText }} flex items-center justify-center font-black text-xs flex-shrink-0">
                        {{ $initials }}
                    </div>
                    {{-- Name + role --}}
                    <div class="flex flex-col gap-0.5">
                        <p class="text-xs font-extrabold text-slate-800 leading-none whitespace-nowrap">
                            {{ $firstName }} {{ $lastName }}
                        </p>
                        <span class="flex items-center gap-1.5 text-[9px] font-black uppercase tracking-widest {{ $badgeText }} leading-none">
                            <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                            {{ $roleLabel }}
                        </span>
                    </div>
                </div>
            </div>
        </header>

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
</body>
</html>