<tr class="hover:bg-gray-50/50 transition-colors group">
    {{-- Resident --}}
    <td class="px-6 py-4">
        <div class="font-bold text-sm text-gray-800 group-hover:text-brgyGreen transition-colors leading-tight">
            @if($request->resident)
                {{ $request->resident->first_name }} {{ $request->resident->last_name }}
            @elseif($request->full_name)
                {{ $request->full_name }}
            @else
                <span class="text-gray-300 italic text-xs font-medium">Unknown</span>
            @endif
        </div>
        {{-- Email: mobile requests only --}}
        @if($request->source === 'mobile' && $request->supabase_uid)
        @php
            $residentEmail = \Illuminate\Support\Facades\DB::selectOne(
                'SELECT email FROM users WHERE supabase_uid = ?', [$request->supabase_uid]
            )?->email;
        @endphp
        @if($residentEmail)
        <div class="text-[10px] text-gray-400 font-medium mt-0.5 truncate">{{ $residentEmail }}</div>
        @endif
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
    </td>

    {{-- Document --}}
    <td class="px-6 py-4">
        <span class="px-2.5 py-1 bg-brgyGreen/5 text-brgyGreen text-[10px] font-black rounded-lg border border-brgyGreen/10 uppercase tracking-wide whitespace-nowrap">
            {{ str_replace('_', ' ', $request->document_type) }}
        </span>
    </td>

    {{-- Date Requested --}}
    <td class="px-6 py-4 whitespace-nowrap">
        <p class="text-xs font-bold text-gray-700">{{ $request->created_at->format('M d, Y') }}</p>
        <p class="text-[10px] text-gray-400 mt-0.5">{{ $request->created_at->format('h:i A') }}</p>
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

    {{-- Schedule --}}
    <td class="px-6 py-4">
        <span class="text-xs font-bold text-gray-500">
            {{ $request->pickup_date ? \Carbon\Carbon::parse($request->pickup_date)->format('M d, Y') : '—' }}
        </span>
    </td>

    {{-- Status --}}
    <td class="px-6 py-4">
        <form action="{{ route('admin.documents.updateStatus', $request->id) }}" method="POST"
              id="status-form-{{ $request->id }}">
            @csrf @method('PATCH')
            <input type="hidden" name="cancellation_reason" id="cancel-reason-input-{{ $request->id }}">
            @php
                $selectColor = match($request->status) {
                    'pending'          => 'bg-amber-50 text-amber-600 border-amber-100',
                    'processing'       => 'bg-violet-50 text-violet-600 border-violet-100',
                    'ready_for_pickup' => 'bg-blue-50 text-blue-600 border-blue-100',
                    'completed'        => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                    'cancelled'        => 'bg-red-50 text-red-600 border-red-100',
                    default            => 'bg-gray-50 text-gray-400 border-gray-100',
                };
            @endphp
            <select name="status"
                    onchange="handleStatusChange(this, {{ $request->id }})"
                    class="text-[9px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg border cursor-pointer focus:ring-0 outline-none {{ $selectColor }}">
                <option value="pending"          {{ $request->status == 'pending'          ? 'selected' : '' }}>Pending</option>
                <option value="processing"       {{ $request->status == 'processing'       ? 'selected' : '' }}>Processing</option>
                <option value="ready_for_pickup" {{ $request->status == 'ready_for_pickup' ? 'selected' : '' }}>Ready for Pick-up</option>
                <option value="completed"        {{ $request->status == 'completed'        ? 'selected' : '' }}>Completed</option>
                <option value="cancelled"        {{ $request->status == 'cancelled'        ? 'selected' : '' }}>Cancelled</option>
            </select>
        </form>
    </td>

    {{-- Actions --}}
    <td class="px-6 py-4">
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

            <a href="{{ route('admin.documents.issuance', $request->id) }}" title="Process Issuance"
               class="p-2 bg-brgyGreen/5 text-brgyGreen hover:bg-brgyGreen hover:text-white rounded-lg transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </a>

            @if(in_array(auth()->user()->role, [1, 2]))
            <form id="del-doc-{{ $request->id }}" action="{{ route('admin.documents.destroy', $request->id) }}" method="POST">
                @csrf @method('DELETE')
            </form>
            <button onclick="confirmDelete('del-doc-{{ $request->id }}', 'Delete request #{{ $request->reference_no ?? $request->id }}?')"
                    title="Delete" class="p-2 bg-red-50 text-red-400 hover:bg-red-500 hover:text-white rounded-lg transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
            @endif
        </div>
    </td>
</tr>
