@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center border-b border-gray-200 pb-4">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Dashboard Overview</h1>
            <p class="text-sm text-gray-500">Real-time statistics and barangay council directory.</p>
        </div>
        <nav class="text-sm text-gray-400">
            Home / <span class="text-adminBlue font-medium">Dashboard</span>
        </nav>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 border border-gray-200 rounded shadow-sm">
            <p class="text-xs font-semibold text-gray-500 uppercase">Total Residents</p>
            <div class="flex items-end justify-between mt-2">
                <p class="text-3xl font-bold text-gray-900">{{ $totalPopulation }}</p>
                <span class="text-blue-600 bg-blue-50 px-2 py-1 rounded text-[10px] font-bold">POPL</span>
            </div>
        </div>

        <div class="bg-white p-5 border border-gray-200 rounded shadow-sm">
            <p class="text-xs font-semibold text-gray-500 uppercase">Total Male</p>
            <div class="flex items-end justify-between mt-2">
                <p class="text-3xl font-bold text-gray-900">{{ $maleCount }}</p>
                <span class="text-green-600 bg-green-50 px-2 py-1 rounded text-[10px] font-bold">MALE</span>
            </div>
        </div>

        <div class="bg-white p-5 border border-gray-200 rounded shadow-sm">
            <p class="text-xs font-semibold text-gray-500 uppercase">Total Female</p>
            <div class="flex items-end justify-between mt-2">
                <p class="text-3xl font-bold text-gray-900">{{ $femaleCount }}</p>
                <span class="text-pink-600 bg-pink-50 px-2 py-1 rounded text-[10px] font-bold">FEML</span>
            </div>
        </div>

        <div class="bg-white p-5 border border-gray-200 rounded shadow-sm">
            <p class="text-xs font-semibold text-gray-500 uppercase">Registered Voters</p>
            <div class="flex items-end justify-between mt-2">
                <p class="text-3xl font-bold text-gray-900">{{ $voterCount }}</p>
                <span class="text-amber-600 bg-amber-50 px-2 py-1 rounded text-[10px] font-bold">VOTR</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 bg-white border border-gray-200 rounded shadow-sm overflow-hidden">
            <div class="bg-gray-50 px-5 py-3 border-b border-gray-200">
                <h3 class="text-sm font-bold text-gray-700 uppercase">Case Management Summary</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="text-center p-4 border border-gray-100 rounded">
                        <p class="text-2xl font-bold text-gray-800">5</p>
                        <p class="text-[10px] font-bold text-green-600 uppercase">Settled</p>
                    </div>
                    <div class="text-center p-4 border border-gray-100 rounded">
                        <p class="text-2xl font-bold text-gray-800">3</p>
                        <p class="text-[10px] font-bold text-amber-600 uppercase">Unscheduled</p>
                    </div>
                    <div class="text-center p-4 border border-red-100 bg-red-50 rounded">
                        <p class="text-2xl font-bold text-red-600">12</p>
                        <p class="text-[10px] font-bold text-red-500 uppercase">Unsettled</p>
                    </div>
                    <div class="text-center p-4 border border-gray-100 rounded">
                        <p class="text-2xl font-bold text-gray-800">8</p>
                        <p class="text-[10px] font-bold text-blue-600 uppercase">Scheduled</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded shadow-sm overflow-hidden">
            <div class="bg-gray-50 px-5 py-3 border-b border-gray-200">
                <h3 class="text-sm font-bold text-gray-700 uppercase">Barangay Council</h3>
            </div>
            <div class="divide-y divide-gray-100 max-h-[400px] overflow-y-auto">
                <div class="p-4 bg-blue-50/30">
                    <p class="text-sm font-bold text-gray-900 uppercase">Erwin R. Molina</p>
                    <p class="text-[10px] text-blue-600 font-bold uppercase">Punong Barangay</p>
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
                <div class="p-3 hover:bg-gray-50 px-5">
                    <p class="text-xs font-semibold text-gray-800">{{ $official[0] }}</p>
                    <p class="text-[10px] text-gray-400 font-medium uppercase">{{ $official[1] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection