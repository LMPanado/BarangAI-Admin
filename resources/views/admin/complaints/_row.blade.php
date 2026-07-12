@php
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
<tr class="hover:bg-gray-50/50 transition-colors" id="complaint-row-{{ $complaint->id }}">
    <td class="px-6 py-5 whitespace-nowrap">
        <p class="text-xs font-bold text-gray-700">{{ $complaint->created_at->timezone('Asia/Manila')->format('M d, Y') }}</p>
        <p class="text-[10px] text-gray-400 mt-0.5">{{ $complaint->created_at->timezone('Asia/Manila')->format('h:i A') }}</p>
    </td>
    <td class="px-6 py-5">
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
    <td class="px-6 py-5">
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
    <td class="px-6 py-5">
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
    </td>
</tr>
