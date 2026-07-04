@extends('layouts.client')

@section('content')
<section class="hero-gradient pt-28 md:pt-40 pb-12 md:pb-20 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto">
        <nav class="flex mb-8 text-[10px] font-bold uppercase tracking-widest text-white/50">
            <a href="/" class="hover:text-white transition">Home</a>
            <span class="mx-3">/</span>
            <span class="text-brgyGold uppercase tracking-widest">Services</span>
            <span class="mx-3">/</span>
            <span class="text-white uppercase tracking-widest opacity-80">{{ $service['title'] }}</span>
        </nav>
        <h1 class="text-4xl md:text-6xl font-black text-white mb-6 uppercase tracking-tight">{{ $service['title'] }}</h1>
        <p class="text-white/70 text-lg max-w-3xl font-medium leading-relaxed">
            {{ $service['description'] }}
        </p>
    </div>
</section>

<section class="py-12 md:py-20 px-4 sm:px-6 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-3 gap-16">
            
            {{-- Left Column: Requirements & Uses --}}
            <div class="lg:col-span-1 space-y-12">
                <div>
                    <h3 class="text-xs font-black text-brgyGreen uppercase tracking-[0.3em] mb-6">Common Uses</h3>
                    <ul class="space-y-4">
                        @foreach($service['uses'] as $use)
                        <li class="flex items-start gap-3 text-slate-600 text-sm font-medium">
                            <svg class="w-5 h-5 text-brgyGold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            {{ $use }}
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="bg-slate-50 p-8 rounded-[2rem] border border-slate-100">
                    <h3 class="text-xs font-black text-brgyGreen uppercase tracking-[0.3em] mb-6">Requirements</h3>
                    <ul class="space-y-4 text-sm font-bold text-slate-700">
                        @foreach($service['requirements'] as $req)
                        <li class="flex items-center gap-3">
                            <div class="w-1.5 h-1.5 bg-brgyGold rounded-full"></div>
                            {{ $req }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Right Column: Application Process --}}
            <div class="lg:col-span-2">
                <div>
                    <h4 class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em] mb-8">Follow these steps to apply</h4>
                    <div class="space-y-8">
                        @foreach($service['steps_new'] as $index => $step)
                        <div class="flex gap-6 group">
                            <div class="flex-none w-12 h-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center font-black text-sm group-hover:bg-brgyGreen transition-colors duration-300">
                                {{ sprintf('%02d', $index + 1) }}
                            </div>
                            <div class="pt-3">
                                <p class="text-slate-600 leading-relaxed font-medium">{{ $step }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- QR Code CTA --}}
                    <div class="mt-16 p-8 bg-brgyGreen/5 rounded-[2.5rem] border border-brgyGreen/10 flex flex-col md:flex-row items-center justify-center gap-8">
                        <img src="{{ asset('images/qr-code.png') }}" alt="QR Code" class="w-28 h-28 object-contain bg-white rounded-xl p-2 shadow">
                        <div class="text-center md:text-left">
                            <p class="text-brgyGreen font-black text-sm uppercase tracking-widest">Download the App</p>
                            <p class="text-slate-500 text-xs font-medium mt-1">Scan the QR Code to Download the Barangay 419 Mobile App</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection