@extends('layouts.client') {{-- Adjust this to match your actual layout filename --}}

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-20 md:py-20">
    <div class="bg-white rounded-[2rem] md:rounded-[3rem] shadow-xl shadow-slate-200/50 overflow-hidden border border-slate-100">
        <div class="hero-gradient p-6 sm:p-10 md:p-12 text-white">
            <h1 class="text-4xl font-extrabold tracking-tight mb-4">About Barangay 419</h1>
            <p class="text-white/80 max-w-2xl text-lg font-medium leading-relaxed">
                Serving the heart of Zone 43, District IV, Manila. We are committed to transparency, 
                safety, and digital-first public service for all our residents.
            </p>
        </div>

        <div class="p-6 sm:p-10 md:p-12 grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
            {{-- Contact Info --}}
            <div class="space-y-8">
                <div>
                    <h3 class="text-xs font-black uppercase tracking-[0.2em] text-brgyGreen mb-6">Barangay Hall Directory</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-slate-50">
                            <span class="text-slate-400 font-bold text-xs uppercase">Official Address</span>
                            <span class="text-slate-700 font-extrabold text-right">123 Street Name, Zone 43, Manila</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-slate-50">
                            <span class="text-slate-400 font-bold text-xs uppercase">Telephone</span>
                            <span class="text-slate-700 font-extrabold">(02) 8XXX-XXXX</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-slate-50 text-brgyGreen">
                            <span class="font-black text-xs uppercase">Tanod Hotline</span>
                            <span class="font-black">09XX-XXX-XXXX</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Office Hours --}}
            <div class="bg-slate-50 rounded-[2rem] p-8">
                <h3 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-6 text-center">Standard Office Hours</h3>
                <div class="space-y-4">
                    <div class="flex justify-between px-4">
                        <span class="font-bold text-slate-500 uppercase text-[10px]">Mon - Fri</span>
                        <span class="font-black text-slate-800">8:00 AM - 5:00 PM</span>
                    </div>
                    <div class="flex justify-between px-4">
                        <span class="font-bold text-slate-500 uppercase text-[10px]">Saturday</span>
                        <span class="font-black text-slate-800">9:00 AM - 12:00 PM</span>
                    </div>
                    <div class="flex justify-between px-4">
                        <span class="font-bold text-slate-500 uppercase text-[10px]">Sunday</span>
                        <span class="font-black text-red-500 uppercase text-[10px]">Closed (Emergency Only)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection