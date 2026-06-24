<tr class="hover:bg-slate-50/50 transition-all group">
    {{-- Resident Info --}}
    <td class="px-8 py-6">
        <div class="font-bold text-slate-800 text-base leading-tight group-hover:text-brgyGreen transition-colors">
            @if($request->resident)
                {{ $request->resident->first_name }} {{ $request->resident->last_name }}
            @elseif($request->full_name)
                {{ $request->full_name }}
            @else
                <span class="text-gray-400 italic font-medium text-xs">Unknown</span>
            @endif
        </div>
        <div class="flex items-center gap-2 mt-1">
            @if($request->reference_no)
                <span class="w-1 h-1 bg-brgyGold rounded-full"></span>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 font-mono">{{ $request->reference_no }}</p>
            @else
                {{-- Unverified kiosk: show Unverified badge + ID --}}
                <span class="px-2 py-0.5 bg-amber-50 text-amber-600 text-[9px] font-black rounded-md border border-amber-100 uppercase tracking-widest">Unverified</span>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 font-mono">ID: #{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}</span>
            @endif
        </div>
    </td>

    {{-- Document Type --}}
    <td class="px-8 py-6">
        <span class="px-3 py-1 bg-brgyGreen/5 text-brgyGreen text-[10px] font-black rounded-lg border border-brgyGreen/10 uppercase tracking-widest">
            {{ str_replace('_', ' ', $request->document_type) }}
        </span>
    </td>

    {{-- Purpose --}}
    <td class="px-8 py-6">
        <p class="text-xs text-slate-500 italic max-w-[180px] line-clamp-2 leading-relaxed">
            "{{ $request->purpose }}"
        </p>
    </td>

    {{-- Schedule --}}
    <td class="px-8 py-6">
        <div class="flex items-center gap-2">
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <span class="text-xs font-bold text-slate-600">
                {{ $request->pickup_date ? \Carbon\Carbon::parse($request->pickup_date)->format('M d, Y') : '—' }}
            </span>
        </div>
    </td>

    {{-- Status --}}
    <td class="px-8 py-6">
        <form action="{{ route('admin.documents.updateStatus', $request->id) }}" method="POST">
            @csrf @method('PATCH')
            @php
                $selectColor = match($request->status) {
                    'pending'          => 'bg-amber-50 text-amber-600 border-amber-100',
                    'processing'       => 'bg-violet-50 text-violet-600 border-violet-100',
                    'ready_for_pickup' => 'bg-blue-50 text-blue-600 border-blue-100',
                    'completed'        => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                    'cancelled'        => 'bg-red-50 text-red-600 border-red-100',
                    default            => 'bg-slate-50 text-slate-500 border-slate-100',
                };
            @endphp
            <select name="status" onchange="this.form.submit()"
                class="text-[9px] font-black uppercase tracking-widest px-4 py-2 rounded-xl border-2 cursor-pointer transition-all focus:ring-0 {{ $selectColor }}">
                <option value="pending"          {{ $request->status == 'pending'          ? 'selected' : '' }}>Pending</option>
                <option value="processing"       {{ $request->status == 'processing'       ? 'selected' : '' }}>Processing</option>
                <option value="ready_for_pickup" {{ $request->status == 'ready_for_pickup' ? 'selected' : '' }}>Ready for Pick-up</option>
                <option value="completed"        {{ $request->status == 'completed'        ? 'selected' : '' }}>Completed</option>
                <option value="cancelled"        {{ $request->status == 'cancelled'        ? 'selected' : '' }}>Cancelled</option>
            </select>
        </form>
    </td>

    {{-- Actions --}}
    <td class="px-8 py-6">
        <div class="flex items-center justify-end gap-3">

            {{-- Verify button (kiosk unverified only) --}}
            @if($showVerify && !$request->reference_no)
            <form action="{{ route('admin.documents.verify', $request->id) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" title="Verify & Generate Ref No."
                        class="flex items-center gap-1.5 px-3 py-2 bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white rounded-xl text-[9px] font-black uppercase tracking-widest transition-all duration-300">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Verify
                </button>
            </form>
            @endif

            {{-- Process / Issuance --}}
            <a href="{{ route('admin.documents.issuance', $request->id) }}"
               class="p-2.5 bg-brgyGreen/5 text-brgyGreen hover:bg-brgyGreen hover:text-white rounded-xl transition-all duration-300" title="Process Issuance">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </a>

            {{-- Delete --}}
            <form id="del-doc-{{ $request->id }}" action="{{ route('admin.documents.destroy', $request->id) }}" method="POST">
                @csrf @method('DELETE')
            </form>
            <button onclick="confirmDelete('del-doc-{{ $request->id }}', 'Delete request #{{ $request->reference_no ?? $request->id }}? This cannot be undone.')"
                    class="p-2.5 bg-red-50 text-red-400 hover:bg-red-500 hover:text-white rounded-xl transition-all duration-300" title="Delete Request">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
        </div>
    </td>
</tr>
