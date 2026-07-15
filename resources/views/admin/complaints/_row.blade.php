@php
    $isBlotter = ($complaint->type ?? 'complaint') === 'blotter';
    $severityStyle = match($complaint->severity) {
        'critical' => 'bg-red-50 text-red-700',
        'medium'   => 'bg-orange-50 text-orange-700',
        'low'      => 'bg-gray-100 text-gray-600',
        default    => 'bg-gray-50 text-gray-400',
    };
    $statusStyle = match($complaint->status) {
        'open'   => 'bg-amber-50 text-amber-700',
        'closed' => 'bg-green-50 text-green-700',
        default  => 'bg-gray-50 text-gray-400',
    };
    $msgCount = $messageCounts[$complaint->id] ?? 0;
@endphp

{{-- Main row --}}
<tr class="hover:bg-gray-50/50 transition-colors {{ $isBlotter ? 'cursor-pointer' : '' }}" id="complaint-row-{{ $complaint->id }}"
    @if($isBlotter) onclick="toggleBlotter({{ $complaint->id }})" @endif>
    <td class="px-6 py-5 whitespace-nowrap">
        <div class="flex items-center gap-2">
            @if($isBlotter)
            <svg id="blotter-chevron-{{ $complaint->id }}" class="w-3.5 h-3.5 text-gray-300 flex-shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
            @endif
            <div>
                <p class="text-xs font-bold text-gray-700">{{ $complaint->created_at->timezone('Asia/Manila')->format('M d, Y') }}</p>
                <p class="text-[10px] text-gray-400 mt-0.5">{{ $complaint->created_at->timezone('Asia/Manila')->format('h:i A') }}</p>
                @if($isBlotter)
                <span class="inline-block mt-1 px-1.5 py-0.5 bg-indigo-50 text-indigo-600 text-[8px] font-black uppercase tracking-widest rounded border border-indigo-100">Blotter</span>
                @endif
            </div>
        </div>
    </td>
    <td class="px-6 py-5" onclick="event.stopPropagation()">
        @if($complaint->residentUser)
            <p class="text-xs font-bold text-gray-800">{{ $complaint->residentUser->first_name }} {{ $complaint->residentUser->last_name }}</p>
        @endif
        <p class="text-[10px] {{ $complaint->residentUser ? 'text-gray-400 font-medium' : 'text-xs font-bold text-gray-800' }}">{{ $complaint->user_email }}</p>
    </td>
    <td class="px-6 py-5 max-w-xs">
        <p class="text-xs text-gray-600 line-clamp-2" title="{{ $complaint->message }}">{{ $complaint->message }}</p>
    </td>
    <td class="px-6 py-5 max-w-xs">
        @if($complaint->ai_summary)
            <p class="text-[10px] text-gray-500 italic line-clamp-2" title="{{ $complaint->ai_summary }}">{{ $complaint->ai_summary }}</p>
        @else
            <span class="text-[10px] text-gray-300 font-bold">—</span>
        @endif
    </td>
    <td class="px-6 py-5">
        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $severityStyle }}">
            {{ $complaint->severity ?? 'unset' }}
        </span>
    </td>
    <td class="px-6 py-5" onclick="event.stopPropagation()">
        @if(auth()->user()->isCaptain() || auth()->user()->isAdmin())
        <form action="{{ route('admin.complaints.updateStatus', $complaint->id) }}" method="POST">
            @csrf @method('PATCH')
            <select name="status" onchange="confirmAction(this.form, 'Change this complaint status to \'' + this.options[this.selectedIndex].text + '\'?')"
                    class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border-0 cursor-pointer focus:ring-2 focus:ring-brgyGreen/20 outline-none
                           {{ ($complaint->status ?? 'open') === 'open' ? 'bg-amber-50 text-amber-700' : 'bg-green-50 text-green-700' }}">
                <option value="open"   {{ ($complaint->status ?? 'open') === 'open'   ? 'selected' : '' }}>Open</option>
                <option value="closed" {{ ($complaint->status ?? 'open') === 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </form>
        @else
        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $statusStyle }}">
            {{ $complaint->status ?? 'open' }}
        </span>
        @endif
    </td>
    <td class="px-6 py-5" onclick="event.stopPropagation()">
        <div class="flex items-center gap-2">
            <button onclick="openChat({{ $complaint->id }}, '{{ addslashes($complaint->user_email) }}', '{{ $complaint->status }}')"
                    class="relative inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-brgyGreen/5 text-brgyGreen hover:bg-brgyGreen hover:text-white transition-all text-[10px] font-black uppercase tracking-widest group">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                          d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
                Message
                @if($msgCount > 0)
                    <span class="absolute -top-1.5 -right-1.5 w-4 h-4 bg-brgyGreen text-white group-hover:bg-white group-hover:text-brgyGreen rounded-full text-[8px] font-black flex items-center justify-center transition-all">
                        {{ $msgCount }}
                    </span>
                @endif
            </button>

            @if($isBlotter)
            <a href="{{ route('admin.complaints.printBlotter', $complaint->id) }}" target="_blank"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all text-[10px] font-black uppercase tracking-widest">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print
            </a>
            @endif
        </div>
    </td>
</tr>

@if($isBlotter)
{{-- Blotter accordion detail row --}}
<tr id="blotter-detail-{{ $complaint->id }}" class="hidden bg-indigo-50/30">
    <td colspan="7" class="px-6 py-5 border-b border-indigo-100/50">
        <div class="space-y-4">

            {{-- Respondent check badge --}}
            <div class="flex items-center gap-3">
                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Respondent Status:</span>
                @if($complaint->respondent_is_resident)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-green-50 text-green-700 border border-green-100 text-[10px] font-black uppercase tracking-widest">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Found in resident records
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 text-red-600 border border-red-100 text-[10px] font-black uppercase tracking-widest">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        Not a registered resident
                    </span>
                @endif

                @if($complaint->respondent_is_resident && $complaint->respondent_matched_uid)
                <button
                    onclick="notifyRespondent({{ $complaint->id }}, this)"
                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-100 hover:bg-amber-500 hover:text-white hover:border-amber-500 text-[10px] font-black uppercase tracking-widest transition-all">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    Notify Respondent
                </button>
                @endif
            </div>

            {{-- Incident details grid --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-white rounded-xl p-4 border border-indigo-100/60">
                <div>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Incident Type</p>
                    <p class="text-xs font-bold text-gray-700">{{ $complaint->incident_type ?: '—' }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Incident Date</p>
                    <p class="text-xs font-bold text-gray-700">
                        {{ $complaint->incident_date ? $complaint->incident_date->format('M d, Y') : '—' }}
                    </p>
                </div>
                <div>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Incident Time</p>
                    <p class="text-xs font-bold text-gray-700">
                        {{ $complaint->incident_time ? \Carbon\Carbon::parse($complaint->incident_time)->format('h:i A') : '—' }}
                    </p>
                </div>
                <div>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Incident Location</p>
                    <p class="text-xs font-bold text-gray-700">{{ $complaint->incident_location ?: '—' }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Respondent Name</p>
                    <p class="text-xs font-bold text-gray-700">{{ $complaint->respondent_name ?: '—' }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Respondent Address</p>
                    <p class="text-xs font-bold text-gray-700">{{ $complaint->respondent_address ?: '—' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Witnesses</p>
                    <p class="text-xs font-bold text-gray-700">{{ $complaint->witnesses ?: '—' }}</p>
                </div>
            </div>

            {{-- Narrative --}}
            <div class="bg-white rounded-xl p-4 border border-indigo-100/60">
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Narrative / Statement</p>
                <p class="text-xs text-gray-700 leading-relaxed">{{ $complaint->message }}</p>
            </div>
        </div>
    </td>
</tr>
@endif

@once
<script>
function toggleBlotter(id) {
    const detail  = document.getElementById('blotter-detail-' + id);
    const chevron = document.getElementById('blotter-chevron-' + id);
    if (!detail) return;
    const isHidden = detail.classList.contains('hidden');
    detail.classList.toggle('hidden', !isHidden);
    if (chevron) chevron.style.transform = isHidden ? 'rotate(90deg)' : '';
}

function notifyRespondent(id, btn) {
    if (!confirm('Send a push notification to the respondent?')) return;
    btn.disabled = true;
    btn.textContent = 'Sending…';

    fetch('/admin/complaints/' + id + '/notify-respondent', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            btn.textContent = 'Notified ✓';
            btn.classList.remove('bg-amber-50','text-amber-700','border-amber-100','hover:bg-amber-500','hover:text-white','hover:border-amber-500');
            btn.classList.add('bg-green-50','text-green-700','border-green-100');
        } else {
            btn.disabled = false;
            btn.textContent = 'Notify Respondent';
            alert(data.message || 'Notification failed.');
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.textContent = 'Notify Respondent';
        alert('Request failed. Please try again.');
    });
}
</script>
@endonce
