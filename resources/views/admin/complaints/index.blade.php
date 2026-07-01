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
                                onclick="openChat({{ $complaint->id }}, '{{ addslashes($complaint->user_email) }}')"
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

{{-- Chat Widget (bottom-right) --}}
<div id="chatModal" style="display:none;position:fixed;bottom:24px;right:24px;z-index:9999;width:360px;height:500px;border-radius:20px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.18),0 4px 20px rgba(0,0,0,0.1);display:none;flex-direction:column;background:#fff;">

    {{-- Header --}}
    <div style="background:#1d4ed8;padding:14px 16px;display:flex;align-items:center;gap:10px;flex-shrink:0;">
        <div style="width:34px;height:34px;background:rgba(255,255,255,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
        </div>
        <div style="flex:1;min-width:0;">
            <p style="font-size:9px;font-weight:800;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:.12em;margin:0;">Complaint Chat</p>
            <p id="chatEmail" style="font-size:12px;font-weight:700;color:#fff;margin:1px 0 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"></p>
        </div>
        <button onclick="closeChat()" style="width:28px;height:28px;border-radius:8px;border:none;background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.6);cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:background .15s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- Original complaint strip --}}
    <div style="padding:8px 14px;background:#f8fafc;border-bottom:1px solid #f1f5f9;flex-shrink:0;">
        <p style="font-size:8px;font-weight:900;color:#94a3b8;text-transform:uppercase;letter-spacing:.12em;margin:0 0 2px;">Original Complaint</p>
        <p id="chatComplaintText" style="font-size:11px;color:#64748b;margin:0;line-height:1.4;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;"></p>
    </div>

    {{-- Messages --}}
    <div id="chatMessages" style="flex:1;overflow-y:auto;padding:12px 12px;display:flex;flex-direction:column;gap:8px;background:#f8fafc;">
        <div id="chatLoading" style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:100%;gap:10px;">
            <div style="width:24px;height:24px;border:2px solid #e2e8f0;border-top-color:#1d4ed8;border-radius:50%;animation:spin .7s linear infinite;"></div>
            <p style="font-size:9px;font-weight:700;color:#cbd5e1;text-transform:uppercase;letter-spacing:.1em;margin:0;">Loading...</p>
        </div>
        <div id="chatEmpty" style="display:none;flex-direction:column;align-items:center;justify-content:center;height:100%;text-align:center;">
            <svg width="36" height="36" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" style="margin-bottom:8px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <p style="font-size:12px;font-weight:700;color:#94a3b8;margin:0;">No messages yet</p>
            <p style="font-size:10px;color:#cbd5e1;margin:3px 0 0;">Start the conversation below</p>
        </div>
    </div>

    {{-- Input --}}
    <div style="padding:10px 12px;background:#fff;border-top:1px solid #f1f5f9;flex-shrink:0;">
        <div style="display:flex;align-items:flex-end;gap:8px;">
            <textarea id="chatInput" rows="2" maxlength="1000" placeholder="Type a message…" onkeydown="handleChatKey(event)"
                      style="flex:1;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:14px;padding:8px 12px;font-size:12px;color:#334155;resize:none;outline:none;line-height:1.5;font-family:inherit;transition:border-color .15s;"
                      onfocus="this.style.borderColor='#1d4ed8'" onblur="this.style.borderColor='#e2e8f0'"></textarea>
            <button onclick="sendChatMessage()" id="chatSendBtn"
                    style="width:36px;height:36px;background:#1d4ed8;border:none;border-radius:10px;display:flex;align-items:center;justify-content:center;cursor:pointer;flex-shrink:0;align-self:flex-end;transition:opacity .15s;"
                    onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="#fff"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
            </button>
        </div>
        <p style="font-size:9px;color:#cbd5e1;text-align:center;margin:6px 0 0;">Enter to send &nbsp;·&nbsp; Shift+Enter for new line</p>
    </div>
</div>

<style>
@keyframes spin { to { transform: rotate(360deg); } }
</style>

<script>
let currentComplaintId = null;
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

function openChat(complaintId, email) {
    currentComplaintId = complaintId;
    document.getElementById('chatEmail').textContent = email;
    document.getElementById('chatComplaintText').textContent = '';
    document.getElementById('chatMessages').querySelectorAll('.chat-bubble').forEach(el => el.remove());
    document.getElementById('chatLoading').style.display = 'flex';
    document.getElementById('chatEmpty').style.display = 'none';
    document.getElementById('chatInput').value = '';
    const modal = document.getElementById('chatModal');
    modal.style.display = 'flex';
    modal.style.flexDirection = 'column';
    loadMessages(complaintId);
}

function closeChat() {
    document.getElementById('chatModal').style.display = 'none';
    currentComplaintId = null;
}

function loadMessages(complaintId) {
    fetch('/admin/complaints/' + complaintId + '/messages', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById('chatLoading').style.display = 'none';
        document.getElementById('chatComplaintText').textContent = data.complaint.message;
        document.getElementById('chatMessages').querySelectorAll('.chat-bubble').forEach(el => el.remove());

        if (data.messages.length === 0) {
            document.getElementById('chatEmpty').style.display = 'flex';
        } else {
            data.messages.forEach(msg => appendBubble(msg));
        }
        scrollToBottom();
    })
    .catch(() => { document.getElementById('chatLoading').style.display = 'none'; });
}

function appendBubble(msg) {
    document.getElementById('chatEmpty').style.display = 'none';
    const isAdmin = msg.sender_type === 'admin';
    const container = document.getElementById('chatMessages');

    const wrapper = document.createElement('div');
    wrapper.className = 'chat-bubble';
    wrapper.style.cssText = 'display:flex;' + (isAdmin ? 'justify-content:flex-end' : 'justify-content:flex-start');

    const inner = document.createElement('div');
    inner.style.cssText = 'max-width:78%;display:flex;flex-direction:column;gap:3px;' + (isAdmin ? 'align-items:flex-end' : 'align-items:flex-start');

    const label = document.createElement('p');
    label.style.cssText = 'font-size:9px;font-weight:900;text-transform:uppercase;letter-spacing:.1em;padding:0 4px;color:' + (isAdmin ? '#1d4ed8' : '#94a3b8');
    label.textContent = isAdmin ? (msg.sender_name || 'Admin') : 'Resident';

    const box = document.createElement('div');
    box.style.cssText = 'padding:10px 14px;border-radius:16px;font-size:13px;line-height:1.5;word-break:break-word;' +
        (isAdmin
            ? 'background:#1d4ed8;color:#fff;border-bottom-right-radius:4px'
            : 'background:#fff;color:#334155;border:1px solid #e2e8f0;border-bottom-left-radius:4px;box-shadow:0 1px 3px rgba(0,0,0,.06)');
    box.textContent = msg.message;

    const time = document.createElement('p');
    time.style.cssText = 'font-size:9px;color:#94a3b8;padding:0 4px;' + (isAdmin ? 'text-align:right' : 'text-align:left');
    time.textContent = msg.created_at;

    inner.appendChild(label);
    inner.appendChild(box);
    inner.appendChild(time);
    wrapper.appendChild(inner);
    container.appendChild(wrapper);
}

function scrollToBottom() {
    const c = document.getElementById('chatMessages');
    c.scrollTop = c.scrollHeight;
}

function sendChatMessage() {
    const input = document.getElementById('chatInput');
    const text = input.value.trim();
    if (!text || !currentComplaintId) return;

    document.getElementById('chatSendBtn').disabled = true;

    fetch('/admin/complaints/' + currentComplaintId + '/message', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest' },
        body: JSON.stringify({ message: text }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) { input.value = ''; loadMessages(currentComplaintId); }
    })
    .finally(() => { document.getElementById('chatSendBtn').disabled = false; input.focus(); });
}

function handleChatKey(e) {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendChatMessage(); }
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeChat(); });
</script>
@endsection
