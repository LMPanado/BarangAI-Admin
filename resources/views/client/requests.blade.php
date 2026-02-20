<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Requests | Barangay 419</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { brgyGreen: '#2d5a27', brgyGold: '#f1c40f', darkGreen: '#1e3d1a' },
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] }
                }
            }
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('navDropdown', () => ({
                open: false,
                toggle() { this.open = !this.open },
                close() { this.open = false }
            }))
        })
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 font-sans">
    <nav class="fixed top-0 w-full bg-white/80 backdrop-blur-md z-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center gap-4">
                <div class="w-10 h-10 bg-brgyGreen rounded-xl flex items-center justify-center font-bold text-white shadow-lg shadow-brgyGreen/20">419</div>
                <span class="font-extrabold text-brgyGreen text-lg uppercase tracking-tight">Request History</span>
            </a>
            
            <div class="flex items-center gap-8">
                <a href="/" class="text-xs font-bold text-slate-400 hover:text-brgyGreen transition uppercase tracking-widest underline underline-offset-8">Return Home</a>
                
                @auth
                <div x-data="navDropdown" class="relative">
                    <button @click="toggle()" @click.away="close()" class="flex items-center gap-2 focus:outline-none">
                        <span class="font-bold text-slate-700 text-sm">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 text-slate-400" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <div x-show="open" x-cloak class="absolute right-0 mt-4 w-56 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 z-50">
                        <a href="{{ route('client.profile') }}" class="block px-5 py-3 text-sm text-slate-600 hover:bg-slate-50 font-bold transition">My Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-5 py-3 text-sm text-red-500 hover:bg-red-50 font-bold transition">Logout</button>
                        </form>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <main class="pt-32 pb-20 max-w-7xl mx-auto px-6">
        <div class="mb-12">
            <span class="text-brgyGreen font-bold tracking-[0.3em] uppercase text-xs block mb-3">Document Tracking</span>
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">Your Requested Documents</h1>
        </div>

        @if(session('success'))
        <div class="mb-8 p-4 bg-green-50 border border-green-100 text-green-700 rounded-2xl font-bold text-sm flex items-center gap-3">
            <span class="w-6 h-6 bg-green-500 text-white rounded-full flex items-center justify-center text-[10px]">✓</span>
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-[3rem] shadow-[0_10px_40px_rgba(0,0,0,0.03)] border border-slate-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Reference #</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Document Type</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Date Requested</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($requests as $request)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-6 font-bold text-slate-400">#{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-8 py-6 font-bold text-slate-800 uppercase text-sm tracking-tight">
                            {{ str_replace('_', ' ', $request->document_type) }}
                        </td>
                        <td class="px-8 py-6 text-sm text-slate-500 font-medium">
                            {{ $request->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-8 py-6">
                            @php
                                $statusStyle = match(strtolower($request->status)) {
                                    'pending' => 'bg-orange-100 text-orange-600 border-orange-200',
                                    'ready' => 'bg-blue-100 text-blue-600 border-blue-200',
                                    'issued' => 'bg-green-100 text-green-600 border-green-200',
                                    'cancelled' => 'bg-red-100 text-red-600 border-red-200',
                                    default => 'bg-slate-100 text-slate-600 border-slate-200'
                                };
                            @endphp
                            <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase border {{ $statusStyle }}">
                                {{ $request->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center">
                            <div class="text-4xl mb-4 opacity-20">📂</div>
                            <p class="text-slate-400 font-medium italic">You haven't requested any documents yet.</p>
                            <a href="{{ route('client.request.form') }}" class="inline-block mt-4 text-xs font-bold text-brgyGreen uppercase tracking-widest hover:text-brgyGold">Start a Request →</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>