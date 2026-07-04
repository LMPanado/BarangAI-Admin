@extends('layouts.admin')

@section('content')
@php
    $resident    = $request->resident;
    $firstName   = $resident->first_name  ?? '';
    $middleName  = $resident->middle_name ?? '';
    $lastName    = $resident->last_name   ?? '';
    $suffix      = $resident->suffix      ?? '';
    $fullName    = strtoupper(trim(
        $firstName . ' ' .
        ($middleName ? $middleName . ' ' : '') .
        $lastName .
        ($suffix ? ' ' . $suffix : '')
    )) ?: strtoupper($request->full_name ?? 'UNKNOWN');

    $address     = $resident->address      ?? $request->address    ?? '';
    $age         = $resident->age          ?? null;
    $gender      = $resident->gender       ?? null;
    $civilStatus = $resident->civil_status ?? null;
    $birthDate   = $resident && $resident->birth_date
                    ? $resident->birth_date->format('F d, Y') : null;
    $birthPlace  = $resident->place_birth  ?? null;
    $heightCm    = $resident->height_cm    ?? null;
    $weightKg    = $resident->weight_kg    ?? null;
    $phone       = $resident->phone        ?? null;

    $docType     = $request->document_type ?? 'Barangay Certificate';
    $purpose     = $request->purpose       ?? '';
    $refNo       = $request->reference_no  ?? ('REF-' . str_pad($request->id, 6, '0', STR_PAD_LEFT));
    $issuedDate  = now()->format('jS') . ' day of ' . now()->format('F, Y');
    $issuedYear  = now()->year;
    $validUntil  = ($issuedYear + 1) . '-' . now()->format('m-d');

    $genderLower = $gender ? strtolower($gender) : null;

    $templates = [
        'Barangay Clearance' => [
            'title'  => 'BARANGAY CLEARANCE',
            'body'   => "This is to certify that <strong>{$fullName}</strong>, of legal age"
                      . ($genderLower ? ", {$genderLower}" : '')
                      . ", Filipino citizen, and a bona fide resident of <strong>{$address}</strong>, Barangay 419, Zone 43, Sampaloc, Manila, is personally known to this office and is a person of good moral character and has no derogatory record filed against him/her in this Barangay.",
            'footer' => 'This clearance is being issued upon the request of the above-named person for',
        ],
        'Certificate of Residency' => [
            'title'  => 'CERTIFICATE OF RESIDENCY',
            'body'   => "This is to certify that <strong>{$fullName}</strong>, of legal age"
                      . ($genderLower ? ", {$genderLower}" : '')
                      . ", Filipino citizen, is a bona fide resident of <strong>{$address}</strong>, Barangay 419, Zone 43, Sampaloc, Manila, as verified from the official records of this office.",
            'footer' => 'This certification is issued upon the request of the above-named person for',
        ],
        'Certificate of Indigency' => [
            'title'  => 'CERTIFICATE OF INDIGENCY',
            'body'   => "This is to certify that <strong>{$fullName}</strong>, of legal age"
                      . ($genderLower ? ", {$genderLower}" : '')
                      . ", Filipino citizen, and a resident of <strong>{$address}</strong>, Barangay 419, Zone 43, Sampaloc, Manila, belongs to the indigent sector of this barangay and does not have sufficient income to support their daily needs.",
            'footer' => 'This certification is issued upon the request of the above-named person for',
        ],
        'Business Permit' => [
            'title'  => 'BARANGAY BUSINESS PERMIT CLEARANCE',
            'body'   => "This is to certify that <strong>{$fullName}</strong>, a resident of <strong>{$address}</strong>, Barangay 419, Zone 43, Sampaloc, Manila, has been granted clearance to operate a business within the jurisdiction of this Barangay, subject to compliance with all existing city ordinances and barangay regulations.",
            'footer' => 'This permit is issued upon the request of the above-named person for',
        ],
        'Barangay Certificate' => [
            'title'  => 'BARANGAY CERTIFICATE',
            'body'   => "This is to certify that <strong>{$fullName}</strong>, of legal age"
                      . ($genderLower ? ", {$genderLower}" : '')
                      . ", Filipino citizen, and a resident of <strong>{$address}</strong>, Barangay 419, Zone 43, Sampaloc, Manila, is known to this office and is a law-abiding citizen of this community.",
            'footer' => 'This certification is issued upon the request of the above-named person for',
        ],
        'Barangay ID' => [
            'title'  => 'BARANGAY IDENTIFICATION CARD',
            'body'   => '',
            'footer' => '',
        ],
    ];

    $tpl         = $templates[$docType] ?? $templates['Barangay Certificate'];
    $templateKeys = array_keys($templates);
    $isIdCard    = ($docType === 'Barangay ID');
@endphp

{{-- ======================== PRINT CSS ======================== --}}
<style>
/* ---------- SCREEN: hide print-only elements ---------- */
.print-only { display: none !important; }

@media print {
    /* Hide everything admin */
    .no-print,
    #admin-sidebar, nav, header, aside,
    [class*="sidebar"], [class*="topbar"] { display: none !important; }

    body, html {
        background: white !important;
        margin: 0 !important; padding: 0 !important;
    }

    /* ---- Certificate print ---- */
    #certificate-area {
        position: fixed !important;
        inset: 0 !important;
        width: 100% !important;
        height: 100% !important;
        box-shadow: none !important;
        border: none !important;
        border-radius: 0 !important;
        padding: 0.85in 1in !important;
        margin: 0 !important;
    }

    /* ---- ID Card print ---- */
    #id-card-area {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        position: fixed !important;
        inset: 0 !important;
        background: white !important;
        padding: 0.5in !important;
        gap: 0.25in !important;
    }

    .id-card-row {
        display: flex !important;
        gap: 0.25in !important;
        align-items: flex-start !important;
    }

    .id-card {
        width: 3.375in !important;
        height: 2.125in !important;
        border: 1px solid #ccc !important;
        box-shadow: none !important;
        page-break-inside: avoid !important;
    }

    .print-only { display: block !important; }
}

/* ---------- Shared ---------- */
[contenteditable]:focus { outline: 2px dashed #1d4ed8; outline-offset: 2px; background: #eff6ff; }

/* ---------- Certificate body text ---------- */
.cert-body p.indented {
    text-indent: 2.5em;
    text-align: justify;
    line-height: 2;
    margin-bottom: 1em;
    font-size: 15px;
    color: #1f2937;
}

/* ---------- ID Card ---------- */
.id-card {
    width: 3.375in;
    height: 2.125in;
    border-radius: 8px;
    overflow: hidden;
    font-family: Arial, sans-serif;
    border: 1px solid #d1d5db;
    box-shadow: 0 4px 20px rgba(0,0,0,0.12);
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
}

/* Front Card */
.id-front-header {
    background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
    color: white;
    padding: 5px 8px 4px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.id-front-header .seal-circle {
    width: 28px; height: 28px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.4);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
}
.id-front-header .seal-circle img { width: 100%; height: 100%; object-fit: contain; }
.id-front-header .hdr-text { flex: 1; text-align: center; }
.id-front-header .hdr-text p { margin: 0; line-height: 1.2; }
.id-front-header .hdr-text .brgy-name { font-size: 8px; font-weight: 900; letter-spacing: 0.05em; }
.id-front-header .hdr-text .brgy-loc  { font-size: 6px; font-weight: 600; opacity: 0.85; }
.id-card-title-bar {
    background: #fbbf24;
    text-align: center;
    padding: 2px 4px;
    font-size: 6.5px;
    font-weight: 900;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: #1e3a5f;
}
.id-front-body {
    flex: 1;
    display: flex;
    padding: 6px 8px;
    gap: 8px;
    background: white;
}
.id-photo-box {
    width: 52px;
    height: 64px;
    border: 1.5px solid #d1d5db;
    border-radius: 4px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #f9fafb;
    flex-shrink: 0;
}
.id-photo-box svg { color: #d1d5db; }
.id-photo-box span { font-size: 5px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 2px; }
.id-info { flex: 1; display: flex; flex-direction: column; justify-content: center; gap: 3px; }
.id-info .id-name { font-size: 8.5px; font-weight: 900; color: #111827; text-transform: uppercase; line-height: 1.2; }
.id-info .id-field { font-size: 6px; color: #374151; line-height: 1.4; }
.id-info .id-field span { color: #6b7280; }
.id-front-footer {
    background: #f3f4f6;
    border-top: 1px solid #e5e7eb;
    padding: 3px 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.id-front-footer p { margin: 0; font-size: 5.5px; color: #6b7280; letter-spacing: 0.05em; }
.id-front-footer .id-no { font-weight: 900; color: #1d4ed8; font-family: monospace; font-size: 6px; }

/* Back Card */
.id-back {
    display: flex;
    flex-direction: column;
}
.id-back-header {
    background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
    color: white;
    text-align: center;
    padding: 4px;
}
.id-back-header p { margin: 0; font-size: 6px; letter-spacing: 0.1em; font-weight: 700; }
.id-back-body {
    flex: 1;
    padding: 6px 10px;
    background: white;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.id-back-body .ec-section { }
.id-back-body .ec-title { font-size: 5.5px; font-weight: 900; color: #374151; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 3px; }
.id-back-body .ec-line { display: flex; align-items: center; gap: 4px; margin-bottom: 2px; }
.id-back-body .ec-label { font-size: 5.5px; color: #6b7280; width: 50px; flex-shrink: 0; }
.id-back-body .ec-value { flex: 1; border-bottom: 0.5px solid #9ca3af; font-size: 5.5px; color: #111827; padding-bottom: 1px; min-width: 0; }
.id-sig-block { display: flex; justify-content: center; }
.id-sig-block .sig-inner { text-align: center; }
.id-sig-block .sig-line { width: 80px; border-top: 1px solid #111827; padding-top: 2px; }
.id-sig-block .sig-name { font-size: 6px; font-weight: 900; color: #111827; letter-spacing: 0.05em; text-transform: uppercase; }
.id-sig-block .sig-title { font-size: 5px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; }
.id-back-footer {
    background: #1d4ed8;
    color: white;
    text-align: center;
    padding: 2px;
    font-size: 5.5px;
    letter-spacing: 0.08em;
    font-weight: 700;
}
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

        {{-- ===== SIDEBAR ===== --}}
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

            {{-- Resident Info --}}
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
                <p class="text-[9px] text-gray-300 text-center mt-3 font-bold uppercase tracking-widest" id="paper-size-hint">A4 / Letter size</p>
            </div>
        </div>

        {{-- ===== CERTIFICATE AREA ===== --}}
        <div id="certificate-area"
             class="flex-1 bg-white shadow-xl border border-gray-200 font-serif"
             style="max-width: 8.5in; min-height: 11in; padding: 0.85in 1in; {{ $isIdCard ? 'display:none' : '' }}">

            {{-- Letterhead --}}
            <div style="display:flex; align-items:center; justify-content:space-between; border-bottom: 3px double #374151; padding-bottom: 1.25rem; margin-bottom: 1.75rem;">
                {{-- Left seal --}}
                <div style="width:72px; height:72px; border-radius:50%; border:1.5px solid #d1d5db; display:flex; align-items:center; justify-content:center; overflow:hidden; flex-shrink:0;">
                    <img src="{{ asset('images/manila-seal.png') }}" alt="Manila Seal"
                         style="width:100%; height:100%; object-fit:contain;"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div style="display:none; width:100%; height:100%; align-items:center; justify-content:center;">
                        <svg style="width:2rem; height:2rem; color:#d1d5db;" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/></svg>
                    </div>
                </div>

                {{-- Center text --}}
                <div style="text-align:center; flex:1; padding:0 1rem;">
                    <p style="font-size:10px; font-family:sans-serif; font-weight:700; color:#4b5563; text-transform:uppercase; letter-spacing:0.12em; margin:0;">Republic of the Philippines</p>
                    <p style="font-size:9px; font-family:sans-serif; color:#6b7280; text-transform:uppercase; letter-spacing:0.08em; margin:2px 0 0;">National Capital Region &bull; City of Manila</p>
                    <p style="font-size:20px; font-weight:900; color:#111827; text-transform:uppercase; letter-spacing:0.05em; margin:4px 0 0;">Barangay 419, Zone 43</p>
                    <p style="font-size:9px; font-family:sans-serif; color:#9ca3af; margin:2px 0 0;">Sampaloc, Manila</p>
                    <div style="margin-top:6px; display:flex; align-items:center; justify-content:center; gap:12px; font-size:8px; font-family:sans-serif; color:#9ca3af; text-transform:uppercase; letter-spacing:0.1em;">
                        <span>Tel. (02) 000-0000</span>
                        <span>&bull;</span>
                        <span>brgy419sampaloc.cloud</span>
                    </div>
                </div>

                {{-- Right seal --}}
                <div style="width:72px; height:72px; border-radius:50%; border:1.5px solid #d1d5db; display:flex; align-items:center; justify-content:center; overflow:hidden; flex-shrink:0;">
                    <img src="{{ asset('images/barangay-seal.png') }}" alt="Barangay Seal"
                         style="width:100%; height:100%; object-fit:contain;"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div style="display:none; width:100%; height:100%; align-items:center; justify-content:center;">
                        <svg style="width:2rem; height:2rem; color:#d1d5db;" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/></svg>
                    </div>
                </div>
            </div>

            {{-- Ref / Date row --}}
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; font-family:sans-serif; font-size:10px; color:#6b7280;">
                <span>Ref. No.: <strong style="color:#111827;">{{ $refNo }}</strong></span>
                <span>Date Issued: <strong style="color:#111827;">{{ now()->format('F d, Y') }}</strong></span>
            </div>

            {{-- Document Title --}}
            <h2 id="doc-title"
                style="text-align:center; font-size:22px; font-weight:900; text-decoration:underline; text-transform:uppercase; letter-spacing:0.12em; color:#111827; margin-bottom:2rem;">
                {{ $tpl['title'] }}
            </h2>

            {{-- Body --}}
            <div class="cert-body">
                <p style="font-weight:700; font-size:16px; margin-bottom:1rem;">TO WHOM IT MAY CONCERN:</p>

                <p id="doc-body" class="indented">{!! $tpl['body'] !!}</p>

                <p class="indented" id="doc-footer">{{ $tpl['footer'] }}
                    <span id="doc-purpose"
                          contenteditable="true"
                          style="border-bottom:1px solid #374151; padding:0 6px; font-weight:700; font-style:italic; cursor:text;">{{ $purpose ?: 'general purposes' }}</span>
                    and for whatever legal purpose it may serve.
                </p>

                <p class="indented">
                    Issued this <strong>{{ $issuedDate }}</strong> at Barangay 419, Zone 43, Sampaloc, Manila, Philippines.
                </p>

                {{-- Signature Block --}}
                <div style="padding-top:3.5rem; display:flex; justify-content:space-between; align-items:flex-end;">
                    {{-- Requestor --}}
                    <div style="text-align:center;">
                        <div style="width:180px; height:56px; border:1px dashed #d1d5db; display:flex; align-items:flex-end; justify-content:center; padding-bottom:4px; margin-bottom:4px;">
                            <span style="font-size:8px; font-family:sans-serif; color:#d1d5db; text-transform:uppercase; letter-spacing:0.08em;">Signature over Printed Name</span>
                        </div>
                        <div style="border-top:2px solid #374151; padding-top:4px; width:180px;">
                            <p style="font-size:10px; font-family:sans-serif; text-transform:uppercase; letter-spacing:0.1em; color:#6b7280; margin:0;">Requestor</p>
                        </div>
                    </div>

                    {{-- Official --}}
                    <div style="text-align:center;">
                        <div style="width:210px; height:56px; margin-bottom:4px;"></div>
                        <div style="border-top:2px solid #111827; padding-top:4px; width:210px;">
                            <p style="font-size:13px; font-weight:900; font-family:sans-serif; text-transform:uppercase; letter-spacing:0.06em; margin:0 0 2px;">ERWIN R. MOLINA</p>
                            <p style="font-size:10px; font-family:sans-serif; text-transform:uppercase; letter-spacing:0.1em; color:#4b5563; margin:0;">Punong Barangay</p>
                        </div>
                    </div>
                </div>

                {{-- OR Footer --}}
                <div style="margin-top:2.5rem; padding-top:0.75rem; border-top:1px solid #e5e7eb; display:flex; justify-content:space-between; font-family:sans-serif; font-size:10px; color:#9ca3af;">
                    <span>OR No.: ___________________</span>
                    <span>Amount Paid: Php ___________</span>
                    <span>CTC No.: ___________________</span>
                </div>
            </div>
        </div>

        {{-- ===== ID CARD AREA ===== --}}
        <div id="id-card-area"
             class="flex-1 flex flex-col items-center justify-center gap-6 py-8"
             style="{{ $isIdCard ? '' : 'display:none' }}">

            <p class="no-print text-[10px] font-black text-gray-300 uppercase tracking-widest">Preview — prints at standard ID card size (3.375&Prime; × 2.125&Prime;)</p>

            <div style="display:flex; gap:24px; align-items:flex-start;">

                {{-- FRONT --}}
                <div>
                    <p class="no-print text-[9px] font-black text-gray-400 uppercase tracking-widest text-center mb-2">Front</p>
                    <div class="id-card">
                        {{-- Header --}}
                        <div class="id-front-header">
                            <div class="seal-circle">
                                <img src="{{ asset('images/manila-seal.png') }}" alt="Manila"
                                     onerror="this.style.display='none';">
                            </div>
                            <div class="hdr-text">
                                <p class="brgy-name">Barangay 419, Zone 43</p>
                                <p class="brgy-loc">Sampaloc, Manila &bull; NCR</p>
                            </div>
                            <div class="seal-circle">
                                <img src="{{ asset('images/barangay-seal.png') }}" alt="Brgy"
                                     onerror="this.style.display='none';">
                            </div>
                        </div>

                        {{-- Gold title bar --}}
                        <div class="id-card-title-bar">Barangay Identification Card</div>

                        {{-- Body --}}
                        <div class="id-front-body">
                            {{-- Photo box --}}
                            <div class="id-photo-box">
                                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span>Photo</span>
                            </div>

                            {{-- Info --}}
                            <div class="id-info">
                                <div class="id-name">{{ $fullName }}</div>
                                @if($address)
                                <div class="id-field"><span>Address: </span>{{ Str::limit($address, 55) }}</div>
                                @endif
                                @if($birthDate)
                                <div class="id-field"><span>Birthdate: </span>{{ $birthDate }}</div>
                                @endif
                                @if($gender)
                                <div class="id-field"><span>Sex: </span>{{ ucfirst($gender) }}</div>
                                @endif
                                <div class="id-field" style="display:flex; gap:8px;">
                                    @if($heightCm)<span><span style="color:#9ca3af;">Ht: </span>{{ $heightCm }} cm</span>@endif
                                    @if($weightKg)<span><span style="color:#9ca3af;">Wt: </span>{{ $weightKg }} kg</span>@endif
                                </div>
                                <div class="id-field"><span>Blood Type: </span>___</div>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="id-front-footer">
                            <p>ID No.: <span class="id-no">{{ $refNo }}</span></p>
                            <p>Valid Until: <strong style="color:#374151; font-size:5.5px;">{{ now()->format('m/d/') . ($issuedYear + 1) }}</strong></p>
                        </div>
                    </div>
                </div>

                {{-- BACK --}}
                <div>
                    <p class="no-print text-[9px] font-black text-gray-400 uppercase tracking-widest text-center mb-2">Back</p>
                    <div class="id-card id-back">
                        {{-- Back header --}}
                        <div class="id-back-header">
                            <p>Republic of the Philippines &bull; City of Manila</p>
                        </div>

                        {{-- Back body --}}
                        <div class="id-back-body">
                            <div class="ec-section">
                                <div class="ec-title">In Case of Emergency, Notify:</div>
                                <div class="ec-line">
                                    <span class="ec-label">Name:</span>
                                    <span class="ec-value"></span>
                                </div>
                                <div class="ec-line">
                                    <span class="ec-label">Relationship:</span>
                                    <span class="ec-value"></span>
                                </div>
                                <div class="ec-line">
                                    <span class="ec-label">Contact No.:</span>
                                    <span class="ec-value"></span>
                                </div>
                                <div class="ec-line" style="margin-top:2px;">
                                    <span class="ec-label">Blood Type:</span>
                                    <span class="ec-value"></span>
                                </div>
                            </div>

                            <div class="id-sig-block">
                                <div class="sig-inner">
                                    <div style="height:18px;"></div>
                                    <div class="sig-line">
                                        <p class="sig-name">ERWIN R. MOLINA</p>
                                        <p class="sig-title">Punong Barangay</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Back footer --}}
                        <div class="id-back-footer">NOT VALID WITHOUT OFFICIAL SEAL &bull; NOT TRANSFERABLE</div>
                    </div>
                </div>

            </div>{{-- end card row --}}
        </div>{{-- end id-card-area --}}

    </div>{{-- end flex gap-8 --}}
</div>{{-- end space-y-6 --}}

<script>
const templates = @json($templates);
const currentType = @json($docType);

function switchTemplate(type) {
    const isId = type === 'Barangay ID';

    // Toggle areas
    document.getElementById('certificate-area').style.display = isId ? 'none' : '';
    document.getElementById('id-card-area').style.display     = isId ? ''     : 'none';
    document.getElementById('paper-size-hint').textContent    = isId ? 'ID card size (3.375″ × 2.125″)' : 'A4 / Letter size';

    if (!isId && templates[type]) {
        document.getElementById('doc-title').innerText = templates[type].title;
        document.getElementById('doc-body').innerHTML  = templates[type].body;

        const footer  = document.getElementById('doc-footer');
        const prevPurpose = document.getElementById('doc-purpose');
        const purposeText = prevPurpose ? prevPurpose.innerText : '';
        footer.innerHTML = '';
        footer.appendChild(document.createTextNode(templates[type].footer + ' '));
        const span = document.createElement('span');
        span.id = 'doc-purpose';
        span.contentEditable = 'true';
        span.style.cssText = 'border-bottom:1px solid #374151; padding:0 6px; font-weight:700; font-style:italic; cursor:text;';
        span.innerText = purposeText;
        footer.appendChild(span);
        footer.appendChild(document.createTextNode(' and for whatever legal purpose it may serve.'));
    }

    // Update sidebar buttons
    document.querySelectorAll('[id^="btn-"]').forEach(btn => {
        btn.className = 'w-full text-left px-4 py-3 rounded-2xl text-xs font-bold transition-all bg-gray-50 text-gray-600 hover:bg-gray-100';
    });
    const activeBtn = document.getElementById('btn-' + type.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, ''));
    if (activeBtn) {
        activeBtn.className = 'w-full text-left px-4 py-3 rounded-2xl text-xs font-bold transition-all bg-brgyGreen text-white shadow-md';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    switchTemplate(currentType);
});
</script>

@endsection
