@extends('layouts.admin')

@section('content')
<div class="space-y-8 animate-fade-in">
    <div class="flex justify-between items-center border-b border-gray-100 pb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Dashboard Overview</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Real-time statistics and barangay council directory.</p>
        </div>
        <nav class="flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider">
            <span class="text-gray-400">Home</span>
            <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            <span class="text-barangayGreen">Dashboard</span>
        </nav>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Residents</p>
                <div class="p-2 bg-green-50 rounded-lg text-barangayGreen">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <div class="flex items-baseline mt-4">
                <p class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $totalPopulation }}</p>
                <span class="ml-2 text-[10px] font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-full uppercase tracking-tighter">Live</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Male</p>
                <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-gray-900 mt-4 tracking-tight">{{ $maleCount }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Female</p>
                <div class="p-2 bg-pink-50 rounded-lg text-pink-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-gray-900 mt-4 tracking-tight">{{ $femaleCount }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Registered Voters</p>
                <div class="p-2 bg-amber-50 rounded-lg text-amber-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-gray-900 mt-4 tracking-tight">{{ $voterCount }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-white px-8 py-5 border-b border-gray-50 flex items-center justify-between">
                <h3 class="text-sm font-extrabold text-gray-700 uppercase tracking-wider">Case Management Summary</h3>
                <span class="p-2 bg-gray-50 text-gray-400 rounded-full hover:bg-green-50 hover:text-barangayGreen transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                </span>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                    <div class="text-center p-5 bg-gray-50/50 rounded-2xl border border-transparent hover:border-green-100 transition-all">
                        <p class="text-3xl font-extrabold text-gray-800">5</p>
                        <p class="text-[10px] font-bold text-green-600 uppercase mt-1">Settled</p>
                    </div>
                    <div class="text-center p-5 bg-gray-50/50 rounded-2xl border border-transparent">
                        <p class="text-3xl font-extrabold text-gray-800">3</p>
                        <p class="text-[10px] font-bold text-amber-600 uppercase mt-1 tracking-tighter">Unscheduled</p>
                    </div>
                    <div class="text-center p-5 bg-red-50 rounded-2xl border border-red-100">
                        <p class="text-3xl font-extrabold text-red-600">12</p>
                        <p class="text-[10px] font-bold text-red-500 uppercase mt-1">Unsettled</p>
                    </div>
                    <div class="text-center p-5 bg-gray-50/50 rounded-2xl border border-transparent">
                        <p class="text-3xl font-extrabold text-gray-800">8</p>
                        <p class="text-[10px] font-bold text-blue-600 uppercase mt-1">Scheduled</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-barangayGreen px-6 py-5">
                <h3 class="text-sm font-extrabold text-white uppercase tracking-wider">Barangay Council</h3>
            </div>
            <div class="divide-y divide-gray-50 max-h-[440px] overflow-y-auto custom-scrollbar">
                <div class="p-6 bg-green-50/50 border-l-4 border-barangayGreen">
                    <p class="text-sm font-extrabold text-gray-900 tracking-tight uppercase">Erwin R. Molina</p>
                    <p class="text-[10px] text-barangayGreen font-bold uppercase tracking-widest mt-0.5">Punong Barangay</p>
                </div>

                @php
                    $officials = [
                        ['Victoria S. Burlaos', 'Secretary'],
                        ['Romeo R. De Leon', 'Treasurer'],
                        ['John Carlo C. Solomon', 'Kagawad (Appropriations)'],
                        ['Reynaldo J. Dauz Jr.', 'Kagawad (Peace & Order)'],
                        ['Jesus C. Anunciacion', 'Kagawad (Rules & Education)'],
                        ['Claudine A. Dizon', 'Kagawad (Livelihood)'],
                        ['Ian M. Perez', 'Kagawad (Health)'],
                        ['Ma. Teresita G. Quintana', 'Kagawad (Environment)'],
                        ['Enerson R. Molina', 'Kagawad (Entrepreneurship)'],
                        ['Alaine Joy T. Ambito', 'Chairperson (SK)'],
                        ['Rustico B. Cuevas Jr.', 'Executive Officer (BSG)'],
                    ];
                @endphp

                @foreach($officials as $official)
                <div class="p-4 hover:bg-gray-50 transition-colors px-6 group">
                    <p class="text-xs font-bold text-gray-800 group-hover:text-barangayGreen transition-colors">{{ $official[0] }}</p>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter mt-0.5">{{ $official[1] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #2d5a27; }
</style>
@endsection