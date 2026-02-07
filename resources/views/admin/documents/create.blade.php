@extends('layouts.admin')

@section('content')
<div class="p-6 bg-[#f4f7fe] min-h-screen font-sans">
    {{-- Header Section --}}
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-bold text-[#002b5c]">Generate Document</h1>
            <p class="text-sm text-gray-500">Issuing document for: <span class="font-bold text-gray-700">{{ $resident->last_name }}, {{ $resident->first_name }}</span></p>
        </div>
        <div class="text-xs text-gray-400 text-right">
            Home / Documents / <span class="text-blue-500">Generate</span><br>
            <a href="{{ route('admin.documents.index') }}" class="text-blue-400 hover:underline">← Back to List</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        
        {{-- Left Side: Control Panel --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Select Template</h3>
                <div class="space-y-2">
                    @foreach(['Barangay Certificate', 'Indigency', 'Business Permit'] as $doc)
                        <button onclick="updateTemplate('{{ $doc }}')" 
                                class="w-full text-left px-4 py-3 rounded-md border border-gray-50 bg-gray-50 hover:bg-blue-600 hover:text-white text-sm font-semibold transition-all group">
                            {{ $doc }}
                        </button>
                    @endforeach
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100">
                    <button onclick="window.print()" class="w-full bg-[#1e293b] text-white font-bold py-3 rounded-md shadow-sm hover:bg-slate-700 flex justify-center items-center transition-all">
                        <span class="mr-2">🖨️</span> Print Document
                    </button>
                    <p class="text-[10px] text-gray-400 mt-3 text-center italic">Ensure your printer is connected and paper size is set to A4 or Letter.</p>
                </div>
            </div>

            {{-- Resident Mini Profile --}}
            <div class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
                <h3 class="text-[10px] font-bold text-gray-400 uppercase mb-2">Resident Details</h3>
                <div class="text-xs space-y-1">
                    <p><span class="text-gray-400">ID:</span> #{{ str_pad($resident->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <p><span class="text-gray-400">Gender:</span> {{ $resident->gender }}</p>
                    <p><span class="text-gray-400">Age:</span> {{ $resident->age }}</p>
                </div>
            </div>
        </div>

        {{-- Right Side: The Paper Preview --}}
        <div class="lg:col-span-3 bg-white shadow-xl border border-gray-200 min-h-[1056px] relative rounded-sm p-[1in] overflow-hidden" id="printable-area">
            
            {{-- This div is what you will replace with the real template later --}}
            <div id="active-template">
                {{-- Official Header --}}
                <div class="text-center mb-12 border-b-2 border-double border-gray-800 pb-6 flex justify-center items-center gap-8">
                    <div class="w-20 h-20 bg-gray-100 rounded-full border border-gray-300 flex items-center justify-center text-[10px] text-gray-400">LOGO 1</div>
                    <div>
                        <h1 class="text-lg font-serif font-bold uppercase leading-tight">Republic of the Philippines</h1>
                        <h2 class="text-md font-serif italic uppercase">National Capital Region</h2>
                        <h2 class="text-xl font-serif font-black text-blue-900 uppercase">Barangay 419, Zone 43, District 4, City of Manila</h2>
                    </div>
                    <div class="w-20 h-20 bg-gray-100 rounded-full border border-gray-300 flex items-center justify-center text-[10px] text-gray-400">LOGO 2</div>
                </div>

                <div class="font-serif text-gray-900 space-y-8 text-justify leading-relaxed">
                    <h2 id="doc-title" class="text-3xl font-black text-center underline uppercase mb-12 tracking-widest">BARANGAY CERTIFICATE</h2>
                    
                    <p class="text-xl">TO WHOM IT MAY CONCERN:</p>
                    
                    <p class="indent-12 text-lg">
                        This is to certify that <strong>{{ strtoupper($resident->first_name) }} {{ strtoupper($resident->last_name) }}</strong>, 
                        of legal age, Filipino citizen, and a resident of <strong>{{ $resident->address }}</strong>, Barangay 419, is known to be of good moral character.
                    </p>

                    <p class="indent-12 text-lg">
                        According to the records of this office, the above-named person has no derogatory records and is a law-abiding citizen of this community.
                    </p>

                    <p class="indent-12 text-lg">
                        This certification is issued upon the request of the above-named person for 
                        <span class="border-b border-gray-800 px-2 font-bold cursor-pointer hover:bg-yellow-50" contenteditable="true">LOCAL EMPLOYMENT</span> purposes only.
                    </p>

                    <p class="text-lg pt-4">
                        Issued this <span class="font-bold underline">{{ date('jS') }}</span> day of <span class="font-bold underline">{{ date('F, Y') }}</span>.
                    </p>

                    <div class="pt-32 flex justify-end">
                        <div class="text-center">
                            <div class="w-64 border-b-2 border-gray-900 font-bold uppercase text-xl">{{ Auth::user()->name }}</div>
                            <div class="text-md italic uppercase font-bold">Punong Barangay</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function updateTemplate(type) {
        document.getElementById('doc-title').innerText = type.toUpperCase();
        // Here is where you will add logic to change the text content based on the type
    }
</script>

<style>
    @media print {
        /* Hide everything except the printable area */
        body * { visibility: hidden; }
        #printable-area, #printable-area * { visibility: visible; }
        
        /* Reset positioning for the printer */
        #printable-area { 
            position: absolute; 
            left: 0; 
            top: 0; 
            width: 100%; 
            border: none !important; 
            box-shadow: none !important;
            padding: 0.5in !important;
        }
        
        /* Remove background colors/shadows for clean print */
        .bg-white { background-color: white !important; }
    }
    
    /* Simulate a real paper sheet on screen */
    #printable-area {
        width: 8.5in; /* Standard Letter width */
        margin-left: auto;
        margin-right: auto;
    }
</style>
@endsection