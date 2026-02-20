<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Barangay 419</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { 
                extend: { 
                    fontFamily: {
                        // This applies the font to the whole document
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'sans-serif'],
                    },
                    colors: { 
                        barangayGreen: '#2d5a27', 
                        barangayLightGreen: '#4ade80',
                        barangayDark: '#1a3a17'
                    } 
                } 
            }
        }
    </script>
    <style>
        /* Smooth scrolling for the main content area */
        .overflow-y-auto {
            scrollbar-width: thin;
            scrollbar-color: #2d5a27 #f3f4f6;
        }
    </style>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden text-gray-900 font-sans antialiased">
    
    <aside class="w-64 bg-barangayDark text-gray-100 flex-shrink-0 flex flex-col shadow-xl">
        <div class="p-6 bg-barangayGreen flex flex-col items-center border-b border-white/10">
            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mb-2 shadow-inner">
                <span class="text-white font-extrabold text-xl tracking-tighter">419</span>
            </div>
            <h1 class="text-white font-bold text-base tracking-tight">Barangay Admin</h1>
        </div>

        <nav class="flex-grow py-6 px-4 space-y-1">
            <p class="px-4 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-4 opacity-70">Main Navigation</p>
            
            <a href="{{ route('dashboard') }}" 
               class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white border-l-4 border-barangayLightGreen' : 'hover:bg-white/5 hover:text-white' }}">
               <svg class="w-5 h-5 mr-3 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
               Dashboard
            </a>

            <a href="{{ route('admin.residents.index') }}" 
               class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.residents.*') ? 'bg-white/10 text-white border-l-4 border-barangayLightGreen' : 'hover:bg-white/5 hover:text-white' }}">
               <svg class="w-5 h-5 mr-3 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
               Resident Records
            </a>

            <a href="{{ route('admin.schedules.index') }}" 
               class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.schedules.*') ? 'bg-white/10 text-white border-l-4 border-barangayLightGreen' : 'hover:bg-white/5 hover:text-white' }}">
               <svg class="w-5 h-5 mr-3 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
               Schedules
            </a>

            <a href="{{ route('admin.documents.index') }}" 
               class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.documents.*') ? 'bg-white/10 text-white border-l-4 border-barangayLightGreen' : 'hover:bg-white/5 hover:text-white' }}">
               <svg class="w-5 h-5 mr-3 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
               Document Requests
            </a>

            <a href="#" 
               class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/5 hover:text-white transition-all duration-200">
               <svg class="w-5 h-5 mr-3 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
               Reports
            </a>
        </nav>

        <div class="p-4 bg-black/20">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 text-sm bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white rounded-lg transition-all font-bold tracking-wide">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    LOGOUT
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-grow flex flex-col min-w-0">
        <header class="h-16 bg-white shadow-sm border-b border-gray-200 flex items-center justify-between px-8 z-10">
            <div class="flex items-center space-x-2">
                <span class="p-1.5 bg-green-50 text-barangayGreen rounded-md border border-green-100">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V7h2v2z"></path></svg>
                </span>
                <div class="text-xs font-extrabold text-gray-400 uppercase tracking-widest">Admin Portal</div>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Current User</p>
                    <p class="text-sm font-bold text-barangayGreen tracking-tight">System Administrator</p>
                </div>
                <div class="w-10 h-10 bg-gray-200 rounded-full border-2 border-barangayLightGreen overflow-hidden shadow-sm">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=2d5a27&color=fff&bold=true" alt="Avatar">
                </div>
            </div>
        </header>

        <main class="flex-grow overflow-y-auto p-8 bg-gray-50/50">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 text-sm rounded-r shadow-sm">
                    <div class="flex items-center font-medium">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>