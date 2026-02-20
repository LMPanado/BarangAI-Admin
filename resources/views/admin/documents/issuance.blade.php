@extends('layouts.admin')

@section('content')
<div class="p-6 bg-[#f4f7fe] min-h-screen font-sans">
    {{-- Header Section --}}
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-bold text-[#002b5c]">Generate Document</h1>
            {{-- Fixed: Changed $resident to $request->resident --}}
            <p class="text-sm text-gray-500">Issuing document for: <span class="font-bold text-gray-700">{{ $request->resident->last_name }}, {{ $request->resident->first_name }}</span></p>
        </div>
        <div class="text-xs text-gray-400 text-right">
            Home / Documents / <span class="text-blue-500">Generate</span><br>
            <a href="{{ route('admin.documents.index') }}" class="text-blue-400 hover:underline">← Back to List</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        
        {{-- Left Side: Control Panel --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 no-print">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Select Template</h3>
                <div class="space-y-2">
                    {{-- Fixed: Template buttons with dynamic switching --}}
                    <button onclick="updateTemplate('Barangay Certificate')" class="w-full text-left px-4 py-3 rounded-md border border-gray-50 bg-gray-50 hover:bg-brgyGreen hover:text-white text-sm font-semibold transition-all">Barangay Certificate</button>
                    <button onclick="updateTemplate('Indigency')" class="w-full text-left px-4 py-3 rounded-md border border-gray-50 bg-gray-50 hover:bg-brgyGreen hover:text-white text-sm font-semibold transition-all">Indigency</button>
                    <button onclick="updateTemplate('Business Permit')" class="w-full text-left px-4 py-3 rounded-md border border-gray-50 bg-gray-50 hover:bg-brgyGreen hover:text-white text-sm font-semibold transition-all">Business Permit</button>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100">
                    <button onclick="window.print()" class="w-full bg-[#1e293b] text-white font-bold py-3 rounded-md shadow-sm hover:bg-slate-700 flex justify-center items-center transition-all">
                        <span class="mr-2">🖨️</span> Print Document
                    </button>
                    <p class="text-[10px] text-gray-400 mt-3 text-center italic">Ensure printer is set to A4 or Letter.</p>
                </div>
            </div>

            {{-- Resident Mini Profile --}}
            <div class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm no-print">
                <h3 class="text-[10px] font-bold text-gray-400 uppercase mb-2">Resident Details</h3>
                <div class="text-xs space-y-1">
                    {{-- Fixed: Accessing fields through $request->resident --}}
                    <p><span class="text-gray-400">ID:</span> #{{ str_pad($request->resident->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <p><span class="text-gray-400">Gender:</span> {{ $request->resident->gender }}</p>
                    <p><span class="text-gray-400">Age:</span> {{ $request->resident->age }}</p>
                </div>
            </div>
        </div>

        {{-- Right Side: The Paper Preview --}}
        <div class="lg:col-span-3 bg-white shadow-xl border border-gray-200 min-h-[1056px] relative rounded-sm p-[1in] overflow-hidden" id="printable-area">
            
            <div id="active-template">
                {{-- Official Header --}}
                <div class="text-center mb-12 border-b-2 border-double border-gray-800 pb-6 flex justify-center items-center gap-8">
                    <div class="w-20 h-20 bg-gray-100 rounded-full border border-gray-300 flex items-center justify-center text-[10px] text-gray-400">LOGO 1</div>
                    <div>
                        <h1 class="text-lg font-serif font-bold uppercase leading-tight text-gray-800">Republic of the Philippines</h1>
                        <h2 class="text-md font-serif italic uppercase text-gray-700">National Capital Region</h2>
                        <h2 class="text-xl font-serif font-black text-blue-900 uppercase">Barangay 419, Zone 43, Manila</h2>
                    </div>
                    <div class="w-20 h-20 bg-gray-100 rounded-full border border-gray-300 flex items-center justify-center text-[10px] text-gray-400">LOGO 2</div>
                </div>

                <div class="font-serif text-gray-900 space-y-8 text-justify leading-relaxed">
                    <h2 id="doc-title" class="text-3xl font-black text-center underline uppercase mb-12 tracking-widest">BARANGAY CERTIFICATE</h2>
                    
                    <p class="text-xl">TO WHOM IT MAY CONCERN:</p>
                    
                    <p class="indent-12 text-lg">
                        This is to certify that <strong>{{ strtoupper($request->resident->first_name) }} {{ strtoupper($request->resident->last_name) }}</strong>, 
                        of legal age, Filipino citizen, and a resident of <strong>{{ $request->resident->address }}</strong>, Barangay 419, is known to be of good moral character.
                    </p>

                    <p id="body-text" class="indent-12 text-lg">
                        According to the records of this office, the above-named person has no derogatory records and is a law-abiding citizen of this community.
                    </p>

                    <p class="indent-12 text-lg">
                        This certification is issued upon the request of the above-named person for 
                        <span id="purpose-text" class="border-b border-gray-800 px-2 font-bold cursor-pointer hover:bg-yellow-50 uppercase" contenteditable="true">
                            {{ $request->purpose }}
                        </span> purposes only.
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
        const title = document.getElementById('doc-title');
        const body = document.getElementById('body-text');
        
        title.innerText = type.toUpperCase();
        
        if (type === 'Indigency') {
            body.innerText = "This further certifies that the family of the above-named person belongs to the indigent group of this barangay and has no sufficient income to support their daily needs.";
        } else if (type === 'Business Permit') {
            body.innerText = "This further certifies that the above-mentioned resident is authorized to operate their business within the jurisdiction of this Barangay, provided all city ordinances are followed.";
        } else {
            body.innerText = "According to the records of this office, the above-named person has no derogatory records and is a law-abiding citizen of this community.";
        }
    }
</script>

<style>
    @media print {
        .no-print { display: none !important; }
        body { background-color: white !important; }
        #printable-area { 
            position: absolute; 
            left: 0; top: 0; width: 100%; 
            border: none !important; 
            box-shadow: none !important;
            padding: 0 !important;
        }
    }
    
    #printable-area {
        width: 8.5in;
        margin: auto;
    }
</style>
@endsection