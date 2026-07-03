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
        <div class="max-w-3xl text-center md:text-left mx-auto md:mx-0">
            {{-- Eyebrow --}}
            <div class="flex items-center justify-center md:justify-start gap-3 mb-8 md:mb-10">
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

            <p class="text-white/60 text-base md:text-xl font-medium leading-relaxed max-w-xl mb-8 md:mb-12 mx-auto md:mx-0">
                Serving the community of Zone 43, District IV, Sampaloc, Manila with transparency and digital innovation.
            </p>

            <div class="flex flex-wrap justify-center md:justify-start gap-3 md:gap-4">
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
        <div class="lg:sticky lg:top-32 text-center lg:text-left">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-brgyGreen/8 text-brgyGreen rounded-full text-[10px] font-black tracking-[0.25em] uppercase mb-6">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Barangay Services
            </span>
            <h2 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight mb-6">
                Documents &<br>Processes
            </h2>
            <p class="text-slate-500 text-base font-medium leading-relaxed mb-8 max-w-sm mx-auto lg:mx-0">
                Learn the requirements and step-by-step process for each barangay issuance. Click any service to view details.
            </p>
            <div class="w-12 h-1 bg-brgyGreen rounded-full mx-auto lg:mx-0"></div>
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
            ['title'=>'Certificate of Indigency', 'slug'=>'certificate-of-indigency', 'desc'=>'Certifies low-income status for access to government assistance and social services.',
             'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z"/>'],
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

        {{-- Section header --}}
        <div class="text-center mb-10 md:mb-16">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 border border-white/15 rounded-full text-[10px] font-black text-white/60 uppercase tracking-[0.25em] mb-5">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Leadership
            </span>
            <h2 class="text-4xl font-extrabold text-white tracking-tight">Elected Officials</h2>
        </div>

        {{-- ── ORG CHART ── --}}
        <div id="org-chart-wrap" class="overflow-x-auto pb-2" style="position:relative;">
            {{-- SVG connector lines (drawn by JS after layout) --}}
            <svg id="org-svg" style="position:absolute;top:0;left:0;width:100%;height:100%;pointer-events:none;overflow:visible;" xmlns="http://www.w3.org/2000/svg"></svg>

            <div style="min-width:1100px; position:relative;">

                {{-- ── LEVEL 1: Punong Barangay ── --}}
                <div style="display:flex;justify-content:center;margin-bottom:0;">
                    <div id="onode-erwin" style="display:flex;flex-direction:column;align-items:center;text-align:center;padding:16px 24px;background:rgba(255,255,255,0.1);border:2px solid rgba(255,255,255,0.25);border-radius:16px;min-width:160px;">
                        <div style="width:52px;height:52px;border-radius:12px;background:rgba(255,255,255,0.18);border:1.5px solid rgba(255,255,255,0.25);display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                            <span style="font-size:15px;font-weight:900;color:rgba(255,255,255,0.85);">EM</span>
                        </div>
                        <p style="font-size:13px;font-weight:800;color:#fff;margin:0 0 5px;line-height:1.3;">Erwin R. Molina</p>
                        <p style="font-size:8.5px;font-weight:900;color:rgba(255,255,255,0.45);text-transform:uppercase;letter-spacing:0.14em;margin:0;">Punong Barangay</p>
                    </div>
                </div>

                {{-- spacer for connector lines --}}
                <div style="height:72px;"></div>

                {{-- ── LEVEL 2: Secretary + Treasurer ── --}}
                <div style="display:flex;justify-content:center;gap:160px;margin-bottom:0;">
                    <div id="onode-victoria" style="display:flex;flex-direction:column;align-items:center;text-align:center;padding:12px 16px;background:rgba(255,255,255,0.07);border:1.5px solid rgba(255,255,255,0.15);border-radius:14px;min-width:140px;">
                        <div style="width:40px;height:40px;border-radius:10px;background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;margin:0 auto 8px;">
                            <span style="font-size:11px;font-weight:900;color:rgba(255,255,255,0.7);">VB</span>
                        </div>
                        <p style="font-size:11px;font-weight:800;color:#fff;margin:0 0 4px;line-height:1.3;">Victoria S. Burlaos</p>
                        <p style="font-size:8px;font-weight:900;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:0.12em;margin:0;">Secretary</p>
                    </div>
                    <div id="onode-romeo" style="display:flex;flex-direction:column;align-items:center;text-align:center;padding:12px 16px;background:rgba(255,255,255,0.07);border:1.5px solid rgba(255,255,255,0.15);border-radius:14px;min-width:140px;">
                        <div style="width:40px;height:40px;border-radius:10px;background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;margin:0 auto 8px;">
                            <span style="font-size:11px;font-weight:900;color:rgba(255,255,255,0.7);">RL</span>
                        </div>
                        <p style="font-size:11px;font-weight:800;color:#fff;margin:0 0 4px;line-height:1.3;">Romeo R. De Leon</p>
                        <p style="font-size:8px;font-weight:900;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:0.12em;margin:0;">Treasurer</p>
                    </div>
                </div>

                {{-- spacer for connector lines --}}
                <div style="height:72px;"></div>

                {{-- ── LEVEL 3: 8 Kagawads + SK Chair ── --}}
                <div style="display:flex;justify-content:center;gap:16px;">
                    @php
                    $kagawads = [
                        ['id'=>'john',      'initials'=>'JS', 'name'=>'John Carlo C. Solomon',    'role'=>"Kagawad\nAppropriations"],
                        ['id'=>'reynaldo',  'initials'=>'RD', 'name'=>'Reynaldo J. Dauz Jr.',     'role'=>"Kagawad\nPeace & Order"],
                        ['id'=>'jesus',     'initials'=>'JA', 'name'=>'Jesus C. Anunciacion',     'role'=>"Kagawad\nRules & Ethics"],
                        ['id'=>'claudine',  'initials'=>'CD', 'name'=>'Claudine A. Dizon',        'role'=>"Kagawad\nLivelihood"],
                        ['id'=>'ian',       'initials'=>'IP', 'name'=>'Ian M. Perez',             'role'=>"Kagawad\nHealth & Well-Being"],
                        ['id'=>'teresita',  'initials'=>'TQ', 'name'=>'Ma. Teresita G. Quintana', 'role'=>"Kagawad\nEnvironmental Mgmt."],
                        ['id'=>'enerson',   'initials'=>'EM', 'name'=>'Enerson R. Molina',        'role'=>"Kagawad\nEntrepreneurship"],
                        ['id'=>'alaine',    'initials'=>'AA', 'name'=>'Alaine Joy T. Ambito',     'role'=>"SK Chairperson\nSangguniang Kabataan"],
                    ];
                    @endphp
                    @foreach($kagawads as $k)
                    <div id="onode-{{ $k['id'] }}" style="display:flex;flex-direction:column;align-items:center;text-align:center;padding:12px 10px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:12px;width:116px;flex-shrink:0;">
                        <div style="width:34px;height:34px;border-radius:8px;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.12);display:flex;align-items:center;justify-content:center;margin:0 auto 7px;">
                            <span style="font-size:10px;font-weight:900;color:rgba(255,255,255,0.65);">{{ $k['initials'] }}</span>
                        </div>
                        <p style="font-size:9.5px;font-weight:800;color:#fff;margin:0 0 4px;line-height:1.3;">{{ $k['name'] }}</p>
                        <p style="font-size:7.5px;font-weight:900;color:rgba(255,255,255,0.38);text-transform:uppercase;letter-spacing:0.1em;margin:0;line-height:1.4;white-space:pre-line;">{{ $k['role'] }}</p>
                    </div>
                    @endforeach
                </div>

                {{-- spacer for connector lines --}}
                <div style="height:72px;"></div>

                {{-- ── LEVEL 4: Executive Officer (BSG) ── --}}
                <div style="display:flex;justify-content:center;">
                    <div id="onode-rustico" style="display:flex;flex-direction:column;align-items:center;text-align:center;padding:12px 20px;background:rgba(255,255,255,0.07);border:1.5px solid rgba(255,255,255,0.15);border-radius:14px;min-width:160px;">
                        <div style="width:40px;height:40px;border-radius:10px;background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;margin:0 auto 8px;">
                            <span style="font-size:11px;font-weight:900;color:rgba(255,255,255,0.7);">RC</span>
                        </div>
                        <p style="font-size:11px;font-weight:800;color:#fff;margin:0 0 4px;line-height:1.3;">Rustico B. Cuevas Jr.</p>
                        <p style="font-size:8px;font-weight:900;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:0.12em;margin:0;line-height:1.5;">Executive Officer<br>Barangay Security Group</p>
                    </div>
                </div>

            </div>{{-- end min-width wrapper --}}
        </div>{{-- end org-chart-wrap --}}

    </div>
</section>

<script>
(function() {
    function drawOrgChart() {
        const wrap = document.getElementById('org-chart-wrap');
        const svg  = document.getElementById('org-svg');
        if (!wrap || !svg) return;
        svg.innerHTML = '';

        const wRect = wrap.getBoundingClientRect();

        function r(id) {
            const el = document.getElementById(id);
            if (!el) return null;
            const b = el.getBoundingClientRect();
            return {
                top:    b.top    - wRect.top  + wrap.scrollTop,
                bottom: b.bottom - wRect.top  + wrap.scrollTop,
                left:   b.left   - wRect.left + wrap.scrollLeft,
                right:  b.right  - wRect.left + wrap.scrollLeft,
                cx:     b.left   - wRect.left + wrap.scrollLeft + b.width  / 2,
                cy:     b.top    - wRect.top  + wrap.scrollTop  + b.height / 2,
            };
        }

        function seg(x1, y1, x2, y2) {
            const l = document.createElementNS('http://www.w3.org/2000/svg', 'line');
            l.setAttribute('x1', x1); l.setAttribute('y1', y1);
            l.setAttribute('x2', x2); l.setAttribute('y2', y2);
            l.setAttribute('stroke', 'rgba(255,255,255,0.28)');
            l.setAttribute('stroke-width', '2');
            l.setAttribute('stroke-linecap', 'round');
            svg.appendChild(l);
        }

        const erwin    = r('onode-erwin');
        const victoria = r('onode-victoria');
        const romeo    = r('onode-romeo');
        const john     = r('onode-john');
        const alaine   = r('onode-alaine');
        const rustico  = r('onode-rustico');
        if (!erwin || !victoria || !romeo || !john || !alaine || !rustico) return;

        const kagawadIds = ['john','reynaldo','jesus','claudine','ian','teresita','enerson','alaine'];

        // ── Erwin → Level 2 mid-junction ──
        const jY1 = (erwin.bottom + victoria.top) / 2;
        seg(erwin.cx, erwin.bottom, erwin.cx, jY1);          // vertical down from Erwin
        seg(victoria.cx, jY1, romeo.cx, jY1);                // horizontal bar spanning Victoria↔Romeo
        seg(victoria.cx, jY1, victoria.cx, victoria.top);    // down to Victoria
        seg(romeo.cx,    jY1, romeo.cx,    romeo.top);       // down to Romeo

        // ── Level 2 → Level 3 mid-junction ──
        const jY2 = (victoria.bottom + john.top) / 2;
        seg(erwin.cx, jY1, erwin.cx, jY2);                   // vertical continues from Erwin through L2

        // horizontal bar spanning all kagawads
        const kLeft  = r('onode-' + kagawadIds[0]).cx;
        const kRight = r('onode-' + kagawadIds[kagawadIds.length - 1]).cx;
        seg(kLeft, jY2, kRight, jY2);

        // stalks up to each kagawad
        for (const kid of kagawadIds) {
            const kn = r('onode-' + kid);
            if (kn) { seg(kn.cx, jY2, kn.cx, kn.top); }
        }

        // center vertical from L2 junction down to L3 h-bar
        seg(erwin.cx, jY2, erwin.cx, jY2);                   // dot (already covered by h-bar)

        // ── Level 3 → Rustico ──
        const jY3 = (john.bottom + rustico.top) / 2;
        seg(erwin.cx, jY2, erwin.cx, jY3);                   // vertical down from center
        seg(erwin.cx, jY3, rustico.cx, jY3);                 // horizontal to Rustico center
        seg(rustico.cx, jY3, rustico.cx, rustico.top);       // down into Rustico
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', drawOrgChart);
    } else {
        drawOrgChart();
    }
    window.addEventListener('resize', drawOrgChart);
})();
</script>

{{-- ═══════════════════════════════════════════
     ANNOUNCEMENTS
═══════════════════════════════════════════ --}}
<section id="announcements" class="py-16 md:py-28 max-w-7xl mx-auto px-4 sm:px-6">

    {{-- Section Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 text-center md:text-left">
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

    <div class="flex flex-col gap-4">
        @foreach($annCollection as $announcement)
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
                 class="group bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl hover:border-brgyGreen/20 transition-all duration-300 cursor-pointer flex flex-col md:flex-row">

            {{-- Image: fixed height on mobile, fixed width+height on desktop --}}
            <div class="w-full h-48 md:w-56 md:h-auto md:min-h-[140px] flex-shrink-0 overflow-hidden relative">
                @if($announcement->image_url)
                    <img src="{{ $annImg }}" alt="{{ $announcement->title }}"
                         class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="absolute inset-0 flex items-center justify-center" style="background: linear-gradient(135deg,#eff6ff,#dbeafe);">
                        <svg class="w-12 h-12 text-brgyGreen/15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    </div>
                @endif
            </div>

            {{-- Content --}}
            <div class="flex-1 p-5 md:p-6 flex flex-col justify-between min-w-0">
                <div>
                    <div class="flex items-center flex-wrap gap-2 mb-3">
                        @if($announcement->is_pinned)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-brgyGreen text-white text-[9px] font-black uppercase tracking-widest rounded-lg">
                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 24 24"><path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5.2v6h1.6v-6H18v-2l-2-2z"/></svg>
                            Pinned
                        </span>
                        @endif
                        <span class="px-2.5 py-1 {{ $annStyle['pill'] }} rounded-lg text-[9px] font-black uppercase tracking-widest">{{ $annCategory }}</span>
                        <span class="ml-auto text-[9px] font-black text-slate-300 uppercase tracking-widest">{{ $annDate }}</span>
                    </div>
                    <h3 class="font-extrabold text-slate-800 text-base leading-snug group-hover:text-brgyGreen transition-colors line-clamp-1">{{ $announcement->title }}</h3>
                    <p class="text-slate-400 text-xs mt-1 leading-relaxed line-clamp-2">{{ $announcement->content }}</p>
                </div>
                <div class="mt-3 pt-3 border-t border-slate-50 flex items-center gap-2 text-brgyGreen text-xs font-black uppercase tracking-widest">
                    Read Full Announcement
                    <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </div>
            </div>
        </article>
        @endforeach
    </div>

    @endif

</section>

{{-- ═══════════════════════════════════════════
     ACTIVITIES
═══════════════════════════════════════════ --}}
<section id="schedule" class="py-16 md:py-28 max-w-7xl mx-auto px-4 sm:px-6 mb-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16 text-center md:text-left">
        <div>
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-brgyGreen/8 text-brgyGreen rounded-full text-[10px] font-black tracking-[0.25em] uppercase mb-5">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Calendar
            </span>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Upcoming Events</h2>
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
