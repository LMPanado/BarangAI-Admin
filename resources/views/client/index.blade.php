@extends('layouts.client')

@section('content')

{{-- ═══════════════════════════════════════════
     HERO
═══════════════════════════════════════════ --}}
<header class="relative min-h-screen flex items-center overflow-hidden" style="background: linear-gradient(135deg, #0f2d6b 0%, #1d4ed8 60%, #2563eb 100%);">

    <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-white/3 rounded-full blur-[160px] -translate-x-1/2 -translate-y-1/2"></div>

    @if(session('success'))
        <div class="absolute top-28 inset-x-0 z-20 flex justify-center px-6">
            <div class="bg-white/10 backdrop-blur-md border border-white/20 text-white px-6 py-4 rounded-2xl font-bold text-sm shadow-2xl">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 pt-28 md:pt-36 pb-24 md:pb-32 w-full">
        <div class="max-w-3xl">
            {{-- Eyebrow --}}
            <div class="flex items-center gap-3 mb-8 md:mb-10">
                <div class="flex items-center gap-2 px-4 py-2 bg-white/10 border border-white/15 rounded-full backdrop-blur-sm">
                    <div class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></div>
                    <span class="text-white/80 text-[10px] font-black uppercase tracking-[0.25em]">Official Information Portal</span>
                </div>
            </div>

            {{-- Headline --}}
            <h1 class="text-4xl sm:text-5xl md:text-7xl xl:text-8xl font-extrabold text-white leading-[1] tracking-tight mb-6 md:mb-8">
                Barangay<br>
                <span class="text-white/40">419</span>
            </h1>

            <p class="text-white/60 text-base md:text-xl font-medium leading-relaxed max-w-xl mb-8 md:mb-12">
                Serving the community of Zone 43, District IV, Sampaloc, Manila with transparency and digital innovation.
            </p>

            <div class="flex flex-wrap gap-3 md:gap-4">
                <a href="#announcements"
                   class="inline-flex items-center gap-2 px-7 py-4 bg-white text-brgyGreen font-extrabold rounded-2xl hover:bg-white/90 transition-all text-xs tracking-widest uppercase shadow-2xl shadow-black/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    Announcements
                </a>
                <a href="#services"
                   class="inline-flex items-center gap-2 px-7 py-4 border border-white/20 text-white font-bold rounded-2xl hover:bg-white/10 transition-all text-xs tracking-widest uppercase backdrop-blur-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Our Services
                </a>
            </div>
        </div>

        {{-- Floating logo --}}
        <div class="absolute right-16 top-1/2 -translate-y-1/2 hidden xl:flex flex-col items-center">
            <div class="relative">
                <div class="absolute inset-0 bg-white/10 rounded-full blur-3xl scale-150"></div>
                <img src="{{ asset('images/brgy_logo.png') }}"
                     alt="Barangay 419"
                     class="relative w-72 h-72 object-contain drop-shadow-[0_0_80px_rgba(255,255,255,0.2)]">
            </div>
        </div>
    </div>

    {{-- Wave divider --}}
    <div class="absolute bottom-0 inset-x-0">
        <svg viewBox="0 0 1440 100" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" class="w-full">
            <path d="M0 100V60C180 100 360 20 540 40C720 60 900 100 1080 80C1260 60 1350 30 1440 50V100H0Z" fill="#f8fafc"/>
        </svg>
    </div>
</header>

{{-- ═══════════════════════════════════════════
     SERVICES
═══════════════════════════════════════════ --}}
<section id="services" class="py-16 md:py-28 max-w-7xl mx-auto px-4 sm:px-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">

        {{-- Left: Header + description --}}
        <div class="lg:sticky lg:top-32">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-brgyGreen/8 text-brgyGreen rounded-full text-[10px] font-black tracking-[0.25em] uppercase mb-6">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Barangay Services
            </span>
            <h2 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight mb-6">
                Documents &<br>Processes
            </h2>
            <p class="text-slate-500 text-base font-medium leading-relaxed mb-8 max-w-sm">
                Learn the requirements and step-by-step process for each barangay issuance. Click any service to view details.
            </p>
            <div class="w-12 h-1 bg-brgyGreen rounded-full"></div>
        </div>

        {{-- Right: Service cards --}}
        @php
        $services = [
            ['title'=>'Barangay Clearance', 'slug'=>'barangay-clearance', 'desc'=>'Required for employment, business, and other legal transactions.',
             'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.959 11.959 0 0 1 12 2.714Z"/>'],
            ['title'=>'Barangay ID',        'slug'=>'barangay-id',        'desc'=>'Official identification issued to residents of Barangay 419.',
             'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z"/>'],
            ['title'=>'Business Permit',    'slug'=>'business-permit',    'desc'=>'Required to legally operate a business within the barangay.',
             'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A4.806 4.806 0 0 1 9 10.37a4.806 4.806 0 0 1 3.75-1.637 4.806 4.806 0 0 1 3.75 1.637 3.001 3.001 0 0 0 3.75.615"/>'],
        ];
        @endphp

        <div class="flex flex-col gap-4">
            @foreach($services as $i => $s)
            <a href="{{ route('services.show', $s['slug']) }}"
               class="group flex items-center gap-5 bg-white border border-slate-100 rounded-2xl p-6 hover:border-brgyGreen/30 hover:shadow-lg shadow-sm transition-all duration-300">
                <div class="w-14 h-14 bg-brgyGreen/8 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-brgyGreen transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"
                         class="w-6 h-6 text-brgyGreen group-hover:text-white transition-colors">
                        {!! $s['icon'] !!}
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-extrabold text-slate-800 text-sm mb-1 group-hover:text-brgyGreen transition-colors">{{ $s['title'] }}</h3>
                    <p class="text-slate-400 text-xs font-medium leading-relaxed">{{ $s['desc'] }}</p>
                </div>
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 rounded-xl bg-slate-50 group-hover:bg-brgyGreen flex items-center justify-center transition-all">
                        <svg class="w-4 h-4 text-slate-300 group-hover:text-white transition-colors group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     OFFICIALS
═══════════════════════════════════════════ --}}
<section id="officials" class="py-16 md:py-28 mx-3 md:mx-10 mb-10 md:mb-20 rounded-[2rem] md:rounded-[3rem] overflow-hidden relative" style="background: linear-gradient(135deg, #0f2d6b 0%, #1e3a8a 100%);">
    <div class="absolute inset-0 opacity-[0.03]" style="background-image:url(\"data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23fff' fill-opacity='1'%3E%3Ccircle cx='20' cy='20' r='1'/%3E%3C/g%3E%3C/svg%3E\");"></div>
    <div class="absolute -right-32 -top-32 w-[500px] h-[500px] rounded-full bg-brgyGreen/10 blur-[120px]"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-10 md:mb-16">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 border border-white/15 rounded-full text-[10px] font-black text-white/60 uppercase tracking-[0.25em] mb-5">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Leadership
            </span>
            <h2 class="text-4xl font-extrabold text-white tracking-tight">Elected Officials</h2>
        </div>

        {{-- Punong Barangay --}}
        <div class="flex justify-center mb-14">
            <div class="flex flex-col items-center gap-4">
                <div class="relative">
                    <div class="absolute inset-0 bg-white/20 rounded-full blur-2xl scale-125"></div>
                    <div class="relative w-28 h-28 rounded-full bg-white/10 border-2 border-white/20 flex items-center justify-center">
                        <span class="text-white font-extrabold text-3xl">EM</span>
                    </div>
                </div>
                <div class="text-center">
                    <h3 class="text-white font-extrabold text-xl tracking-tight">Erwin R. Molina</h3>
                    <span class="inline-block mt-2 px-4 py-1 bg-white/15 border border-white/20 rounded-full text-white/70 text-[9px] font-black uppercase tracking-[0.2em]">Punong Barangay</span>
                </div>
            </div>
        </div>

        {{-- Divider --}}
        <div class="flex items-center gap-4 max-w-xs mx-auto mb-14">
            <div class="flex-1 h-px bg-white/10"></div>
            <p class="text-white/25 text-[9px] font-black uppercase tracking-widest">Council Members</p>
            <div class="flex-1 h-px bg-white/10"></div>
        </div>

        {{-- Council Members --}}
        @php $officials = [
            ['name'=>'Victoria S. Burlaos',      'role'=>'Secretary',                    'initials'=>'VB'],
            ['name'=>'Romeo R. De Leon',          'role'=>'Treasurer',                    'initials'=>'RL'],
            ['name'=>'John Carlo C. Solomon',     'role'=>'Kagawad (Appropriations)',     'initials'=>'JS'],
            ['name'=>'Reynaldo J. Dauz Jr.',      'role'=>'Kagawad (Peace & Order)',      'initials'=>'RD'],
            ['name'=>'Jesus C. Anunciacion',      'role'=>'Kagawad (Rules & Education)',  'initials'=>'JA'],
            ['name'=>'Claudine A. Dizon',         'role'=>'Kagawad (Livelihood)',         'initials'=>'CD'],
            ['name'=>'Ian M. Perez',              'role'=>'Kagawad (Health)',             'initials'=>'IP'],
            ['name'=>'Ma. Teresita G. Quintana',  'role'=>'Kagawad (Environment)',        'initials'=>'TQ'],
            ['name'=>'Enerson R. Molina',         'role'=>'Kagawad (Entrepreneurship)',   'initials'=>'EM'],
            ['name'=>'Alaine Joy T. Ambito',      'role'=>'SK Chairperson',              'initials'=>'AA'],
            ['name'=>'Rustico B. Cuevas Jr.',     'role'=>'Executive Officer (BSG)',      'initials'=>'RC'],
        ]; @endphp
        @php $topRow = array_slice($officials, 0, 8); $bottomRow = array_slice($officials, 8); @endphp

        {{-- Top 8: 2 cols on mobile, 4 cols on desktop --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 md:gap-4 max-w-4xl mx-auto">
            @foreach($topRow as $off)
            <div class="flex flex-col items-center gap-3 p-4 md:p-5 bg-white/5 border border-white/8 rounded-2xl hover:bg-white/10 transition-all text-center">
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-white/10 border border-white/10 flex items-center justify-center">
                    <span class="text-white/60 font-extrabold text-sm">{{ $off['initials'] }}</span>
                </div>
                <div>
                    <p class="text-white font-bold text-xs leading-snug">{{ $off['name'] }}</p>
                    <p class="text-white/35 text-[9px] font-black uppercase tracking-widest mt-1">{{ $off['role'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Bottom 3: 2 cols on mobile (last card spans full), centered on desktop --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 md:gap-4 max-w-4xl mx-auto mt-3 md:mt-4 sm:max-w-[calc(75%-0.5rem)] md:max-w-[calc(75%-0.75rem)]">
            @foreach($bottomRow as $off)
            <div class="flex flex-col items-center gap-3 p-4 md:p-5 bg-white/5 border border-white/8 rounded-2xl hover:bg-white/10 transition-all text-center {{ $loop->last && $loop->iteration % 2 !== 0 ? 'col-span-2 sm:col-span-1' : '' }}">
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-white/10 border border-white/10 flex items-center justify-center">
                    <span class="text-white/60 font-extrabold text-sm">{{ $off['initials'] }}</span>
                </div>
                <div>
                    <p class="text-white font-bold text-xs leading-snug">{{ $off['name'] }}</p>
                    <p class="text-white/35 text-[9px] font-black uppercase tracking-widest mt-1">{{ $off['role'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     ANNOUNCEMENTS
═══════════════════════════════════════════ --}}
<section id="announcements" class="py-16 md:py-28 max-w-7xl mx-auto px-4 sm:px-6">

    {{-- Section Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            <span class="inline-flex items-center gap-2 px-3 py-1 bg-brgyGreen/8 text-brgyGreen rounded-full text-[10px] font-black tracking-[0.25em] uppercase mb-3">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                Community Feed
            </span>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Announcements</h2>
        </div>
    </div>

    @php
        $annCollection = collect($announcements);
        $getCatStyle = fn($cat) => match(strtolower($cat ?? 'bulletin')) {
            'health', 'health advisory'   => ['pill' => 'bg-emerald-50 text-emerald-700', 'bar' => 'bg-emerald-400'],
            'ordinance'                   => ['pill' => 'bg-violet-50 text-violet-700',   'bar' => 'bg-violet-400'],
            'notice', 'public notice'     => ['pill' => 'bg-amber-50 text-amber-700',     'bar' => 'bg-amber-400'],
            'advisory', 'health advisory' => ['pill' => 'bg-orange-50 text-orange-700',   'bar' => 'bg-orange-400'],
            default                       => ['pill' => 'bg-blue-50 text-blue-700',       'bar' => 'bg-blue-500'],
        };
    @endphp

    @if($annCollection->isEmpty())
    <div class="bg-white rounded-2xl p-16 text-center border border-slate-100">
        <div class="w-14 h-14 bg-brgyGreen/8 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6 text-brgyGreen/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
        </div>
        <p class="text-slate-400 font-bold text-sm">No announcements posted yet.</p>
    </div>
    @else

    {{-- Featured Announcement (pinned first, otherwise latest) --}}
    @php
        $featured    = $annCollection->firstWhere('is_pinned', true) ?? $annCollection->first();
        $rest        = $annCollection->filter(fn($a) => $a->id !== $featured->id)->values();
        $fImg        = $featured->image_url ? Storage::url($featured->image_url) : '';
        $fDate       = $featured->created_at->format('M d, Y');
        $fCategory   = $featured->category ?? 'Bulletin';
        $fPinned     = $featured->is_pinned ? 'true' : 'false';
        $fStyle      = $getCatStyle($fCategory);
    @endphp

    <article onclick="openAnnouncementModal(
                    {{ json_encode($featured->title) }},
                    {{ json_encode($fImg) }},
                    {{ json_encode($fDate) }},
                    {{ json_encode($fCategory) }},
                    {{ json_encode($featured->content) }},
                    {{ $fPinned }}
                 )"
             class="group relative bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl hover:border-brgyGreen/20 transition-all duration-300 mb-6 cursor-pointer">
        <div class="flex flex-col md:flex-row">
            {{-- Image --}}
            <div class="md:w-[35%] h-48 md:h-auto overflow-hidden flex-shrink-0">
                @if($featured->image_url)
                    <img src="{{ $fImg }}" alt="{{ $featured->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg,#eff6ff,#dbeafe);">
                        <svg class="w-16 h-16 text-brgyGreen/15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    </div>
                @endif
            </div>
            {{-- Content --}}
            <div class="flex-1 p-6 md:p-7 flex flex-col justify-between">
                <div>
                    <div class="flex items-center flex-wrap gap-2 mb-4">
                        @if($featured->is_pinned)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-brgyGreen text-white text-[9px] font-black uppercase tracking-widest rounded-lg">
                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 24 24"><path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5.2v6h1.6v-6H18v-2l-2-2z"/></svg>
                            Pinned
                        </span>
                        @endif
                        <span class="px-2.5 py-1 {{ $fStyle['pill'] }} rounded-lg text-[9px] font-black uppercase tracking-widest">{{ $fCategory }}</span>
                        <span class="ml-auto text-[9px] font-black text-slate-300 uppercase tracking-widest">{{ $fDate }}</span>
                    </div>
                    <h3 class="font-extrabold text-slate-800 text-lg md:text-xl leading-snug mb-2 group-hover:text-brgyGreen transition-colors">{{ $featured->title }}</h3>
                    <p class="text-slate-400 text-xs leading-relaxed line-clamp-2">{{ $featured->content }}</p>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-50 flex items-center gap-2 text-brgyGreen text-xs font-black uppercase tracking-widest">
                    Read Full Announcement
                    <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </div>
            </div>
        </div>
    </article>

    {{-- Remaining announcements as compact list cards --}}
    @if($rest->isNotEmpty())
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        @foreach($rest as $announcement)
        @php
            $annImg      = $announcement->image_url ? Storage::url($announcement->image_url) : '';
            $annDate     = $announcement->created_at->format('M d, Y');
            $annCategory = $announcement->category ?? 'Bulletin';
            $annPinned   = $announcement->is_pinned ? 'true' : 'false';
            $annStyle    = $getCatStyle($annCategory);
        @endphp
        <article onclick="openAnnouncementModal(
                        {{ json_encode($announcement->title) }},
                        {{ json_encode($annImg) }},
                        {{ json_encode($annDate) }},
                        {{ json_encode($annCategory) }},
                        {{ json_encode($announcement->content) }},
                        {{ $annPinned }}
                     )"
                 class="group flex items-stretch bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md hover:border-brgyGreen/20 transition-all duration-300 cursor-pointer">
            {{-- Category accent bar --}}
            <div class="w-1 flex-shrink-0 {{ $annStyle['bar'] }}"></div>
            {{-- Content --}}
            <div class="flex-1 px-5 py-4 flex items-center gap-4 min-w-0">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                        <span class="px-2 py-0.5 {{ $annStyle['pill'] }} rounded-md text-[8px] font-black uppercase tracking-widest">{{ $annCategory }}</span>
                        @if($announcement->is_pinned)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-brgyGreen text-white text-[8px] font-black uppercase tracking-widest rounded-md">
                            <svg class="w-2 h-2" fill="currentColor" viewBox="0 0 24 24"><path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5.2v6h1.6v-6H18v-2l-2-2z"/></svg>
                            Pinned
                        </span>
                        @endif
                    </div>
                    <h3 class="font-extrabold text-slate-800 text-sm leading-snug group-hover:text-brgyGreen transition-colors line-clamp-1">{{ $announcement->title }}</h3>
                    <p class="text-slate-400 text-xs mt-0.5 line-clamp-1">{{ $announcement->content }}</p>
                </div>
                <div class="flex flex-col items-end gap-2 flex-shrink-0">
                    <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest whitespace-nowrap">{{ $annDate }}</span>
                    <div class="w-7 h-7 rounded-xl bg-slate-50 group-hover:bg-brgyGreen flex items-center justify-center transition-all">
                        <svg class="w-3 h-3 text-slate-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </div>
        </article>
        @endforeach
    </div>
    @endif

    @endif

</section>

{{-- ═══════════════════════════════════════════
     ACTIVITIES
═══════════════════════════════════════════ --}}
<section id="schedule" class="py-16 md:py-28 max-w-7xl mx-auto px-4 sm:px-6 mb-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16">
        <div>
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-brgyGreen/8 text-brgyGreen rounded-full text-[10px] font-black tracking-[0.25em] uppercase mb-5">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Calendar
            </span>
            <h2 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">Upcoming Activities</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
            @php
                $imgUrl = $event->image ? asset('storage/' . $event->image) : '';
                $day    = \Carbon\Carbon::parse($event->schedule_date)->format('d');
                $mon    = \Carbon\Carbon::parse($event->schedule_date)->format('M');
                $dateF  = \Carbon\Carbon::parse($event->schedule_date)->format('M d, Y');
                $timeF  = \Carbon\Carbon::parse($event->schedule_time)->format('h:i A').' - '.\Carbon\Carbon::parse($event->schedule_time_to)->format('h:i A');
            @endphp
            <div onclick="openEventModal('{{ addslashes($event->title) }}','{{ $imgUrl }}','{{ $dateF }}','{{ $timeF }}')"
                 class="group bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl hover:border-brgyGreen/20 transition-all duration-300 cursor-pointer flex flex-col">
                <div class="h-48 relative overflow-hidden bg-slate-50">
                    @if($event->image)
                        <img src="{{ $imgUrl }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $event->title }}">
                    @else
                        <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg,#eff6ff,#dbeafe);">
                            <svg class="w-10 h-10 text-brgyGreen/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                    {{-- Date badge --}}
                    <div class="absolute top-4 left-4 bg-brgyGreen text-white rounded-xl px-3 py-2 text-center shadow-lg min-w-[52px]">
                        <span class="block text-2xl font-black leading-none">{{ $day }}</span>
                        <span class="text-[9px] uppercase font-bold tracking-widest opacity-80">{{ $mon }}</span>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <h3 class="font-extrabold text-slate-800 text-base mb-2 group-hover:text-brgyGreen transition-colors leading-snug">{{ $event->title }}</h3>
                    <div class="flex items-center gap-1.5 text-slate-400 text-xs font-bold uppercase tracking-widest mb-4">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ \Carbon\Carbon::parse($event->schedule_time)->format('h:i A') }}
                    </div>
                    <div class="mt-auto pt-4 border-t border-slate-50 flex items-center justify-between">
                        <span class="text-brgyGreen text-xs font-black uppercase tracking-widest flex items-center gap-1">
                            View Details
                            <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </span>
                        <span class="text-[9px] text-slate-300 font-bold uppercase tracking-widest">{{ $dateF }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-3xl p-20 text-center border border-slate-100">
                <div class="w-16 h-16 bg-brgyGreen/8 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-7 h-7 text-brgyGreen/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <p class="text-slate-400 font-bold text-sm">No upcoming activities at the moment.</p>
            </div>
        @endforelse
    </div>
</section>

{{-- ═══════════════════════════════════════════
     EVENT MODAL
═══════════════════════════════════════════ --}}
{{-- ═══════════════════════════════════════════
     ANNOUNCEMENT MODAL
═══════════════════════════════════════════ --}}
<div id="announcementModal" onclick="handleAnnBackdropClick(event)"
     class="fixed inset-0 bg-slate-900/80 backdrop-blur-md z-[100] hidden items-center justify-center p-4">
    <div id="annModalContainer"
         class="bg-white rounded-3xl w-full max-w-xl overflow-hidden shadow-2xl transform transition-all scale-95 opacity-0 duration-300 relative">
        <button onclick="closeAnnouncementModal()"
                class="absolute top-4 right-4 w-9 h-9 bg-black/20 hover:bg-black/40 text-white rounded-full flex items-center justify-center transition-all z-10">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div id="annModalImgWrap" class="relative h-64 bg-slate-100">
            <img id="annModalImg" src="" alt="" class="w-full h-full object-cover hidden">
            <div id="annModalNoImg" class="w-full h-full flex flex-col items-center justify-center text-slate-300 gap-3">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                <p class="text-xs font-bold uppercase tracking-widest">No Image</p>
            </div>
        </div>
        <div class="p-8 max-h-[55vh] overflow-y-auto">
            <div class="flex items-center gap-2 mb-3">
                <span id="annModalPinned" class="hidden inline-flex items-center gap-1.5 px-2.5 py-1 bg-brgyGreen text-white text-[9px] font-black uppercase tracking-widest rounded-lg">
                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 24 24"><path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5.2v6h1.6v-6H18v-2l-2-2z"/></svg>
                    Pinned
                </span>
                <span id="annModalCategory" class="px-2.5 py-1 bg-brgyGreen/10 text-brgyGreen rounded-lg text-[9px] font-black uppercase tracking-widest"></span>
            </div>
            <p id="annModalDate" class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mb-2"></p>
            <h3 id="annModalTitle" class="text-2xl font-extrabold text-slate-900 leading-tight mb-4"></h3>
            <p id="annModalContent" class="text-slate-500 text-sm leading-relaxed whitespace-pre-line"></p>
        </div>
    </div>
</div>

<div id="eventDetailModal" onclick="handleBackdropClick(event)"
     class="fixed inset-0 bg-slate-900/80 backdrop-blur-md z-[100] hidden items-center justify-center p-4">
    <div id="modalContainer"
         class="bg-white rounded-3xl w-full max-w-xl overflow-hidden shadow-2xl transform transition-all scale-95 opacity-0 duration-300 relative">
        <button onclick="closeEventModal()"
                class="absolute top-4 right-4 w-9 h-9 bg-black/20 hover:bg-black/40 text-white rounded-full flex items-center justify-center transition-all z-10">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div class="relative h-64 bg-slate-100">
            <img id="modalImg" src="" alt="" class="w-full h-full object-cover hidden">
            <div id="modalNoImg" class="w-full h-full flex flex-col items-center justify-center text-slate-300 gap-3">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-xs font-bold uppercase tracking-widest">No Pubmat Available</p>
            </div>
        </div>
        <div class="p-8">
            <p id="modalDate" class="text-brgyGreen text-[10px] font-black uppercase tracking-[0.2em] mb-2"></p>
            <h3 id="modalTitle" class="text-2xl font-extrabold text-slate-900 leading-tight mb-3"></h3>
            <div class="flex items-center gap-2 text-slate-500 text-sm font-medium">
                <svg class="w-4 h-4 text-brgyGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span id="modalTime"></span>
            </div>
        </div>
    </div>
</div>

<script>
function openAnnouncementModal(title, image, date, category, content, pinned) {
    const modal = document.getElementById('announcementModal');
    const box   = document.getElementById('annModalContainer');
    const img   = document.getElementById('annModalImg');
    const noImg = document.getElementById('annModalNoImg');
    document.getElementById('annModalTitle').innerText    = title;
    document.getElementById('annModalDate').innerText     = date;
    document.getElementById('annModalCategory').innerText = category;
    document.getElementById('annModalContent').innerText  = content;
    const pinnedEl = document.getElementById('annModalPinned');
    pinned ? pinnedEl.classList.remove('hidden') : pinnedEl.classList.add('hidden');
    if (image) { img.src = image; img.classList.remove('hidden'); noImg.classList.add('hidden'); }
    else        { img.src = '';   img.classList.add('hidden');    noImg.classList.remove('hidden'); }
    modal.classList.remove('hidden'); modal.classList.add('flex');
    setTimeout(() => box.classList.remove('scale-95','opacity-0'), 10);
    document.body.style.overflow = 'hidden';
}
function closeAnnouncementModal() {
    const modal = document.getElementById('announcementModal');
    const box   = document.getElementById('annModalContainer');
    box.classList.add('scale-95','opacity-0');
    setTimeout(() => { modal.classList.add('hidden'); modal.classList.remove('flex'); document.body.style.overflow = 'auto'; }, 300);
}
function handleAnnBackdropClick(e) { if (!document.getElementById('annModalContainer').contains(e.target)) closeAnnouncementModal(); }
document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeAnnouncementModal(); closeEventModal(); } });

function openEventModal(title, image, date, time) {
    const modal = document.getElementById('eventDetailModal');
    const box   = document.getElementById('modalContainer');
    const img   = document.getElementById('modalImg');
    const noImg = document.getElementById('modalNoImg');
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalDate').innerText  = date;
    document.getElementById('modalTime').innerText  = time;
    if (image) { img.src = image; img.classList.remove('hidden'); noImg.classList.add('hidden'); }
    else        { img.src = '';    img.classList.add('hidden');    noImg.classList.remove('hidden'); }
    modal.classList.remove('hidden'); modal.classList.add('flex');
    setTimeout(() => box.classList.remove('scale-95','opacity-0'), 10);
    document.body.style.overflow = 'hidden';
}
function closeEventModal() {
    const modal = document.getElementById('eventDetailModal');
    const box   = document.getElementById('modalContainer');
    box.classList.add('scale-95','opacity-0');
    setTimeout(() => { modal.classList.add('hidden'); modal.classList.remove('flex'); document.body.style.overflow = 'auto'; }, 300);
}
function handleBackdropClick(e) { if (!document.getElementById('modalContainer').contains(e.target)) closeEventModal(); }
</script>
@endsection
