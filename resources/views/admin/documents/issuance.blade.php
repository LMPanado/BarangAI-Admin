@extends('layouts.admin')

@section('content')
@php
    // Resolve name and details — prefer linked resident, fall back to request fields
    $resident   = $request->resident;
    $fullName   = $resident
        ? strtoupper(trim(($resident->first_name ?? '') . ' ' . ($resident->middle_name ? $resident->middle_name . ' ' : '') . ($resident->last_name ?? '') . ($resident->suffix ? ' ' . $resident->suffix : '')))
        : strtoupper($request->full_name ?? 'UNKNOWN');
    $address    = $resident ? ($resident->address ?? $request->address) : ($request->address ?? '');
    $age        = $resident ? ($resident->age ?? null) : null;
    $gender     = $resident ? ($resident->gender ?? null) : null;
    $civilStatus= $resident ? ($resident->civil_status ?? null) : null;
    $birthDate  = $resident && $resident->birth_date ? \Carbon\Carbon::parse($resident->birth_date)->format('F d, Y') : null;
    $docType    = $request->document_type ?? 'Barangay Certificate';
    $purpose    = $request->purpose ?? '';
    $refNo      = $request->reference_no ?? ('REF-' . str_pad($request->id, 6, '0', STR_PAD_LEFT));
    $issuedDate = now()->format('jS') . ' day of ' . now()->format('F, Y');

    // Document type definitions
    $templates = [
        'Barangay Clearance' => [
            'title'  => 'BARANGAY CLEARANCE',
            'body'   => "This is to certify that <strong>{$fullName}</strong>, of legal age, " . ($gender ? strtolower($gender) . ", " : "") . "Filipino citizen, and a bona fide resident of <strong>{$address}</strong>, Barangay 419, Zone 43, Manila, is personally known to this office and is a person of good moral character and has no derogatory record filed against him/her in this Barangay.",
            'footer' => "This clearance is being issued upon the request of the above-named person for",
        ],
        'Certificate of Residency' => [
            'title'  => 'CERTIFICATE OF RESIDENCY',
            'body'   => "This is to certify that <strong>{$fullName}</strong>, of legal age, " . ($gender ? strtolower($gender) . ", " : "") . "Filipino citizen, is a bona fide resident of <strong>{$address}</strong>, Barangay 419, Zone 43, Manila, as verified from the official records of this office.",
            'footer' => "This certification is issued upon the request of the above-named person for",
        ],
        'Certificate of Indigency' => [
            'title'  => 'CERTIFICATE OF INDIGENCY',
            'body'   => "This is to certify that <strong>{$fullName}</strong>, of legal age, " . ($gender ? strtolower($gender) . ", " : "") . "Filipino citizen, and a resident of <strong>{$address}</strong>, Barangay 419, Zone 43, Manila, belongs to the indigent sector of this barangay and does not have sufficient income to support their daily needs.",
            'footer' => "This certification is issued upon the request of the above-named person for",
        ],
        'Business Permit' => [
            'title'  => 'BARANGAY BUSINESS PERMIT CLEARANCE',
            'body'   => "This is to certify that <strong>{$fullName}</strong>, a resident of <strong>{$address}</strong>, Barangay 419, Zone 43, Manila, has been granted clearance to operate a business within the jurisdiction of this Barangay, subject to compliance with all existing city ordinances and barangay regulations.",
            'footer' => "This permit is issued upon the request of the above-named person for",
        ],
        'Barangay Certificate' => [
            'title'  => 'BARANGAY CERTIFICATE',
            'body'   => "This is to certify that <strong>{$fullName}</strong>, of legal age, " . ($gender ? strtolower($gender) . ", " : "") . "Filipino citizen, and a resident of <strong>{$address}</strong>, Barangay 419, Zone 43, Manila, is known to this office and is a law-abiding citizen of this community.",
            'footer' => "This certification is issued upon the request of the above-named person for",
        ],
    ];

    // Match the requested document type, fall back to generic certificate
    $tpl = $templates[$docType] ?? $templates['Barangay Certificate'];

    // All available template keys for sidebar
    $templateKeys = array_keys($templates);
@endphp

{{-- ======================== PRINT CSS ======================== --}}
<style>
@media print {
    .no-print { display: none !important; }
    #admin-sidebar, nav, header, aside { display: none !important; }
    body, html { background: white !important; margin: 0 !important; padding: 0 !important; }
    #printable-area {
        position: fixed !important;
        top: 0 !important; left: 0 !important;
        width: 100% !important;
        box-shadow: none !important;
        border: none !important;
        border-radius: 0 !important;
        padding: 0.75in 1in !important;
        margin: 0 !important;
    }
}
[contenteditable]:focus { outline: 2px dashed #2d5a27; outline-offset: 2px; background: #f0fdf4; }
</style>

<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex justify-between items-center border-b border-gray-100 pb-6 no-print">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Generate Document</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">
                Issuing <span class="text-brgyGreen font-bold">{{ $docType }}</span> for
                <span class="font-bold text-gray-700">{{ $fullName }}</span>
            </p>
        </div>
        <nav class="flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider">
            <span class="text-gray-400">Home</span>
            <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            <a href="{{ route('admin.documents.index') }}" class="text-gray-400 hover:text-brgyGreen transition-colors">Requests</a>
            <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            <span class="text-brgyGreen">Generate</span>
        </nav>
    </div>

    <div class="flex gap-8 items-start">

        {{-- ===== SIDEBAR (no-print) ===== --}}
        <div class="w-64 shrink-0 space-y-5 no-print">

            {{-- Template Switcher --}}
            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-6">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-4">Document Type</p>
                <div class="space-y-2">
                    @foreach($templateKeys as $key)
                    <button onclick="switchTemplate('{{ $key }}')"
                            id="btn-{{ Str::slug($key) }}"
                            class="w-full text-left px-4 py-3 rounded-2xl text-xs font-bold transition-all
                                   {{ $docType === $key ? 'bg-brgyGreen text-white shadow-md shadow-brgyGreen/20' : 'bg-gray-50 text-gray-600 hover:bg-gray-100' }}">
                        {{ $key }}
                    </button>
                    @endforeach
                </div>
            </div>

            {{-- Resident Info Card --}}
            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-6">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-4">Requester Info</p>
                <div class="space-y-2">
                    <div>
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest">Name</p>
                        <p class="text-xs font-bold text-gray-800">{{ $fullName }}</p>
                    </div>
                    @if($address)
                    <div>
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest mt-2">Address</p>
                        <p class="text-xs text-gray-600">{{ $address }}</p>
                    </div>
                    @endif
                    @if($age)
                    <div>
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest mt-2">Age</p>
                        <p class="text-xs text-gray-600">{{ $age }}</p>
                    </div>
                    @endif
                    @if($civilStatus)
                    <div>
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest mt-2">Civil Status</p>
                        <p class="text-xs text-gray-600">{{ $civilStatus }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest mt-2">Reference No.</p>
                        <p class="text-xs font-bold text-brgyGreen font-mono">{{ $refNo }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest mt-2">Purpose</p>
                        <p class="text-xs text-gray-600 italic">"{{ $purpose }}"</p>
                    </div>
                </div>
            </div>

            {{-- Print Button --}}
            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-6">
                <button onclick="window.print()"
                        class="w-full bg-brgyGreen text-white font-black text-[10px] uppercase tracking-widest py-3.5 rounded-2xl hover:shadow-lg hover:shadow-brgyGreen/30 transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print Document
                </button>
                <p class="text-[9px] text-gray-300 text-center mt-3 font-bold uppercase tracking-widest">A4 / Letter size</p>
            </div>
        </div>

        {{-- ===== PRINTABLE DOCUMENT ===== --}}
        <div id="printable-area"
             class="flex-1 bg-white shadow-xl border border-gray-200 min-h-[1056px] p-[0.85in] font-serif"
             style="max-width: 8.5in; min-height: 11in;">

            {{-- Official Letterhead --}}
            <div class="flex items-center justify-between border-b-4 border-double border-gray-700 pb-5 mb-8">
                {{-- Left logo placeholder --}}
                <div class="w-20 h-20 rounded-full border-2 border-gray-300 flex items-center justify-center shrink-0 overflow-hidden">
                    <img src="{{ asset('images/manila-seal.png') }}" alt="Manila Seal" class="w-full h-full object-contain"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div style="display:none" class="w-full h-full items-center justify-center text-gray-300">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/></svg>
                    </div>
                </div>

                {{-- Center text --}}
                <div class="text-center flex-1 px-4">
                    <p class="text-[11px] font-sans font-bold text-gray-600 uppercase tracking-widest">Republic of the Philippines</p>
                    <p class="text-[10px] font-sans text-gray-500 uppercase tracking-wider">National Capital Region · City of Manila</p>
                    <p class="text-xl font-black text-gray-900 uppercase tracking-wide mt-1">Barangay 419, Zone 43</p>
                    <p class="text-[10px] font-sans text-gray-400 mt-0.5">Sampaloc, Manila</p>
                    <div class="mt-2 flex items-center justify-center gap-4 text-[9px] font-sans text-gray-400 uppercase tracking-widest">
                        <span>Tel. (02) 000-0000</span>
                        <span>·</span>
                        <span>brgy419sampaloc.cloud</span>
                    </div>
                </div>

                {{-- Right logo placeholder --}}
                <div class="w-20 h-20 rounded-full border-2 border-gray-300 flex items-center justify-center shrink-0 overflow-hidden">
                    <img src="{{ asset('images/barangay-seal.png') }}" alt="Barangay Seal" class="w-full h-full object-contain"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div style="display:none" class="w-full h-full items-center justify-center text-gray-300">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/></svg>
                    </div>
                </div>
            </div>

            {{-- Reference No. line --}}
            <div class="flex justify-between items-center mb-6 font-sans text-[10px] text-gray-500">
                <span>Ref. No.: <strong class="text-gray-800">{{ $refNo }}</strong></span>
                <span>Date Issued: <strong class="text-gray-800">{{ now()->format('F d, Y') }}</strong></span>
            </div>

            {{-- Document Title --}}
            <h2 id="doc-title" class="text-2xl font-black text-center underline uppercase mb-10 tracking-widest text-gray-900">
                {{ $tpl['title'] }}
            </h2>

            {{-- Body --}}
            <div class="text-gray-800 space-y-6 leading-loose text-[15px]">

                <p class="font-bold text-lg">TO WHOM IT MAY CONCERN:</p>

                <p id="doc-body" class="indent-10 text-justify">
                    {!! $tpl['body'] !!}
                </p>

                <p class="indent-10 text-justify" id="doc-footer">
                    {{ $tpl['footer'] }}
                    <span id="doc-purpose"
                          contenteditable="true"
                          class="border-b border-gray-700 px-2 font-bold italic cursor-text">{{ $purpose ?: 'general purposes' }}</span>
                    and for whatever legal purpose it may serve.
                </p>

                <p class="indent-10 text-justify">
                    Issued this <strong>{{ $issuedDate }}</strong> at Barangay 419, Zone 43, Sampaloc, Manila, Philippines.
                </p>

                {{-- Signature Block --}}
                <div class="pt-16 flex justify-between items-end">
                    {{-- Left: Requestor box --}}
                    <div class="text-center">
                        <div class="w-48 h-16 border border-dashed border-gray-300 flex items-end justify-center pb-1 mb-1">
                            <span class="text-[9px] text-gray-300 font-sans uppercase tracking-widest">Signature over Printed Name</span>
                        </div>
                        <p class="text-[10px] font-sans text-gray-500 uppercase tracking-widest">Requestor</p>
                    </div>

                    {{-- Right: Official signature --}}
                    <div class="text-center">
                        <div class="w-56 h-16 flex items-end justify-center pb-1">
                            {{-- Signature line --}}
                        </div>
                        <div class="border-t-2 border-gray-900 pt-1 w-56">
                            <p class="font-black text-sm uppercase tracking-wide">ERWIN R. MOLINA</p>
                            <p class="text-[11px] uppercase tracking-widest text-gray-600 font-sans">Punong Barangay</p>
                        </div>
                    </div>
                </div>

                {{-- OR Number footer --}}
                <div class="mt-10 pt-4 border-t border-gray-200 flex justify-between font-sans text-[10px] text-gray-400">
                    <span>OR No.: ___________________</span>
                    <span>Amount Paid: Php ___________</span>
                    <span>CTC No.: ___________________</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const templates = @json($templates);
const currentType = @json($docType);

function switchTemplate(type) {
    if (!templates[type]) return;

    // Update doc title
    document.getElementById('doc-title').innerText = templates[type].title;

    // Update body — templates use HTML so set innerHTML
    document.getElementById('doc-body').innerHTML = templates[type].body;

    // Update footer prefix
    const footer = document.getElementById('doc-footer');
    const purpose = document.getElementById('doc-purpose');
    // rebuild footer around the editable purpose span
    footer.innerHTML = templates[type].footer + ' ';
    const span = document.createElement('span');
    span.id = 'doc-purpose';
    span.contentEditable = 'true';
    span.className = 'border-b border-gray-700 px-2 font-bold italic cursor-text';
    span.innerText = purpose ? purpose.innerText : '';
    footer.appendChild(span);
    footer.appendChild(document.createTextNode(' and for whatever legal purpose it may serve.'));

    // Update sidebar button styles
    document.querySelectorAll('[id^="btn-"]').forEach(btn => {
        btn.className = 'w-full text-left px-4 py-3 rounded-2xl text-xs font-bold transition-all bg-gray-50 text-gray-600 hover:bg-gray-100';
    });
    const activeBtn = document.getElementById('btn-' + type.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, ''));
    if (activeBtn) {
        activeBtn.className = 'w-full text-left px-4 py-3 rounded-2xl text-xs font-bold transition-all bg-brgyGreen text-white shadow-md';
    }
}

// Auto-select on load
document.addEventListener('DOMContentLoaded', () => {
    const activeBtn = document.getElementById('btn-' + currentType.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, ''));
    if (activeBtn) {
        document.querySelectorAll('[id^="btn-"]').forEach(btn => {
            btn.className = 'w-full text-left px-4 py-3 rounded-2xl text-xs font-bold transition-all bg-gray-50 text-gray-600 hover:bg-gray-100';
        });
        activeBtn.className = 'w-full text-left px-4 py-3 rounded-2xl text-xs font-bold transition-all bg-brgyGreen text-white shadow-md';
    }
});
</script>

@endsection
