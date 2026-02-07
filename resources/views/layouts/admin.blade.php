<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Barangay 417</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { 
                extend: { 
                    colors: { 
                        adminNavy: '#1e293b', // Standard Slate 800
                        adminBlue: '#3b82f6'  // Standard Blue 500
                    } 
                } 
            }
        }
    </script>
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden text-gray-900">
    <aside class="w-60 bg-adminNavy text-gray-300 flex-shrink-0 flex flex-col">
        <div class="p-5 bg-gray-900">
            <h1 class="text-white font-bold text-lg tracking-tight">Barangay 419 Admin</h1>
        </div>

        <nav class="flex-grow py-4">
            <p class="px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Main Menu</p>
            
            <a href="{{ route('dashboard') }}" 
               class="flex items-center px-6 py-2.5 text-sm transition-colors {{ request()->routeIs('dashboard') ? 'bg-adminBlue text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                Dashboard
            </a>

            <a href="{{ route('admin.residents.index') }}" 
               class="flex items-center px-6 py-2.5 text-sm transition-colors {{ request()->routeIs('admin.residents.*') ? 'bg-adminBlue text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                Resident Records
            </a>

            <a href="{{ route('admin.schedules.index') }}" 
               class="flex items-center px-6 py-2.5 text-sm transition-colors {{ request()->routeIs('admin.schedules.*') ? 'bg-adminBlue text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                Schedules
            </a>

            {{-- ADDED: Document Requests Link --}}
            <a href="{{ route('admin.documents.index') }}" 
               class="flex items-center px-6 py-2.5 text-sm transition-colors {{ request()->routeIs('admin.documents.*') ? 'bg-adminBlue text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                Document Requests
            </a>

            <a href="#" 
               class="flex items-center px-6 py-2.5 text-sm hover:bg-gray-700 hover:text-white">
                Reports
            </a>
        </nav>

        <div class="p-4 border-t border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-2 py-1 text-sm text-red-400 hover:text-red-300 font-medium">
                    Log Out
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-grow flex flex-col min-w-0">
        <header class="h-14 bg-white border-b border-gray-200 flex items-center justify-between px-8">
            <div class="text-sm font-medium text-gray-500">
                System Administrator Portal
            </div>
            
            <div class="text-sm flex items-center gap-4">
                <span class="text-gray-400">|</span>
                <span class="font-semibold text-gray-700">Administrator</span>
            </div>
        </header>

        <main class="flex-grow overflow-y-auto p-6">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-200 text-green-700 text-sm rounded">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>