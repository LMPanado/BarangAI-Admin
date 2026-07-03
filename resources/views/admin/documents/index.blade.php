@extends('layouts.admin')

@section('content')
<div class="space-y-8 animate-fade-in max-w-[1600px] mx-auto">

    {{-- Header --}}
    <div class="flex justify-between items-center border-b border-gray-100 pb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Document Requests</h1>
            <p class="text-sm text-gray-400 font-medium mt-0.5">Barangay 419 — Certificates & Permits</p>
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
            <nav class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider">
                <span class="text-gray-300">Home</span>
                <svg class="w-3 h-3 text-gray-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                <span class="text-brgyGreen">Requests</span>
            </nav>
        </div>
    </div>

    {{-- Quick Stats --}}
    @php
        use App\Models\DocumentRequest;
        $sTotal      = DocumentRequest::count();
        $sPending    = DocumentRequest::where('status', 'pending')->count();
        $sProcessing = DocumentRequest::where('status', 'processing')->count();
        $sReady      = DocumentRequest::where('status', 'ready_for_pickup')->count();
        $sCompleted  = DocumentRequest::where('status', 'completed')->count();
    @endphp
    <div class="grid grid-cols-5 gap-4">
        @foreach([
            ['Total Requests',   $sTotal,      'text-gray-700',   'bg-gray-50',    'border-gray-100'],
            ['Pending',          $sPending,    'text-amber-600',  'bg-amber-50',   'border-amber-100'],
            ['Processing',       $sProcessing, 'text-violet-600', 'bg-violet-50',  'border-violet-100'],
            ['Ready for Pickup', $sReady,      'text-blue-600',   'bg-blue-50',    'border-blue-100'],
            ['Completed',        $sCompleted,  'text-green-600',  'bg-green-50',   'border-green-100'],
        ] as [$lbl, $val, $clr, $bg, $border])
        <div class="rounded-2xl {{ $bg }} border {{ $border }} px-5 py-4 flex items-center gap-3">
            <p class="text-2xl font-extrabold {{ $clr }}">{{ $val }}</p>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-tight">{{ $lbl }}</p>
        </div>
        @endforeach
    </div>

    {{-- Search + Sort --}}
    <div class="flex items-center gap-3">
        {{-- Search + Filters (single form) --}}
        <form action="{{ route('admin.documents.index') }}" method="GET" class="flex items-center gap-2">
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="h-3.5 w-3.5 text-gray-300 group-focus-within:text-brgyGreen transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search resident or purpose..."
                       class="pl-9 pr-4 py-2.5 text-xs font-bold border border-gray-200 rounded-xl focus:border-brgyGreen focus:ring-0 outline-none w-60 transition-all bg-white placeholder:text-gray-300 placeholder:font-medium">
            </div>

            <select name="status_filter"
                    class="text-[10px] font-black uppercase tracking-widest px-3 py-2.5 border border-gray-200 rounded-xl bg-white text-gray-500 focus:border-brgyGreen focus:ring-0 outline-none cursor-pointer">
                <option value="">All Statuses</option>
                <option value="pending"          {{ request('status_filter') === 'pending'          ? 'selected' : '' }}>Pending</option>
                <option value="processing"       {{ request('status_filter') === 'processing'       ? 'selected' : '' }}>Processing</option>
                <option value="ready_for_pickup" {{ request('status_filter') === 'ready_for_pickup' ? 'selected' : '' }}>Ready for Pick-up</option>
                <option value="completed"        {{ request('status_filter') === 'completed'        ? 'selected' : '' }}>Completed</option>
                <option value="cancelled"        {{ request('status_filter') === 'cancelled'        ? 'selected' : '' }}>Cancelled</option>
            </select>

            <input type="hidden" name="sort" value="{{ $sort }}">
            <button type="submit" class="px-4 py-2.5 bg-brgyGreen text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:shadow-md transition-all">
                Filter
            </button>
            @if(request('search') || request('status_filter'))
            <a href="{{ route('admin.documents.index', ['sort' => $sort]) }}"
               class="px-3 py-2.5 border border-gray-200 text-gray-400 text-[10px] font-black uppercase tracking-widest rounded-xl hover:text-gray-600 transition-all">
                Clear
            </a>
            @endif
        </form>

        <div class="flex items-center gap-1.5">
            @foreach([['latest','Latest'],['oldest','Oldest'],['status','By Status'],['document','By Document']] as [$val,$label])
            <a href="{{ route('admin.documents.index', array_merge(request()->except('sort'), ['sort' => $val])) }}"
               class="px-3 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all
                      {{ $sort === $val ? 'bg-brgyGreen text-white' : 'border border-gray-200 text-gray-400 hover:text-gray-600' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- MOBILE APP REQUESTS --}}
    <div>
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Mobile App Requests</h2>
            <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">{{ $mobileRequests->count() }} {{ Str::plural('entry', $mobileRequests->count()) }}</span>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <table class="w-full text-left table-fixed">
                <colgroup>
                    <col class="w-[18%]">
                    <col class="w-[14%]">
                    <col class="w-[20%]">
                    <col class="w-[13%]">
                    <col class="w-[13%]">
                    <col class="w-[12%]">
                    <col class="w-[10%]">
                </colgroup>
                <thead>
                    <tr class="border-b border-gray-50 text-gray-300 text-[10px] font-black uppercase tracking-widest">
                        <th class="px-6 py-3">Resident</th>
                        <th class="px-6 py-3">Document</th>
                        <th class="px-6 py-3">Purpose</th>
                        <th class="px-6 py-3">Date Requested</th>
                        <th class="px-6 py-3">Schedule</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($mobileRequests as $req)
                    @include('admin.documents._row', ['request' => $req, 'showVerify' => false])
                    @empty
                    <tr><td colspan="7" class="px-6 py-10 text-center text-[10px] font-black text-gray-300 uppercase tracking-widest">No mobile requests</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- WALK-IN / KIOSK REQUESTS --}}
    <div>
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Walk-in / Kiosk Requests</h2>
            <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">{{ $kioskRequests->count() }} {{ Str::plural('entry', $kioskRequests->count()) }}</span>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <table class="w-full text-left table-fixed">
                <colgroup>
                    <col class="w-[18%]">
                    <col class="w-[14%]">
                    <col class="w-[20%]">
                    <col class="w-[13%]">
                    <col class="w-[13%]">
                    <col class="w-[12%]">
                    <col class="w-[10%]">
                </colgroup>
                <thead>
                    <tr class="border-b border-gray-50 text-gray-300 text-[10px] font-black uppercase tracking-widest">
                        <th class="px-6 py-3">Resident</th>
                        <th class="px-6 py-3">Document</th>
                        <th class="px-6 py-3">Purpose</th>
                        <th class="px-6 py-3">Date Requested</th>
                        <th class="px-6 py-3">Schedule</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($kioskRequests as $req)
                    @include('admin.documents._row', ['request' => $req, 'showVerify' => true])
                    @empty
                    <tr><td colspan="7" class="px-6 py-10 text-center text-[10px] font-black text-gray-300 uppercase tracking-widest">No kiosk requests</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ═══════════════════════════════════════════
     DOCUMENT REQUEST ACTIVITY LOG (Role 1 only)
═══════════════════════════════════════════ --}}
@if(auth()->user()->role == 1)
<div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-8 py-5 border-b border-gray-50 flex items-center justify-between">
        <div>
            <h2 class="text-sm font-extrabold text-gray-800 tracking-tight">Document Request Activity Log</h2>
            <p class="text-[10px] text-gray-400 font-medium mt-0.5 uppercase tracking-widest">Last 50 actions — visible to System Admin only</p>
        </div>
        <a href="{{ route('admin.audit-logs.index') }}?subject=DocumentRequest"
           class="text-[10px] font-black text-brgyGreen uppercase tracking-widest hover:underline">
            View Full Audit Log →
        </a>
    </div>

    @if($docAuditLogs->isEmpty())
        <div class="py-16 text-center">
            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">No document activity recorded yet</p>
        </div>
    @else
    <table class="w-full">
        <thead>
            <tr class="bg-gray-50/50 border-b border-gray-50">
                <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">When</th>
                <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Staff</th>
                <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Action</th>
                <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Details</th>
                <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">IP</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
        @foreach($docAuditLogs as $log)
        @php
            $colorMap = [
                'green'  => ['bg' => 'bg-green-50',  'text' => 'text-green-700',  'dot' => 'bg-green-400'],
                'blue'   => ['bg' => 'bg-blue-50',   'text' => 'text-blue-700',   'dot' => 'bg-blue-400'],
                'red'    => ['bg' => 'bg-red-50',    'text' => 'text-red-700',    'dot' => 'bg-red-400'],
                'amber'  => ['bg' => 'bg-amber-50',  'text' => 'text-amber-700',  'dot' => 'bg-amber-400'],
                'indigo' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'dot' => 'bg-indigo-400'],
                'purple' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'dot' => 'bg-purple-400'],
                'teal'   => ['bg' => 'bg-teal-50',   'text' => 'text-teal-700',   'dot' => 'bg-teal-400'],
                'gray'   => ['bg' => 'bg-gray-50',   'text' => 'text-gray-600',   'dot' => 'bg-gray-300'],
            ];
            $c = $colorMap[$log->actionColor()];
        @endphp
        <tr class="hover:bg-gray-50/30 transition-colors">
            <td class="px-6 py-3 whitespace-nowrap">
                <p class="text-xs font-bold text-gray-700">{{ $log->created_at->format('M d, Y') }}</p>
                <p class="text-[10px] text-gray-400 mt-0.5">{{ $log->created_at->format('h:i A') }}</p>
            </td>
            <td class="px-6 py-3">
                @if($log->user)
                    <p class="text-xs font-bold text-gray-800">{{ $log->user->last_name }}, {{ $log->user->first_name }}</p>
                    <p class="text-[10px] text-gray-400 mt-0.5">{{ ['','System Admin','Barangay Captain','Barangay Official'][$log->user->role] ?? 'Staff' }}</p>
                @else
                    <span class="text-[10px] text-gray-300 italic">Deleted account</span>
                @endif
            </td>
            <td class="px-6 py-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $c['bg'] }} {{ $c['text'] }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $c['dot'] }}"></span>
                    {{ str_replace('_', ' ', $log->action) }}
                </span>
            </td>
            <td class="px-6 py-3 max-w-xs">
                <p class="text-xs font-bold text-gray-700 truncate" title="{{ $log->subject_label }}">{{ $log->subject_label }}</p>
            </td>
            <td class="px-6 py-3">
                <span class="text-[10px] font-mono text-gray-400">{{ $log->ip_address ?? '—' }}</span>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</div>
@endif

{{-- Cancellation Reason Modal --}}
<div id="cancelModal" style="display:none;position:fixed;inset:0;z-index:9999;align-items:center;justify-content:center;background:rgba(0,0,0,0.4);">
    <div style="background:#fff;border-radius:1.5rem;padding:2rem;width:100%;max-width:440px;margin:1rem;box-shadow:0 25px 50px rgba(0,0,0,0.15);">
        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.25rem;">
            <div style="width:2.5rem;height:2.5rem;border-radius:0.75rem;background:#fef2f2;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:1.25rem;height:1.25rem;color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
            </div>
            <div>
                <p style="font-size:0.875rem;font-weight:800;color:#1e293b;">Cancel Request</p>
                <p style="font-size:0.625rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.1em;">Please provide a reason for cancellation</p>
            </div>
        </div>
        <textarea id="cancelReasonText" rows="4" placeholder="e.g. Incomplete requirements, duplicate request..."
            style="width:100%;padding:0.875rem 1rem;border:2px solid #f1f5f9;border-radius:0.75rem;font-size:0.8125rem;font-weight:600;color:#334155;background:#f8fafc;resize:none;outline:none;box-sizing:border-box;"
            onfocus="this.style.borderColor='#1d4ed8';this.style.background='#fff';"
            onblur="this.style.borderColor='#f1f5f9';this.style.background='#f8fafc';"></textarea>
        <p id="cancelReasonError" style="display:none;font-size:0.625rem;font-weight:800;color:#ef4444;text-transform:uppercase;letter-spacing:0.1em;margin-top:0.5rem;">Reason is required.</p>
        <div style="display:flex;gap:0.75rem;margin-top:1.25rem;">
            <button onclick="closeCancelModal()"
                style="flex:1;padding:0.75rem;border-radius:0.75rem;border:2px solid #f1f5f9;background:#fff;font-size:0.625rem;font-weight:800;text-transform:uppercase;letter-spacing:0.1em;color:#64748b;cursor:pointer;">
                Go Back
            </button>
            <button onclick="submitCancellation()"
                style="flex:1;padding:0.75rem;border-radius:0.75rem;border:none;background:#ef4444;color:#fff;font-size:0.625rem;font-weight:800;text-transform:uppercase;letter-spacing:0.1em;cursor:pointer;">
                Confirm Cancel
            </button>
        </div>
    </div>
</div>

<script>
let _cancelFormId = null;
let _cancelSelectEl = null;
let _cancelPrevValue = null;

function handleStatusChange(selectEl, formId) {
    if (selectEl.value === 'cancelled') {
        _cancelFormId = formId;
        _cancelSelectEl = selectEl;
        _cancelPrevValue = Array.from(selectEl.options).find(o => o.defaultSelected)?.value ?? 'pending';
        document.getElementById('cancelReasonText').value = '';
        document.getElementById('cancelReasonError').style.display = 'none';
        document.getElementById('cancelModal').style.display = 'flex';
    } else {
        selectEl.form.submit();
    }
}

function closeCancelModal() {
    document.getElementById('cancelModal').style.display = 'none';
    if (_cancelSelectEl) {
        _cancelSelectEl.value = _cancelPrevValue;
    }
    _cancelFormId = null;
    _cancelSelectEl = null;
}

function submitCancellation() {
    const reason = document.getElementById('cancelReasonText').value.trim();
    if (!reason) {
        document.getElementById('cancelReasonError').style.display = 'block';
        return;
    }
    document.getElementById('cancelReasonError').style.display = 'none';
    document.getElementById('cancel-reason-input-' + _cancelFormId).value = reason;
    document.getElementById('status-form-' + _cancelFormId).submit();
    document.getElementById('cancelModal').style.display = 'none';
}

// Close modal on backdrop click
document.getElementById('cancelModal').addEventListener('click', function(e) {
    if (e.target === this) closeCancelModal();
});
</script>
@endsection
