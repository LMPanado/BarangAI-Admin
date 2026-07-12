@php
    $storagBase   = 'https://ypcumosboftjylrnmyih.supabase.co/storage/v1/object/public/verification-docs/';
    $validIdUrl   = $user->valid_id_image ? $storagBase . $user->valid_id_image : null;
    $selfieUrl    = $user->selfie_image   ? $storagBase . $user->selfie_image   : null;
    $residentName = addslashes(trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')));
@endphp
<div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden"
     id="verification-card-{{ $user->id }}">

    {{-- Card Header --}}
    <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-amber-50 flex items-center justify-center font-black text-amber-600 text-sm">
                {{ strtoupper(substr($user->first_name ?? $user->email, 0, 1)) }}
            </div>
            <div>
                <p class="text-sm font-extrabold text-gray-800">
                    {{ trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: 'Unknown Name' }}
                </p>
                <p class="text-[10px] text-gray-400 font-medium mt-0.5">{{ $user->email }}</p>
            </div>
        </div>
        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-amber-50 text-amber-600">
            Pending
        </span>
    </div>

    {{-- Resident Details --}}
    <div class="px-6 py-4 grid grid-cols-3 gap-3 border-b border-gray-50">
        @foreach([
            ['label' => 'Age',    'value' => $user->age ?? '—'],
            ['label' => 'Gender', 'value' => $user->gender ?? '—'],
            ['label' => 'Phone',  'value' => $user->phone ?? '—'],
        ] as $detail)
        <div>
            <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest">{{ $detail['label'] }}</p>
            <p class="text-xs font-bold text-gray-700 mt-0.5">{{ $detail['value'] }}</p>
        </div>
        @endforeach
        @if($user->verification_submitted_at)
        <div class="col-span-3">
            <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest">Submitted</p>
            <p class="text-xs font-bold text-gray-500 mt-0.5">
                {{ \Carbon\Carbon::parse($user->verification_submitted_at)->format('M d, Y · h:i A') }}
            </p>
        </div>
        @endif
    </div>

    {{-- ID Photos --}}
    <div class="px-6 py-5 grid grid-cols-2 gap-4 border-b border-gray-50">
        <div>
            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Valid ID</p>
            @if($user->valid_id_image)
                <button onclick="openLightbox('{{ $validIdUrl }}', 'Valid ID — {{ $residentName }}')"
                        class="w-full group relative overflow-hidden rounded-2xl border-2 border-gray-100 hover:border-brgyGreen/30 transition-all">
                    <img src="{{ $validIdUrl }}" alt="Valid ID"
                         class="w-full h-32 object-cover group-hover:scale-105 transition-transform duration-300"
                         onerror="this.parentElement.innerHTML='<div class=\'w-full h-32 rounded-2xl bg-gray-50 flex items-center justify-center\'><p class=\'text-[9px] font-black text-gray-300 uppercase tracking-widest\'>Failed to load</p></div>'">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all flex items-center justify-center">
                        <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </button>
            @else
                <div class="w-full h-32 rounded-2xl border-2 border-dashed border-gray-100 flex flex-col items-center justify-center gap-1">
                    <svg class="w-6 h-6 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/>
                    </svg>
                    <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest">Not Submitted</p>
                </div>
            @endif
        </div>
        <div>
            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Selfie Photo</p>
            @if($user->selfie_image)
                <button onclick="openLightbox('{{ $selfieUrl }}', 'Selfie — {{ $residentName }}')"
                        class="w-full group relative overflow-hidden rounded-2xl border-2 border-gray-100 hover:border-brgyGreen/30 transition-all">
                    <img src="{{ $selfieUrl }}" alt="Selfie"
                         class="w-full h-32 object-cover object-top group-hover:scale-105 transition-transform duration-300"
                         onerror="this.parentElement.innerHTML='<div class=\'w-full h-32 rounded-2xl bg-gray-50 flex items-center justify-center\'><p class=\'text-[9px] font-black text-gray-300 uppercase tracking-widest\'>Failed to load</p></div>'">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all flex items-center justify-center">
                        <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </button>
            @else
                <div class="w-full h-32 rounded-2xl border-2 border-dashed border-gray-100 flex flex-col items-center justify-center gap-1">
                    <svg class="w-6 h-6 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest">Not Submitted</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="px-6 py-4 flex items-center gap-3">
        <button onclick="verifyUser({{ $user->id }}, 'verify', '{{ route('admin.verification.verify', $user->id) }}')"
                id="verify-btn-{{ $user->id }}"
                class="flex-1 flex items-center justify-center gap-2 py-3 bg-brgyGreen text-white text-[10px] font-black uppercase tracking-widest rounded-2xl hover:shadow-lg hover:shadow-brgyGreen/20 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Verify Account
        </button>
        <button onclick="openRejectModal({{ $user->id }}, '{{ route('admin.verification.reject', $user->id) }}')"
                id="reject-btn-{{ $user->id }}"
                class="flex items-center justify-center gap-2 px-5 py-3 bg-red-50 text-red-500 text-[10px] font-black uppercase tracking-widest rounded-2xl border-2 border-red-100 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Reject
        </button>
    </div>
</div>
