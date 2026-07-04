@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="space-y-8 pb-12 max-w-[1600px] mx-auto">

    {{-- Header --}}
    <div class="flex justify-between items-center border-b border-gray-100 pb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Community Feedback</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium italic">
                Resident sentiment and suggestions for <span class="text-brgyGreen font-bold not-italic">Barangay 419</span>.
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
                <span class="text-brgyGreen">Feedback</span>
            </nav>
        </div>
    </div>

    {{-- Top Row: Sentiment Chart + Stats --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Doughnut Chart --}}
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 flex flex-col items-center justify-center">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-6 self-start">Sentiment Breakdown</p>
            @php
                $chartTotal = $sentimentCounts['positive'] + $sentimentCounts['neutral'] + $sentimentCounts['negative'];
            @endphp
            @if($chartTotal > 0)
                <div class="relative h-48 w-48">
                    <canvas id="sentimentChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <p class="text-2xl font-extrabold text-gray-800">{{ $total }}</p>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Total</p>
                    </div>
                </div>
                <div class="flex items-center justify-center gap-6 mt-6">
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-emerald-400"></div>
                        <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Positive</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-amber-400"></div>
                        <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Neutral</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-rose-400"></div>
                        <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Negative</span>
                    </div>
                </div>
            @else
                <div class="flex flex-col items-center justify-center h-48 text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-7 h-7 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">No sentiment data yet</p>
                </div>
            @endif
        </div>

        {{-- Sentiment Count Cards --}}
        <div class="lg:col-span-2 grid grid-cols-2 gap-4">
            @php
                $sentCards = [
                    ['label'=>'Total Feedback', 'value'=>$total,                          'icon'=>'M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'bg'=>'bg-gray-50',   'icon_color'=>'text-gray-400',  'num'=>'text-gray-800'],
                    ['label'=>'Positive',       'value'=>$sentimentCounts['positive'],    'icon'=>'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'bg'=>'bg-emerald-50', 'icon_color'=>'text-emerald-500','num'=>'text-emerald-700'],
                    ['label'=>'Neutral',        'value'=>$sentimentCounts['neutral'],     'icon'=>'M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'bg'=>'bg-amber-50',  'icon_color'=>'text-amber-500', 'num'=>'text-amber-700'],
                    ['label'=>'Negative',       'value'=>$sentimentCounts['negative'],    'icon'=>'M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'bg'=>'bg-rose-50',   'icon_color'=>'text-rose-500',  'num'=>'text-rose-700'],
                ];
            @endphp
            @foreach($sentCards as $card)
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6 flex items-center gap-4">
                <div class="p-3 {{ $card['bg'] }} rounded-2xl shrink-0">
                    <svg class="w-5 h-5 {{ $card['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em]">{{ $card['label'] }}</p>
                    <p class="text-2xl font-extrabold {{ $card['num'] }} tracking-tight mt-1">{{ $card['value'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('admin.feedback.index') }}"
          class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by email or message..."
                   class="bg-gray-50 border-2 border-gray-100 rounded-2xl px-5 py-3 text-sm font-bold text-gray-700 focus:bg-white focus:border-brgyGreen focus:ring-4 focus:ring-brgyGreen/5 outline-none transition-all placeholder:text-gray-300">

            <select name="sentiment"
                    class="bg-gray-50 border-2 border-gray-100 rounded-2xl px-5 py-3 text-sm font-bold text-gray-700 focus:bg-white focus:border-brgyGreen outline-none transition-all">
                <option value="">All Sentiments</option>
                <option value="positive" {{ request('sentiment') === 'positive' ? 'selected' : '' }}>Positive</option>
                <option value="neutral"  {{ request('sentiment') === 'neutral'  ? 'selected' : '' }}>Neutral</option>
                <option value="negative" {{ request('sentiment') === 'negative' ? 'selected' : '' }}>Negative</option>
            </select>
        </div>
        <div class="flex items-center gap-3 mt-4">
            <button type="submit"
                    class="bg-brgyGreen text-white px-6 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-xl hover:shadow-lg hover:shadow-brgyGreen/20 transition-all">
                Filter
            </button>
            @if(request()->hasAny(['search','sentiment']))
                <a href="{{ route('admin.feedback.index') }}"
                   class="px-6 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-xl border-2 border-gray-100 text-gray-400 hover:border-gray-200 hover:text-gray-600 transition-all">
                    Clear
                </a>
            @endif
            <span class="ml-auto text-[10px] font-black text-gray-300 uppercase tracking-widest">
                {{ $feedbacks->total() }} {{ Str::plural('entry', $feedbacks->total()) }}
            </span>
        </div>
    </form>

    {{-- Feedback List --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        @if($feedbacks->isEmpty())
            <div class="py-24 text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                </div>
                <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">No feedback found</p>
            </div>
        @else
            <div class="divide-y divide-gray-50">
                @foreach($feedbacks as $item)
                @php
                    $sentStyle = match($item->sentiment) {
                        'positive' => ['badge' => 'bg-emerald-50 text-emerald-700', 'dot' => 'bg-emerald-400', 'initial' => 'bg-emerald-50 text-emerald-700'],
                        'negative' => ['badge' => 'bg-rose-50 text-rose-700',     'dot' => 'bg-rose-400',    'initial' => 'bg-rose-50 text-rose-700'],
                        'neutral'  => ['badge' => 'bg-amber-50 text-amber-700',   'dot' => 'bg-amber-400',   'initial' => 'bg-amber-50 text-amber-700'],
                        default    => ['badge' => 'bg-gray-50 text-gray-500',     'dot' => 'bg-gray-300',    'initial' => 'bg-gray-50 text-gray-500'],
                    };
                @endphp
                <div class="p-6 hover:bg-gray-50/40 transition-colors" id="feedback-item-{{ $item->id }}">
                    <div class="flex items-start gap-4">
                        {{-- Avatar --}}
                        <div class="w-10 h-10 rounded-2xl {{ $sentStyle['initial'] }} flex items-center justify-center font-black text-sm shrink-0">
                            {{ strtoupper(substr($item->user_email, 0, 1)) }}
                        </div>

                        <div class="flex-1 min-w-0">
                            {{-- Top row: email + badges + reply button --}}
                            <div class="flex items-center justify-between gap-4 mb-2 flex-wrap">
                                <div>
                                    <p class="text-xs font-bold text-gray-800">{{ $item->user_email }}</p>
                                    <p class="text-[10px] text-gray-400 font-medium mt-0.5">
                                        {{ $item->created_at ? $item->created_at->timezone('Asia/Manila')->format('M d, Y · h:i A') : '—' }}
                                        @if($item->category)
                                            · <span class="text-brgyGreen font-bold uppercase">{{ $item->category }}</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    @if($item->sentiment)
                                        <span class="flex items-center gap-1.5 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $sentStyle['badge'] }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $sentStyle['dot'] }}"></span>
                                            {{ $item->sentiment }}
                                        </span>
                                    @endif
                                    @if($item->sentiment_score !== null)
                                        <span class="text-[10px] font-black text-gray-400">Score: {{ number_format($item->sentiment_score, 2) }}</span>
                                    @endif

                                    {{-- Replied badge OR reply button --}}
                                    @if($item->admin_reply)
                                        <span class="flex items-center gap-1.5 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-brgyGreen/10 text-brgyGreen">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            Replied
                                        </span>
                                    @endif
                                    <button onclick="toggleReply({{ $item->id }})"
                                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest border-2 transition-all
                                                   {{ $item->admin_reply ? 'border-gray-100 text-gray-400 hover:border-gray-200 hover:text-gray-600' : 'border-brgyGreen/20 text-brgyGreen bg-brgyGreen/5 hover:bg-brgyGreen hover:text-white hover:border-brgyGreen' }}">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                        </svg>
                                        {{ $item->admin_reply ? 'Edit Reply' : 'Reply' }}
                                    </button>

                                    @if(auth()->user()->role == 2)
                                    <form id="del-feedback-{{ $item->id }}" action="{{ route('admin.feedback.destroy', $item->id) }}" method="POST" class="hidden">
                                        @csrf @method('DELETE')
                                    </form>
                                    <button onclick="confirmDelete('del-feedback-{{ $item->id }}', 'Delete feedback from {{ addslashes($item->user_email) }}? This cannot be undone.')"
                                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest border-2 border-red-100 text-red-400 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Delete
                                    </button>
                                    @endif
                                </div>
                            </div>

                            {{-- Message --}}
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $item->message }}</p>

                            {{-- AI Summary --}}
                            @if($item->ai_summary)
                            <div class="mt-3 flex items-start gap-2 p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <svg class="w-3.5 h-3.5 text-brgyGreen mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                <p class="text-[10px] text-gray-500 italic leading-relaxed">{{ $item->ai_summary }}</p>
                            </div>
                            @endif

                            {{-- Existing reply display --}}
                            @if($item->admin_reply)
                            <div class="mt-3 flex items-start gap-3 p-4 bg-brgyGreen/5 rounded-2xl border border-brgyGreen/10"
                                 id="reply-display-{{ $item->id }}">
                                <div class="w-7 h-7 rounded-xl bg-brgyGreen flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-2 mb-1">
                                        <p class="text-[9px] font-black text-brgyGreen uppercase tracking-widest">Barangay 419 Reply</p>
                                        <p class="text-[9px] text-gray-400 font-medium">
                                            {{ $item->replied_by ?? 'Admin' }} · {{ $item->replied_at ? $item->replied_at->timezone('Asia/Manila')->format('M d, Y · h:i A') : '' }}
                                        </p>
                                    </div>
                                    <p class="text-sm text-gray-700 leading-relaxed" id="reply-text-{{ $item->id }}">{{ $item->admin_reply }}</p>
                                </div>
                            </div>
                            @endif

                            {{-- Reply Form (hidden by default) --}}
                            <div id="reply-form-{{ $item->id }}" class="hidden mt-3">
                                {{-- Quick reply chips --}}
                                <div class="flex flex-wrap gap-2 mb-3">
                                    @foreach([
                                        'Thank you for your feedback! — Barangay 419',
                                        'Noted. We appreciate you letting us know.',
                                        'Your feedback has been received. We will look into this.',
                                        'Thank you! We are working on improvements based on your input.',
                                    ] as $quick)
                                    <button type="button"
                                            onclick="setQuickReply({{ $item->id }}, '{{ addslashes($quick) }}')"
                                            class="px-3 py-1.5 text-[9px] font-bold uppercase tracking-widest rounded-xl bg-gray-50 text-gray-500 border border-gray-100 hover:border-brgyGreen/30 hover:bg-brgyGreen/5 hover:text-brgyGreen transition-all">
                                        {{ $quick }}
                                    </button>
                                    @endforeach
                                </div>

                                {{-- Text area --}}
                                <textarea id="reply-textarea-{{ $item->id }}"
                                          rows="3"
                                          placeholder="Write a reply to {{ $item->user_email }}..."
                                          class="w-full bg-white border-2 border-gray-100 rounded-2xl px-4 py-3 text-sm text-gray-700 font-medium focus:border-brgyGreen focus:ring-4 focus:ring-brgyGreen/5 outline-none transition-all resize-none placeholder:text-gray-300">{{ $item->admin_reply ?? '' }}</textarea>

                                <div class="flex items-center gap-3 mt-3">
                                    <button onclick="submitReply({{ $item->id }}, '{{ route('admin.feedback.reply', $item->id) }}')"
                                            class="px-5 py-2.5 bg-brgyGreen text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:shadow-lg hover:shadow-brgyGreen/20 transition-all">
                                        Send Reply
                                    </button>
                                    <button type="button" onclick="toggleReply({{ $item->id }})"
                                            class="px-5 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-xl border-2 border-gray-100 text-gray-400 hover:border-gray-200 hover:text-gray-600 transition-all">
                                        Cancel
                                    </button>
                                    <span id="reply-status-{{ $item->id }}" class="text-[10px] font-black text-brgyGreen hidden ml-auto">
                                        ✓ Reply saved
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($feedbacks->hasPages())
                <div class="px-6 py-4 border-t border-gray-50">
                    {{ $feedbacks->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

<script>
function toggleReply(id) {
    const form = document.getElementById('reply-form-' + id);
    form.classList.toggle('hidden');
    if (!form.classList.contains('hidden')) {
        document.getElementById('reply-textarea-' + id).focus();
    }
}

function setQuickReply(id, text) {
    document.getElementById('reply-textarea-' + id).value = text;
}

function submitReply(id, url) {
    const textarea = document.getElementById('reply-textarea-' + id);
    const reply = textarea.value.trim();
    if (!reply) { textarea.focus(); return; }

    const btn = event.target;
    btn.disabled = true;
    btn.innerText = 'Sending...';

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ reply }),
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) throw new Error('Failed');

        // Update or create the reply display block
        let display = document.getElementById('reply-display-' + id);
        if (display) {
            document.getElementById('reply-text-' + id).innerText = data.reply;
        } else {
            display = document.createElement('div');
            display.id = 'reply-display-' + id;
            display.className = 'mt-3 flex items-start gap-3 p-4 bg-brgyGreen/5 rounded-2xl border border-brgyGreen/10';
            display.innerHTML = `
                <div class="w-7 h-7 rounded-xl bg-brgyGreen flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2 mb-1">
                        <p class="text-[9px] font-black text-brgyGreen uppercase tracking-widest">Barangay 419 Reply</p>
                        <p class="text-[9px] text-gray-400 font-medium">${data.replied_by} · ${data.replied_at}</p>
                    </div>
                    <p class="text-sm text-gray-700 leading-relaxed" id="reply-text-${id}">${data.reply}</p>
                </div>`;
            document.getElementById('reply-form-' + id).before(display);
        }

        // Show status, hide form, update reply button
        document.getElementById('reply-status-' + id).classList.remove('hidden');
        document.getElementById('reply-form-' + id).classList.add('hidden');

        // Update the reply button label
        const replyBtn = document.querySelector(`#feedback-item-${id} button[onclick="toggleReply(${id})"]`);
        if (replyBtn) {
            replyBtn.innerHTML = replyBtn.innerHTML.replace('Reply', 'Edit Reply');
            replyBtn.className = replyBtn.className
                .replace('border-brgyGreen/20 text-brgyGreen bg-brgyGreen/5 hover:bg-brgyGreen hover:text-white hover:border-brgyGreen', '')
                + ' border-gray-100 text-gray-400 hover:border-gray-200 hover:text-gray-600';
        }

        setTimeout(() => document.getElementById('reply-status-' + id)?.classList.add('hidden'), 3000);
    })
    .catch(() => alert('Something went wrong. Please try again.'))
    .finally(() => { btn.disabled = false; btn.innerText = 'Send Reply'; });
}
</script>

<script>
@if(($sentimentCounts['positive'] + $sentimentCounts['neutral'] + $sentimentCounts['negative']) > 0)
new Chart(document.getElementById('sentimentChart'), {
    type: 'doughnut',
    data: {
        labels: ['Positive', 'Neutral', 'Negative'],
        datasets: [{
            data: [
                {{ $sentimentCounts['positive'] }},
                {{ $sentimentCounts['neutral'] }},
                {{ $sentimentCounts['negative'] }}
            ],
            backgroundColor: ['#34d399', '#fbbf24', '#fb7185'],
            borderWidth: 0,
            hoverOffset: 8,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '75%',
        plugins: { legend: { display: false }, tooltip: {
            callbacks: {
                label: ctx => ` ${ctx.label}: ${ctx.parsed} (${Math.round(ctx.parsed / {{ $sentimentCounts['positive'] + $sentimentCounts['neutral'] + $sentimentCounts['negative'] }} * 100)}%)`
            }
        }}
    }
});
@endif

// Smart auto-refresh: only reload when new feedback arrives
(function () {
    let since = Math.floor(Date.now() / 1000);
    setInterval(() => {
        const openReply = document.querySelector('[id^="reply-form-"]:not(.hidden)');
        if (openReply) return; // don't interrupt an open reply form
        fetch('/admin/poll?since=' + since, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            credentials: 'same-origin'
        })
        .then(r => r.ok ? r.json() : null)
        .then(data => {
            if (data && data.feedback > 0) location.reload();
            else since = Math.floor(Date.now() / 1000);
        })
        .catch(() => {});
    }, 10000);
})();
</script>
@endsection
