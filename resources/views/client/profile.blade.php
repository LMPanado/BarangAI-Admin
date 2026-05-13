@extends('layouts.client')

@section('content')
<div class="min-h-screen bg-[#f8fafc]">
    {{-- Decorative Header --}}
    <div class="hero-gradient pt-32 pb-32 px-6 rounded-b-[3rem]">
        <div class="max-w-5xl mx-auto text-center">
            <span class="text-white/60 font-black tracking-[0.4em] uppercase text-[10px] block mb-4">Account Overview</span>
            <h1 class="text-4xl font-extrabold text-white tracking-tight">Resident <span class="text-brgyGold">Profile</span></h1>
        </div>
    </div>

    {{-- Profile Content --}}
    <main class="-mt-24 pb-20 px-6">
        <div class="max-w-5xl mx-auto">
            {{-- Profile Identity Card --}}
            <div class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden mb-8">
                <div class="p-8 md:p-12">
                    <div class="flex flex-col md:flex-row items-center gap-8 text-center md:text-left">
                        <div class="relative group">
                            <div class="absolute -inset-1 bg-gradient-to-tr from-brgyGreen to-brgyGold rounded-full blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                            <div class="relative w-32 h-32 bg-slate-50 rounded-full flex items-center justify-center border-4 border-white shadow-xl overflow-hidden">
                                <svg class="w-16 h-16 text-slate-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="flex-1">
                            <div class="flex flex-wrap justify-center md:justify-start gap-3 mb-4">
                                </span>
                                <span class="px-4 py-1 bg-brgyGold/10 text-brgyGreen rounded-full text-[10px] font-black uppercase tracking-widest border border-brgyGold/20 flex items-center gap-2">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Verified Resident
                                </span>
                            </div>
                            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">
                                {{ Auth::user()->resident->first_name }} {{ Auth::user()->resident->last_name }}
                            </h2>
                            <p class="text-slate-400 font-bold uppercase tracking-widest text-xs flex items-center justify-center md:justify-start gap-2">
                                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                {{ Auth::user()->email }}
                            </p>
                        </div>

                        <div class="flex flex-col gap-2 w-full md:w-auto">
                            <button class="bg-brgyGreen text-white px-8 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-darkGreen transition shadow-lg shadow-brgyGreen/20 flex items-center justify-center gap-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit Profile
                            </button>
                        </div>
                    </div>
                </div>
                
                {{-- Quick Stats Bar --}}
                <div class="bg-slate-50 border-t border-slate-100 grid grid-cols-2 md:grid-cols-4 divide-x divide-slate-100">
                    <div class="p-6 text-center">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Civil Status</p>
                        <p class="text-sm font-bold text-slate-700">Single</p>
                    </div>
                    <div class="p-6 text-center">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Voter Status</p>
                        <p class="text-sm font-bold text-brgyGreen">Registered</p>
                    </div>
                    <div class="p-6 text-center">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Zone</p>
                        <p class="text-sm font-bold text-slate-700">Zone 43</p>
                    </div>
                    <div class="p-6 text-center">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Requests</p>
                        <p class="text-sm font-bold text-slate-700">Active</p>
                    </div>
                </div>
            </div>

            {{-- Information Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Personal Info --}}
                <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-500">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-brgyGreen/5 rounded-xl flex items-center justify-center text-brgyGreen">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h3 class="text-xs font-black text-brgyGreen uppercase tracking-[0.2em]">Personal Information</h3>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="group">
                            <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest mb-1 group-hover:text-brgyGreen transition-colors">Full Legal Name</p>
                            <p class="font-bold text-slate-700">{{ Auth::user()->resident->first_name }} {{ Auth::user()->resident->middle_name }} {{ Auth::user()->resident->last_name }}</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest mb-1">Gender</p>
                                <p class="font-bold text-slate-700">{{ Auth::user()->resident->gender }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest mb-1">Age</p>
                                <p class="font-bold text-slate-700">{{ Auth::user()->resident->age }} Years Old</p>
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest mb-1">Birthday</p>
                            <p class="font-bold text-slate-700">{{ Auth::user()->resident->birthdate ?? 'Not Specified' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Contact & Address --}}
                <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-500">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-brgyGold/10 rounded-xl flex items-center justify-center text-brgyGreen">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="text-xs font-black text-brgyGreen uppercase tracking-[0.2em]">Contact & Address</h3>
                    </div>
                    
                    <div class="space-y-6">
                        <div>
                            <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest mb-1">Phone Number</p>
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <p class="font-bold text-slate-700">{{ Auth::user()->resident->phone ?? 'No record' }}</p>
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest mb-1">Permanent Residence</p>
                            <p class="font-bold text-slate-700 leading-relaxed">{{ Auth::user()->resident->address }}</p>
                        </div>

                        <div class="pt-4 border-t border-slate-50">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Account Security Card --}}
            <div class="mt-8 bg-darkGreen p-8 md:p-12 rounded-[3rem] shadow-2xl shadow-darkGreen/20 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center text-white">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-white font-extrabold uppercase tracking-widest text-sm mb-1">Security & Privacy</h4>
                        <p class="text-white/40 text-xs font-medium uppercase tracking-wider">Keep your account secure by updating your password regularly.</p>
                    </div>
                </div>
                <button class="w-full md:w-auto bg-white/10 hover:bg-white/20 text-white px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest transition border border-white/5 flex items-center justify-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                    Update Password
                </button>
            </div>
        </div>
    </main>
</div>
@endsection