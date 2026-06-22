@extends('layouts.client')

@section('content')

    {{-- Hero Section --}}
    <header class="relative min-h-screen flex items-center overflow-hidden hero-gradient">
        {{-- Background pattern --}}
        <div class="absolute inset-0 opacity-[0.07]" style="background-image: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\");"></div>

        {{-- Glowing orbs --}}
        <div class="absolute top-20 right-10 w-[500px] h-[500px] rounded-full bg-white/5 blur-[120px]"></div>
        <div class="absolute -bottom-20 -left-20 w-[400px] h-[400px] rounded-full bg-white/5 blur-[100px]"></div>

        @if(session('success'))
            <div class="absolute top-28 left-0 right-0 z-20 max-w-2xl mx-auto px-6">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 text-white p-4 rounded-2xl font-bold text-center shadow-2xl">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="relative z-10 max-w-7xl mx-auto px-6 pt-32 pb-20 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                {{-- Left: Text --}}
                <div class="text-white">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-xs font-bold tracking-[0.2em] uppercase mb-8">
                        <div class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></div>
                        Official Information Portal · Zone 43, District IV
                    </div>
                    <h1 class="text-5xl md:text-6xl xl:text-7xl font-extrabold leading-[1.05] mb-6 tracking-tight">
                        Serving the<br>
                        People of<br>
                        <span class="text-white/60">Barangay 419</span>
                    </h1>
                    <p class="text-white/60 text-lg max-w-md mb-10 font-medium leading-relaxed">
                        Dedicated to transparency, unity, and professional public service for the community of Sampaloc, Manila.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#announcements"
                           class="px-8 py-4 bg-white text-brgyGreen font-extrabold rounded-2xl hover:bg-white/90 transition-all text-sm tracking-widest uppercase shadow-xl shadow-black/20">
                            View Announcements
                        </a>
                        <a href="#services"
                           class="px-8 py-4 border-2 border-white/20 text-white font-bold rounded-2xl hover:bg-white/10 transition-all text-sm tracking-widest uppercase backdrop-blur-sm">
                            Our Services
                        </a>
                    </div>
                </div>

                {{-- Right: Stats + Logo --}}
                <div class="hidden lg:flex flex-col items-center gap-8">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white/10 rounded-full blur-3xl scale-110"></div>
                        <img src="{{ asset('images/brgy_logo.png') }}"
                             alt="Barangay 419 Logo"
                             class="relative w-56 h-56 object-contain drop-shadow-2xl">
                    </div>
                    <div class="grid grid-cols-2 gap-4 w-full max-w-xs">
                        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-5 text-white text-center">
                            <p class="text-3xl font-extrabold">419</p>
                            <p class="text-xs text-white/50 font-bold uppercase tracking-widest mt-1">Barangay</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-5 text-white text-center">
                            <p class="text-3xl font-extrabold">IV</p>
                            <p class="text-xs text-white/50 font-bold uppercase tracking-widest mt-1">District</p>
                        </div>
                        <div class="col-span-2 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-5 text-white text-center">
                            <p class="text-lg font-extrabold uppercase tracking-tight">Sampaloc, Manila</p>
                            <p class="text-xs text-white/50 font-bold uppercase tracking-widest mt-1">Location</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom wave --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 80L1440 80L1440 40C1200 80 960 0 720 20C480 40 240 80 0 40L0 80Z" fill="#f8fafc"/>
            </svg>
        </div>
    </header>

    {{-- Services Section --}}
    <section id="services" class="py-28 max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 bg-brgyGreen/10 text-brgyGreen rounded-full text-xs font-black tracking-[0.25em] uppercase mb-4">Public Services</span>
            <h2 class="text-4xl font-extrabold text-slate-900 tracking-tight">Available Documents</h2>
            <p class="text-slate-500 mt-4 max-w-lg mx-auto font-medium">Learn about the requirements and processes for each barangay issuance.</p>
        </div>

        @php
        $services = [
            ['title' => 'Business Permits', 'desc' => 'For operating a business within the barangay', 'slug' => 'business-permit',
             'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A4.806 4.806 0 0 1 9 10.37a4.806 4.806 0 0 1 3.75-1.637 4.806 4.806 0 0 1 3.75 1.637 3.001 3.001 0 0 0 3.75.615"/>'],
            ['title' => 'Barangay ID',     'desc' => 'Official identification for barangay residents',   'slug' => 'barangay-id',
             'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z"/>'],
            ['title' => 'Cedula',           'desc' => 'Community tax certificate for residents',          'slug' => 'cedula',
             'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6v.75m0 3v.75m0 3v.75m0 3V18m15-10.5v10.5m-15-10.5h15"/>'],
            ['title' => 'Clearances',       'desc' => 'Proof of good standing in the community',         'slug' => 'barangay-clearance',
             'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.959 11.959 0 0 1 12 2.714Z"/>'],
        ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($services as $s)
            <a href="{{ route('services.show', $s['slug']) }}"
               class="group relative bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:border-brgyGreen/20 transition-all duration-300 p-8 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-brgyGreen/5 rounded-full -translate-y-10 translate-x-10 group-hover:bg-brgyGreen/10 transition-colors"></div>
                <div class="relative">
                    <div class="w-12 h-12 bg-brgyGreen/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-brgyGreen group-hover:scale-110 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"
                             class="w-6 h-6 text-brgyGreen group-hover:text-white transition-colors">
                            {!! $s['icon'] !!}
                        </svg>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-800 mb-2 group-hover:text-brgyGreen transition-colors">{{ $s['title'] }}</h3>
                    <p class="text-slate-400 text-xs font-medium leading-relaxed mb-4">{{ $s['desc'] }}</p>
                    <span class="text-brgyGreen text-xs font-black uppercase tracking-widest flex items-center gap-1">
                        View Requirements
                        <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </div>
            </a>
            @endforeach
        </div>
    </section>

    {{-- Officials Section --}}
    <section id="officials" class="py-28 bg-darkGreen rounded-[3rem] mx-4 md:mx-10 mb-20 text-white shadow-2xl overflow-hidden relative">
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='1' fill-rule='evenodd'%3E%3Ccircle cx='7' cy='7' r='1'/%3E%3Ccircle cx='27' cy='7' r='1'/%3E%3Ccircle cx='47' cy='7' r='1'/%3E%3Ccircle cx='7' cy='27' r='1'/%3E%3Ccircle cx='27' cy='27' r='1'/%3E%3Ccircle cx='47' cy='27' r='1'/%3E%3Ccircle cx='7' cy='47' r='1'/%3E%3Ccircle cx='27' cy='47' r='1'/%3E%3Ccircle cx='47' cy='47' r='1'/%3E%3C/g%3E%3C/svg%3E\");"></div>
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-brgyGreen/10 rounded-full blur-[150px] -translate-y-1/2 translate-x-1/4"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-20">
                <span class="inline-block px-4 py-1.5 bg-white/10 border border-white/20 rounded-full text-xs font-black tracking-[0.25em] uppercase mb-4 text-white/70">Leadership</span>
                <h2 class="text-4xl font-extrabold uppercase tracking-tight">Our Elected Officials</h2>
            </div>

            {{-- Punong Barangay --}}
            <div class="flex flex-col items-center mb-20">
                <div class="relative mb-6">
                    <div class="absolute inset-0 bg-white/20 rounded-full blur-2xl scale-110"></div>
                    <div class="relative w-32 h-32 bg-white/10 rounded-full border-2 border-white/30 flex items-center justify-center shadow-2xl overflow-hidden">
                        <svg class="w-16 h-16 text-white/30" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-extrabold tracking-tight">Erwin R. Molina</h3>
                <div class="mt-2 px-4 py-1 bg-white/15 border border-white/20 rounded-full">
                    <p class="text-white text-[10px] uppercase font-black tracking-[0.2em]">Punong Barangay</p>
                </div>
            </div>

            {{-- Kagawads --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 max-w-5xl mx-auto">
                @php $officials = [
                    ['name' => 'John Carlo C. Solomon',    'role' => 'Kagawad'],
                    ['name' => 'Reynaldo J. Dauz Jr.',     'role' => 'Kagawad'],
                    ['name' => 'Jesus C. Anunciacion',     'role' => 'Kagawad'],
                    ['name' => 'Claudine A. Dizon',        'role' => 'Kagawad'],
                    ['name' => 'Ian M. Perez',             'role' => 'Kagawad'],
                    ['name' => 'Ma. Teresita G. Quintana', 'role' => 'Kagawad'],
                    ['name' => 'Enerson R. Molina',        'role' => 'Kagawad'],
                    ['name' => 'Alaine Joy T. Ambito',     'role' => 'SK Chairperson'],
                ]; @endphp
                @foreach($officials as $off)
                <div class="bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl p-5 flex flex-col items-center text-center transition-all">
                    <div class="w-14 h-14 bg-white/10 rounded-xl flex items-center justify-center mb-3 overflow-hidden">
                        <svg class="w-8 h-8 text-white/20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                        </svg>
                    </div>
                    <h4 class="font-bold text-xs leading-snug mb-1">{{ $off['name'] }}</h4>
                    <p class="text-white/40 text-[9px] uppercase font-black tracking-widest">{{ $off['role'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Announcements Section --}}
    <section id="announcements" class="py-28 max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16">
            <div>
                <span class="inline-block px-4 py-1.5 bg-brgyGreen/10 text-brgyGreen rounded-full text-xs font-black tracking-[0.25em] uppercase mb-4">Community Feed</span>
                <h2 class="text-4xl font-extrabold text-slate-900 tracking-tight">Barangay Announcements</h2>
            </div>
            <p class="text-slate-400 text-sm font-medium max-w-xs">Stay updated with the latest news and announcements from Barangay 419.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($announcements as $announcement)
                <article class="bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:border-brgyGreen/20 transition-all duration-300 overflow-hidden flex flex-col group">
                    @if($announcement->is_pinned)
                        <div class="bg-brgyGreen text-white text-[9px] uppercase tracking-[0.2em] font-extrabold px-5 py-2 flex items-center gap-2">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5.2v6h1.6v-6H18v-2l-2-2z"/></svg>
                            Pinned Announcement
                        </div>
                    @endif

                    @if($announcement->image_url)
                        <div class="h-52 overflow-hidden">
                            <img src="{{ Storage::url($announcement->image_url) }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 alt="{{ $announcement->title }}">
                        </div>
                    @endif

                    <div class="p-8 flex flex-col flex-1">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="px-3 py-1 bg-brgyGreen/10 text-brgyGreen rounded-lg text-[9px] font-black uppercase tracking-widest">
                                {{ $announcement->category }}
                            </span>
                            <span class="text-slate-300 text-xs">•</span>
                            <span class="text-slate-400 text-xs font-bold">{{ $announcement->created_at->diffForHumans() }}</span>
                        </div>
                        <h3 class="font-extrabold text-slate-800 text-xl mb-3 leading-snug group-hover:text-brgyGreen transition-colors">
                            {{ $announcement->title }}
                        </h3>
                        <p class="text-slate-500 text-sm leading-relaxed line-clamp-3 flex-1">
                            {{ $announcement->content }}
                        </p>
                        <div class="mt-6 pt-5 border-t border-slate-50 flex items-center justify-between">
                            <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.2em]">Official Bulletin</span>
                            <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.2em]">
                                {{ $announcement->created_at->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full bg-white p-20 rounded-3xl text-center border border-slate-100">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                    </div>
                    <p class="text-slate-400 font-bold text-sm">No announcements posted at the moment.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Activities Section --}}
    <section id="schedule" class="py-28 max-w-7xl mx-auto px-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16">
            <div>
                <span class="inline-block px-4 py-1.5 bg-brgyGreen/10 text-brgyGreen rounded-full text-xs font-black tracking-[0.25em] uppercase mb-4">Calendar</span>
                <h2 class="text-4xl font-extrabold text-slate-900 tracking-tight">Upcoming Activities</h2>
            </div>
            <p class="text-slate-400 text-sm font-medium max-w-xs">Events and activities happening in Barangay 419.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($events as $event)
                @php
                    $eventImageUrl = $event->image ? asset('storage/' . $event->image) : '';
                    $day   = \Carbon\Carbon::parse($event->schedule_date)->format('d');
                    $month = \Carbon\Carbon::parse($event->schedule_date)->format('M');
                    $dateF = \Carbon\Carbon::parse($event->schedule_date)->format('M d, Y');
                    $timeF = \Carbon\Carbon::parse($event->schedule_time)->format('h:i A') . ' - ' . \Carbon\Carbon::parse($event->schedule_time_to)->format('h:i A');
                @endphp
                <div onclick="openEventModal('{{ addslashes($event->title) }}', '{{ $eventImageUrl }}', '{{ $dateF }}', '{{ $timeF }}')"
                     class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:border-brgyGreen/20 transition-all duration-300 overflow-hidden cursor-pointer">

                    <div class="h-48 relative overflow-hidden">
                        @if($event->image)
                            <img src="{{ $eventImageUrl }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 alt="{{ $event->title }}">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-brgyGreen/5 to-darkGreen/10 flex items-center justify-center">
                                <svg class="w-12 h-12 text-brgyGreen/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4 bg-brgyGreen text-white px-3 py-2 rounded-xl text-center shadow-lg min-w-[52px]">
                            <span class="block text-2xl font-black leading-none">{{ $day }}</span>
                            <span class="text-[9px] uppercase font-bold tracking-widest opacity-80">{{ $month }}</span>
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="font-extrabold text-slate-800 text-base mb-2 group-hover:text-brgyGreen transition-colors leading-snug">
                            {{ $event->title }}
                        </h3>
                        <div class="flex items-center gap-2 text-slate-400 text-xs font-bold uppercase tracking-widest mb-4">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ \Carbon\Carbon::parse($event->schedule_time)->format('h:i A') }}
                        </div>
                        <div class="pt-4 border-t border-slate-50">
                            <span class="text-brgyGreen text-xs font-black uppercase tracking-widest flex items-center gap-1">
                                View Details
                                <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white p-20 rounded-3xl text-center border border-slate-100">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p class="text-slate-400 font-bold text-sm">No upcoming activities at the moment.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Event Modal --}}
    <div id="eventDetailModal"
         onclick="handleBackdropClick(event)"
         class="fixed inset-0 bg-slate-900/80 backdrop-blur-md z-[100] hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl transform transition-all scale-95 opacity-0 duration-300 relative" id="modalContainer">
            <button onclick="closeEventModal()"
                    class="absolute top-5 right-5 w-10 h-10 bg-black/30 text-white rounded-full flex items-center justify-center hover:bg-black/50 transition-all z-[110]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div class="relative h-72 w-full bg-slate-100">
                <img id="modalImg" src="" class="w-full h-full object-contain bg-slate-900 hidden" alt="">
                <div id="modalNoImg" class="w-full h-full flex flex-col items-center justify-center text-slate-300">
                    <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="font-bold uppercase tracking-widest text-xs">No Pubmat Available</p>
                </div>
            </div>
            <div class="p-8">
                <span id="modalDate" class="text-brgyGreen font-bold tracking-[0.2em] uppercase text-[10px] block mb-2"></span>
                <h3 id="modalTitle" class="text-2xl font-extrabold text-slate-900 mb-3 leading-tight"></h3>
                <div class="flex items-center gap-2 text-slate-500 text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span id="modalTime"></span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openEventModal(title, image, date, time) {
            const modal     = document.getElementById('eventDetailModal');
            const container = document.getElementById('modalContainer');
            const img       = document.getElementById('modalImg');
            const noImg     = document.getElementById('modalNoImg');

            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalDate').innerText  = date;
            document.getElementById('modalTime').innerText  = time;

            if (image && image !== '') {
                img.src = image;
                img.classList.remove('hidden');
                noImg.classList.add('hidden');
            } else {
                img.src = '';
                img.classList.add('hidden');
                noImg.classList.remove('hidden');
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => container.classList.remove('scale-95', 'opacity-0'), 10);
            document.body.style.overflow = 'hidden';
        }

        function closeEventModal() {
            const modal     = document.getElementById('eventDetailModal');
            const container = document.getElementById('modalContainer');
            container.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }, 300);
        }

        function handleBackdropClick(e) {
            if (!document.getElementById('modalContainer').contains(e.target)) closeEventModal();
        }

        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeEventModal(); });
    </script>
@endsection
