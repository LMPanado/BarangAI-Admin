@extends('layouts.client')

@section('content')
<div class="min-h-screen bg-[#f8fafc]">
    {{-- Hero Section for Page Title --}}
    <div class="hero-gradient pt-32 pb-20 px-6 rounded-b-[3rem] text-center">
        <div class="max-w-7xl mx-auto">
            <span class="text-white/60 font-black tracking-[0.4em] uppercase text-[10px] block mb-4">Resident Dashboard</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Official Document <span class="text-brgyGold">Tracking</span></h1>
            <p class="text-white/60 text-sm max-w-xl mx-auto font-medium">
                Monitor the status of your requested certifications and official documents in real-time.
            </p>
        </div>
    </div>

    {{-- Main Content --}}
    <main class="-mt-12 pb-20 max-w-7xl mx-auto px-6">
        
        {{-- Success Alert --}}
        @if(session('success'))
        <div class="mb-8 p-4 bg-white/80 backdrop-blur-md border border-green-100 text-green-700 rounded-2xl font-bold text-sm shadow-xl shadow-green-900/5 flex items-center gap-3 animate-bounce">
            <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-xs shadow-lg shadow-green-500/30">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            {{ session('success') }}
        </div>
        @endif

        {{-- Table Container --}}
        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">Reference #</th>
                            <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">Document Type</th>
                            <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">Date Requested</th>
                            <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($requests as $request)
                        <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                            <td class="px-10 py-7">
                                <span class="font-black text-slate-300 group-hover:text-brgyGreen transition-colors">#{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-10 py-7">
                                <div class="flex flex-col">
                                    <span class="font-extrabold text-slate-800 uppercase text-xs tracking-wider mb-1">
                                        {{ str_replace('_', ' ', $request->document_type) }}
                                    </span>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Official Certification</span>
                                </div>
                            </td>
                            <td class="px-10 py-7">
                                <span class="text-xs text-slate-500 font-bold tracking-tight">
                                    {{ $request->created_at->format('M d, Y') }}
                                </span>
                            </td>
                            <td class="px-10 py-7 text-right">
                                @php
                                    $statusStyle = match(strtolower($request->status)) {
                                        'pending' => 'bg-orange-50 text-orange-600 border-orange-100 shadow-orange-900/5',
                                        'ready' => 'bg-blue-50 text-blue-600 border-blue-100 shadow-blue-900/5',
                                        'issued' => 'bg-green-50 text-green-600 border-green-100 shadow-green-900/5',
                                        'cancelled' => 'bg-red-50 text-red-600 border-red-100 shadow-red-900/5',
                                        default => 'bg-slate-50 text-slate-600 border-slate-100'
                                    };
                                @endphp
                                <span class="inline-block px-5 py-2 rounded-xl text-[9px] font-black uppercase border shadow-sm {{ $statusStyle }}">
                                    {{ $request->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-10 py-32 text-center">
                                <div class="relative mb-6 inline-block">
                                    <div class="absolute inset-0 bg-brgyGreen/5 rounded-full blur-2xl"></div>
                                    <span class="relative text-6xl block transform grayscale opacity-30">📁</span>
                                </div>
                                <h3 class="text-slate-800 font-extrabold text-lg mb-2">No Requests Found</h3>
                                <p class="text-slate-400 font-medium text-sm mb-8">It looks like you haven't made any document requests yet.</p>
                                <a href="{{ route('client.request.form') }}" 
                                   class="inline-flex items-center gap-3 bg-brgyGreen text-white px-8 py-3.5 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-darkGreen transition shadow-xl shadow-brgyGreen/20">
                                    New Request
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Help Card --}}
        <div class="mt-12 bg-darkGreen p-8 rounded-[2rem] flex flex-col md:flex-row items-center justify-between gap-6 shadow-2xl shadow-darkGreen/20">
            <div class="flex items-center gap-6">
                <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center text-2xl">💡</div>
                <div>
                    <h4 class="text-white font-extrabold uppercase tracking-widest text-sm mb-1">Need help with your request?</h4>
                    <p class="text-white/40 text-xs font-medium uppercase tracking-wider">Contact the Barangay Secretary for immediate assistance.</p>
                </div>
            </div>
            <a href="#" class="bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition">
                View FAQ
            </a>
        </div>
    </main>
</div>
@endsection