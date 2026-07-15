@php
    $storageBase = 'https://ypcumosboftjylrnmyih.supabase.co/storage/v1/object/public/verification-docs/';
    $residentUser = null;
    if ($request->supabase_uid) {
        $residentUser = \Illuminate\Support\Facades\DB::selectOne(
            'SELECT first_name, last_name, email, valid_id_image, selfie_image FROM users WHERE supabase_uid = ?',
            [$request->supabase_uid]
        );
    }
    $validIdUrl = ($residentUser && $residentUser->valid_id_image) ? $storageBase . $residentUser->valid_id_image : null;
    $selfieUrl  = ($residentUser && $residentUser->selfie_image)   ? $storageBase . $residentUser->selfie_image   : null;

    $badgeClass = match($request->status) {
        'pending'          => 'bg-amber-50 text-amber-600 border-amber-100',
        'processing'       => 'bg-violet-50 text-violet-600 border-violet-100',
        'ready_for_pickup' => 'bg-blue-50 text-blue-600 border-blue-100',
        'completed'        => 'bg-emerald-50 text-emerald-600 border-emerald-100',
        'cancelled'        => 'bg-red-50 text-red-600 border-red-100',
        default            => 'bg-gray-50 text-gray-400 border-gray-100',
    };
    $badgeLabel = match($request->status) {
        'pending'          => 'Pending',
        'processing'       => 'Processing',
        'ready_for_pickup' => 'Ready for Pick-up',
        'completed'        => 'Completed',
        'cancelled'        => 'Cancelled',
        default            => ucfirst($request->status),
    };
    $canExpand = !in_array($request->status, ['cancelled']);
@endphp

{{-- ── Main row ── --}}
<tr id="row-{{ $request->id }}"
    class="transition-colors group {{ $canExpand ? 'cursor-pointer hover:bg-brgyGreen/[0.02]' : 'hover:bg-gray-50/30' }}"
    @if($canExpand)
    onclick="toggleRequestRow({{ $request->id }}, '{{ $request->status }}', '{{ csrf_token() }}')"
    @endif>

    {{-- Resident --}}
    <td class="px-6 py-4">
        <div class="flex items-center gap-2">
            {{-- Chevron indicator --}}
            @if($canExpand)
            <svg id="chevron-{{ $request->id }}" class="w-3.5 h-3.5 text-gray-300 flex-shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
            @endif
            <div>
                <div class="font-bold text-sm text-gray-800 group-hover:text-brgyGreen transition-colors leading-tight">
                    @if($request->resident)
                        {{ $request->resident->first_name }} {{ $request->resident->last_name }}
                    @elseif($residentUser)
                        {{ $residentUser->first_name }} {{ $residentUser->last_name }}
                    @elseif($request->full_name)
                        {{ $request->full_name }}
                    @else
                        <span class="text-gray-300 italic text-xs font-medium">Unknown</span>
                    @endif
                </div>
                @if($residentUser?->email)
                    <div class="text-[10px] text-gray-400 font-medium mt-0.5 truncate">{{ $residentUser->email }}</div>
                @endif
                <div class="mt-1">
                    @if($request->reference_no)
                        <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest font-mono">{{ $request->reference_no }}</span>
                    @else
                        <span class="inline-flex items-center gap-1.5">
                            <span class="px-1.5 py-0.5 bg-amber-50 text-amber-500 text-[9px] font-black rounded border border-amber-100 uppercase tracking-wide">Unverified</span>
                            <span class="text-[10px] font-black text-gray-300 font-mono">ID-{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </td>

    {{-- Document --}}
    <td class="px-6 py-4">
        <span class="px-2.5 py-1 bg-brgyGreen/5 text-brgyGreen text-[10px] font-black rounded-lg border border-brgyGreen/10 uppercase tracking-wide whitespace-nowrap">
            {{ str_replace('_', ' ', $request->document_type) }}
        </span>
    </td>

    {{-- Purpose --}}
    <td class="px-6 py-4 max-w-[180px]">
        <p class="text-xs text-gray-400 italic line-clamp-2 leading-relaxed">"{{ $request->purpose }}"</p>
        @if($request->status === 'cancelled' && $request->cancellation_reason)
        <p class="text-[10px] text-red-400 font-bold mt-1 line-clamp-2">
            <span class="font-black uppercase tracking-wide">Reason:</span> {{ $request->cancellation_reason }}
        </p>
        @endif
    </td>

    {{-- Date Requested --}}
    <td class="px-6 py-4 whitespace-nowrap">
        @php $requestDate = $request->created_at ?? $request->updated_at; @endphp
        @if($requestDate)
            <p class="text-xs font-bold text-gray-700">{{ $requestDate->timezone('Asia/Manila')->format('M d, Y') }}</p>
            <p class="text-[10px] text-gray-400 mt-0.5">{{ $requestDate->timezone('Asia/Manila')->format('h:i A') }}</p>
        @else
            <span class="text-[10px] text-gray-300 font-bold">—</span>
        @endif
    </td>

    {{-- Status badge (non-clickable) --}}
    <td class="px-6 py-4 align-middle text-center">
        <span id="status-badge-{{ $request->id }}"
              class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border text-[9px] font-black uppercase tracking-widest {{ $badgeClass }}">
            <span class="w-1.5 h-1.5 rounded-full bg-current opacity-60"></span>
            {{ $badgeLabel }}
        </span>
    </td>

    {{-- Actions --}}
    <td class="px-6 py-4" onclick="event.stopPropagation()">
        <div class="flex items-center justify-end gap-2">

            @if($showVerify && !$request->reference_no)
            <form action="{{ route('admin.documents.verify', $request->id) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" title="Verify & Generate Ref No."
                        class="flex items-center gap-1 px-2.5 py-1.5 bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white rounded-lg text-[9px] font-black uppercase tracking-widest transition-all">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Verify
                </button>
            </form>
            @endif

            {{-- Cancel button (only if not already cancelled/completed) --}}
            @if(!in_array($request->status, ['cancelled', 'completed']))
            <button onclick="openCancelModal({{ $request->id }})"
                    title="Cancel Request"
                    class="p-2 bg-red-50 text-red-400 hover:bg-red-500 hover:text-white rounded-lg transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            {{-- Hidden cancel form --}}
            <form id="cancel-form-{{ $request->id }}" action="{{ route('admin.documents.updateStatus', $request->id) }}" method="POST" class="hidden">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="cancelled">
                <input type="hidden" name="cancellation_reason" id="cancel-reason-input-{{ $request->id }}">
            </form>
            @endif

            @if(in_array(auth()->user()->role, [1, 2]))
            <form id="del-doc-{{ $request->id }}" action="{{ route('admin.documents.destroy', $request->id) }}" method="POST">
                @csrf @method('DELETE')
            </form>
            <button onclick="confirmDelete('del-doc-{{ $request->id }}', 'Delete request #{{ $request->reference_no ?? $request->id }}?')"
                    title="Delete" class="p-2 bg-gray-50 text-gray-400 hover:bg-red-500 hover:text-white rounded-lg transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
            @endif
        </div>
    </td>
</tr>

{{-- ── Expanded detail row ── --}}
<tr id="detail-{{ $request->id }}" class="hidden bg-slate-50/60">
    <td colspan="6" class="px-6 py-5 border-b border-gray-100">
        <div class="flex gap-6 items-start">

            {{-- ID Images --}}
            <div class="flex gap-4 flex-shrink-0">
                @if($validIdUrl)
                <div class="text-center">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Valid ID</p>
                    <button type="button" onclick="openLightbox('{{ $validIdUrl }}', 'Valid ID')"
                            class="block w-32 h-20 rounded-xl overflow-hidden border-2 border-gray-200 hover:border-brgyGreen transition-all shadow-sm">
                        <img src="{{ $validIdUrl }}" class="w-full h-full object-cover" alt="Valid ID">
                    </button>
                    <p class="text-[8px] text-gray-300 mt-1 uppercase tracking-widest">Click to enlarge</p>
                </div>
                @endif
                @if($selfieUrl)
                <div class="text-center">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Selfie Photo</p>
                    <button type="button" onclick="openLightbox('{{ $selfieUrl }}', 'Selfie Photo')"
                            class="block w-20 h-20 rounded-xl overflow-hidden border-2 border-gray-200 hover:border-brgyGreen transition-all shadow-sm">
                        <img src="{{ $selfieUrl }}" class="w-full h-full object-cover" alt="Selfie">
                    </button>
                    <p class="text-[8px] text-gray-300 mt-1 uppercase tracking-widest">Click to enlarge</p>
                </div>
                @endif
                @if(!$validIdUrl && !$selfieUrl)
                <div class="w-32 h-20 rounded-xl border-2 border-dashed border-gray-200 flex items-center justify-center">
                    <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest text-center leading-tight">No ID<br>Uploaded</p>
                </div>
                @endif
            </div>

            {{-- Request Details --}}
            <div class="flex-1 grid grid-cols-3 gap-4">
                <div>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Document Type</p>
                    <p class="text-xs font-bold text-gray-700">{{ str_replace('_', ' ', $request->document_type) }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Purpose</p>
                    <p class="text-xs font-bold text-gray-700">{{ $request->purpose }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Preferred Pick-up Date</p>
                    <p class="text-xs font-bold text-gray-700">{{ $request->pickup_date ? \Carbon\Carbon::parse($request->pickup_date)->format('M d, Y') : '—' }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Address</p>
                    <p class="text-xs font-bold text-gray-700">{{ $request->address ?: '—' }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Reference No.</p>
                    <p class="text-xs font-bold text-gray-700 font-mono">{{ $request->reference_no ?: '—' }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Current Status</p>
                    <span id="detail-status-badge-{{ $request->id }}"
                          class="inline-flex items-center gap-1 px-2 py-1 rounded-lg border text-[9px] font-black uppercase tracking-widest {{ $badgeClass }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-current opacity-60"></span>
                        {{ $badgeLabel }}
                    </span>
                </div>
            </div>

            {{-- Process Issuance CTA --}}
            @if(!in_array($request->status, ['cancelled', 'completed']))
            <div class="flex-shrink-0 flex flex-col gap-2">
                <a href="{{ route('admin.documents.issuance', $request->id) }}"
                   class="flex items-center gap-2 px-4 py-2.5 bg-brgyGreen text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:shadow-lg hover:shadow-brgyGreen/20 hover:-translate-y-0.5 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Process Issuance
                </a>
                <p class="text-[8px] text-gray-400 text-center leading-tight">Prints & marks<br>Ready for Pick-up</p>
            </div>
            @endif
        </div>
    </td>
</tr>

{{-- Lightbox (shared, only rendered once per page via @once) --}}
@once
<div id="doc-lightbox" onclick="closeLightbox()"
     class="fixed inset-0 z-[9999] bg-black/80 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="relative max-w-2xl w-full" onclick="event.stopPropagation()">
        <button onclick="closeLightbox()"
                class="absolute -top-10 right-0 text-white/70 hover:text-white text-xs font-black uppercase tracking-widest">
            ✕ Close
        </button>
        <img id="lightbox-img" src="" alt="" class="w-full rounded-2xl shadow-2xl">
        <p id="lightbox-label" class="text-center text-white/60 text-xs font-bold mt-3 uppercase tracking-widest"></p>
    </div>
</div>
<script>
function openLightbox(url, label) {
    document.getElementById('lightbox-img').src = url;
    document.getElementById('lightbox-label').textContent = label;
    const lb = document.getElementById('doc-lightbox');
    lb.classList.remove('hidden');
    lb.classList.add('flex');
}
function closeLightbox() {
    const lb = document.getElementById('doc-lightbox');
    lb.classList.add('hidden');
    lb.classList.remove('flex');
}
</script>
@endonce
