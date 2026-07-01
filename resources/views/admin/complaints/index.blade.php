@extends('layouts.admin')

@section('content')
<div class="space-y-8 pb-12 max-w-[1600px] mx-auto">

    {{-- Header --}}
    <div class="flex justify-between items-center border-b border-gray-100 pb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Complaints</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium italic">
                Resident-submitted complaints for <span class="text-brgyGreen font-bold not-italic">Barangay 419</span>.
            </p>
        </div>
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
                <button onclick="location.reload()" title="Refresh"
                        class="p-1.5 rounded-lg text-gray-300 hover:text-brgyGreen hover:bg-green-50 transition-all">
                    <svg id="refresh-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </button>
            </div>
            <nav class="flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider">
                <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-brgyGreen transition-colors">Dashboard</a>
                <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                <span class="text-brgyGreen">Complaints</span>
            </nav>
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="grid grid-cols-5 gap-4">
        @foreach([
            ['Total',    $totalComplaints,        'text-gray-700',   'bg-gray-50',   'border-gray-100'],
            ['Open',     $openComplaints,         'text-amber-600',  'bg-amber-50',  'border-amber-100'],
            ['Closed',   $closedComplaints,       'text-green-600',  'bg-green-50',  'border-green-100'],
            ['Critical', $bySeverity['critical'], 'text-red-600',    'bg-red-50',    'border-red-100'],
            ['Medium',   $bySeverity['medium'],   'text-orange-600', 'bg-orange-50', 'border-orange-100'],
        ] as [$lbl, $val, $clr, $bg, $border])
        <div class="rounded-2xl {{ $bg }} border {{ $border }} px-5 py-4 flex items-center gap-3">
            <p class="text-2xl font-extrabold {{ $clr }}">{{ $val }}</p>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-tight">{{ $lbl }}</p>
        </div>
        @endforeach
    </div>

    {{-- Sort Toggle --}}
    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.complaints.index') }}"
          class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by email or message..."
                   class="sm:col-span-1 bg-gray-50 border-2 border-gray-100 rounded-2xl px-5 py-3 text-sm font-bold text-gray-700 focus:bg-white focus:border-brgyGreen focus:ring-4 focus:ring-brgyGreen/5 outline-none transition-all placeholder:text-gray-300">

            <select name="severity"
                    class="bg-gray-50 border-2 border-gray-100 rounded-2xl px-5 py-3 text-sm font-bold text-gray-700 focus:bg-white focus:border-brgyGreen outline-none transition-all">
                <option value="">All Severity Levels</option>
                <option value="critical" {{ request('severity') === 'critical' ? 'selected' : '' }}>Critical</option>
                <option value="medium"   {{ request('severity') === 'medium'   ? 'selected' : '' }}>Medium</option>
                <option value="low"      {{ request('severity') === 'low'      ? 'selected' : '' }}>Low</option>
            </select>

            <select name="status"
                    class="bg-gray-50 border-2 border-gray-100 rounded-2xl px-5 py-3 text-sm font-bold text-gray-700 focus:bg-white focus:border-brgyGreen outline-none transition-all">
                <option value="">All Statuses</option>
                <option value="open"   {{ request('status') === 'open'   ? 'selected' : '' }}>Open</option>
                <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
            <div class="flex items-center gap-3">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest shrink-0">From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                       class="flex-1 bg-gray-50 border-2 border-gray-100 rounded-2xl px-5 py-3 text-sm font-bold text-gray-700 focus:bg-white focus:border-brgyGreen outline-none transition-all">
            </div>
            <div class="flex items-center gap-3">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest shrink-0">To</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                       class="flex-1 bg-gray-50 border-2 border-gray-100 rounded-2xl px-5 py-3 text-sm font-bold text-gray-700 focus:bg-white focus:border-brgyGreen outline-none transition-all">
            </div>
        </div>

        <input type="hidden" name="sort" value="{{ $sort }}">

        <div class="flex items-center gap-3 mt-4">
            <button type="submit"
                    class="bg-brgyGreen text-white px-6 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-xl hover:shadow-lg hover:shadow-brgyGreen/20 transition-all">
                Filter
            </button>
            @if(request()->hasAny(['search','severity','status','date_from','date_to']))
                <a href="{{ route('admin.complaints.index') }}"
                   class="px-6 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-xl border-2 border-gray-100 text-gray-400 hover:border-gray-200 hover:text-gray-600 transition-all">
                    Clear
                </a>
            @endif
            @if(request('date_from') || request('date_to'))
            <span class="text-[10px] font-bold text-gray-400">
                {{ request('date_from') ? \Carbon\Carbon::parse(request('date_from'))->format('M d, Y') : '...' }}
                &rarr;
                {{ request('date_to') ? \Carbon\Carbon::parse(request('date_to'))->format('M d, Y') : '...' }}
            </span>
            @endif
            <div class="ml-auto flex items-center gap-2">
                <a href="{{ route('admin.complaints.index', array_merge(request()->except('sort'), ['sort' => 'severity'])) }}"
                   class="px-4 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all
                          {{ $sort === 'severity' ? 'bg-brgyGreen text-white' : 'border border-gray-200 text-gray-400 hover:text-gray-600' }}">
                    Severity
                </a>
                <a href="{{ route('admin.complaints.index', array_merge(request()->except('sort'), ['sort' => 'latest'])) }}"
                   class="px-4 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all
                          {{ $sort === 'latest' ? 'bg-brgyGreen text-white' : 'border border-gray-200 text-gray-400 hover:text-gray-600' }}">
                    Latest
                </a>
                <span class="pl-2 text-[10px] font-black text-gray-300 uppercase tracking-widest">
                    {{ $complaints->total() }} {{ Str::plural('complaint', $complaints->total()) }}
                </span>
            </div>
        </div>
    </form>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 rounded-2xl bg-green-50 border border-green-100">
            <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            <p class="text-xs font-bold text-green-700">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Complaints Table --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        @if($complaints->isEmpty())
            <div class="py-24 text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">No complaints found</p>
            </div>
        @else
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-50 bg-gray-50/50">
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Date</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Resident</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Message</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">AI Summary</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Severity</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Status</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($complaints as $complaint)
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
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-5 whitespace-nowrap">
                            <p class="text-xs font-bold text-gray-700">{{ $complaint->created_at->format('M d, Y') }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">{{ $complaint->created_at->format('h:i A') }}</p>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-xs font-bold text-gray-800">{{ $complaint->user_email }}</p>
                        </td>
                        <td class="px-6 py-5 max-w-xs">
                            <p class="text-xs text-gray-600 line-clamp-2" title="{{ $complaint->message }}">
                                {{ $complaint->message }}
                            </p>
                        </td>
                        <td class="px-6 py-5 max-w-xs">
                            @if($complaint->ai_summary)
                                <p class="text-[10px] text-gray-500 italic line-clamp-2" title="{{ $complaint->ai_summary }}">
                                    {{ $complaint->ai_summary }}
                                </p>
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
                                <select name="status" onchange="this.form.submit()"
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
                            <button
                                onclick="openMessageModal({{ $complaint->id }}, '{{ addslashes($complaint->user_email) }}')"
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
                    @endforeach
                </tbody>
            </table>

            @if($complaints->hasPages())
                <div class="px-6 py-4 border-t border-gray-50">
                    {{ $complaints->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

{{-- Message Complainant Modal --}}
<div id="messageModal"
     class="fixed inset-0 z-50 hidden items-center justify-center p-4"
     onclick="if(event.target===this) closeMessageModal()">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"></div>

    <div class="relative bg-white rounded-[2rem] shadow-2xl w-full max-w-xl overflow-hidden">

        {{-- Colored top bar --}}
        <div class="bg-brgyGreen px-8 py-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-white/20 rounded-2xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-extrabold text-white tracking-tight">Message Complainant</h2>
                    <p class="text-[11px] text-white/60 font-semibold mt-0.5">Send a notification directly to the resident's mobile app</p>
                </div>
            </div>
            <button onclick="closeMessageModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-xl text-white/50 hover:text-white hover:bg-white/10 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="px-8 py-7">

            {{-- Recipient badge --}}
            <div class="flex items-center gap-3 mb-6 p-4 bg-blue-50 rounded-2xl border border-blue-100">
                <div class="w-8 h-8 bg-brgyGreen rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[9px] font-black text-blue-400 uppercase tracking-widest">Sending to</p>
                    <p id="modalRecipient" class="text-sm font-bold text-brgyGreen mt-0.5"></p>
                </div>
            </div>

            <form id="messageForm" method="POST" action="">
                @csrf

                <div class="mb-5">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">
                        Your Message
                    </label>
                    <textarea id="modalTextarea"
                              name="message"
                              rows="5"
                              maxlength="1000"
                              oninput="updateCharCount(this)"
                              placeholder="Good day! We would like to schedule a meeting regarding your complaint. Please come to the Barangay Hall on [date] at [time]. Bring a valid ID."
                              class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-5 py-4 text-sm text-gray-700 focus:bg-white focus:border-brgyGreen focus:ring-4 focus:ring-brgyGreen/5 outline-none transition-all resize-none placeholder:text-gray-300 leading-relaxed"
                              required></textarea>
                    <div class="flex items-center justify-between mt-2 px-1">
                        <p class="text-[10px] text-gray-300 font-semibold flex items-center gap-1.5">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            Resident will receive a push notification on their mobile app
                        </p>
                        <span id="charCount" class="text-[10px] font-black text-gray-300">0 / 1000</span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="flex-1 bg-brgyGreen text-white font-black text-xs uppercase tracking-widest py-4 rounded-2xl shadow-lg shadow-brgyGreen/20 hover:shadow-xl hover:shadow-brgyGreen/30 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                        </svg>
                        Send Message
                    </button>
                    <button type="button" onclick="closeMessageModal()"
                            class="px-7 py-4 rounded-2xl border-2 border-gray-100 text-gray-400 text-xs font-black uppercase tracking-widest hover:border-gray-200 hover:text-gray-600 transition-all">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openMessageModal(complaintId, email) {
    document.getElementById('modalRecipient').textContent = email;
    document.getElementById('messageForm').action = '/admin/complaints/' + complaintId + '/message';
    const ta = document.getElementById('modalTextarea');
    ta.value = '';
    document.getElementById('charCount').textContent = '0 / 1000';
    const modal = document.getElementById('messageModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => ta.focus(), 100);
}
function closeMessageModal() {
    const modal = document.getElementById('messageModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
function updateCharCount(el) {
    const count = el.value.length;
    const el2 = document.getElementById('charCount');
    el2.textContent = count + ' / 1000';
    el2.className = 'text-[10px] font-black ' + (count > 900 ? 'text-red-400' : count > 700 ? 'text-amber-400' : 'text-gray-300');
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeMessageModal(); });
</script>
@endsection
