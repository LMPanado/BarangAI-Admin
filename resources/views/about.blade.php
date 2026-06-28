@extends('layouts.client')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 pt-32 pb-20">

    {{-- Hero Banner --}}
    <div class="hero-gradient rounded-3xl p-10 md:p-16 text-white mb-8 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5" style="background-image:radial-gradient(circle at 70% 50%, white 1px, transparent 1px); background-size: 28px 28px;"></div>
        <div class="relative z-10">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/15 rounded-full text-[10px] font-black tracking-[0.25em] uppercase mb-5">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Zone 43 · District IV · Manila
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight mb-4">About Barangay 419</h1>
            <p class="text-white/80 max-w-2xl text-base font-medium leading-relaxed">
                Serving the heart of Sampaloc, Manila. Committed to transparency, safety, and digital-first public service for every resident of Barangay 419.
            </p>
        </div>
    </div>

    {{-- Info Cards Row --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8 mt-8">

        {{-- Address --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-7 flex flex-col gap-4">
            <div class="w-11 h-11 rounded-2xl bg-brgyGreen/8 flex items-center justify-center">
                <svg class="w-5 h-5 text-brgyGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Official Address</p>
                <p class="text-slate-800 font-extrabold text-sm leading-relaxed">
                    Barangay 419 Zone 43 District IV<br>
                    Loreto St. Sampaloc,<br>
                    Manila, Philippines 1008
                </p>
            </div>
        </div>

        {{-- Operating Hours --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-7 flex flex-col gap-4">
            <div class="w-11 h-11 rounded-2xl bg-brgyGreen/8 flex items-center justify-center">
                <svg class="w-5 h-5 text-brgyGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Operating Hours</p>
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold text-slate-500">Mon – Sat</span>
                        <span class="text-xs font-extrabold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg">24 Hours</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold text-slate-500">Sunday</span>
                        <span class="text-xs font-extrabold text-red-500 bg-red-50 px-2.5 py-1 rounded-lg">Closed</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Social / Connect --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-7 flex flex-col gap-4">
            <div class="w-11 h-11 rounded-2xl bg-brgyGreen/8 flex items-center justify-center">
                <svg class="w-5 h-5 text-brgyGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Connect With Us</p>
                <a href="https://www.facebook.com/profile.php?id=61562239220224"
                   target="_blank" rel="noopener noreferrer"
                   class="flex items-center gap-3 p-3 rounded-2xl bg-blue-50 hover:bg-blue-100 border border-blue-100 transition-all group">
                    <div class="w-8 h-8 rounded-xl bg-blue-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-extrabold text-blue-700">Facebook Page</p>
                        <p class="text-[10px] text-blue-400 font-medium">Barangay 419 Official</p>
                    </div>
                    <svg class="w-3.5 h-3.5 text-blue-300 group-hover:text-blue-500 ml-auto transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>

    {{-- Map Section --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-7 pt-7 pb-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-brgyGreen/8 flex items-center justify-center">
                <svg class="w-4 h-4 text-brgyGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Map & Location</p>
        </div>
        <div style="height: 400px;">
            <iframe
                src="https://maps.google.com/maps?q=Loreto+St+Sampaloc+Manila+Philippines&output=embed&z=17"
                width="100%"
                height="100%"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>

</div>
@endsection
