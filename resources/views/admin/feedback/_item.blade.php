@php
    $sentStyle = match($item->sentiment) {
        'positive' => ['badge' => 'bg-emerald-50 text-emerald-700', 'dot' => 'bg-emerald-400', 'initial' => 'bg-emerald-50 text-emerald-700'],
        'negative' => ['badge' => 'bg-rose-50 text-rose-700',       'dot' => 'bg-rose-400',    'initial' => 'bg-rose-50 text-rose-700'],
        'neutral'  => ['badge' => 'bg-amber-50 text-amber-700',     'dot' => 'bg-amber-400',   'initial' => 'bg-amber-50 text-amber-700'],
        default    => ['badge' => 'bg-gray-50 text-gray-500',       'dot' => 'bg-gray-300',    'initial' => 'bg-gray-50 text-gray-500'],
    };
@endphp
<div class="p-6 hover:bg-gray-50/40 transition-colors" id="feedback-item-{{ $item->id }}">
    <div class="flex items-start gap-4">
        <div class="w-10 h-10 rounded-2xl {{ $sentStyle['initial'] }} flex items-center justify-center font-black text-sm shrink-0">
            {{ strtoupper(substr($item->user_email, 0, 1)) }}
        </div>
        <div class="flex-1 min-w-0">
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
            <p class="text-sm text-gray-600 leading-relaxed">{{ $item->message }}</p>
            @if($item->ai_summary)
            <div class="mt-3 flex items-start gap-2 p-3 bg-gray-50 rounded-xl border border-gray-100">
                <svg class="w-3.5 h-3.5 text-brgyGreen mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                <p class="text-[10px] text-gray-500 italic leading-relaxed">{{ $item->ai_summary }}</p>
            </div>
            @endif
            @if($item->admin_reply)
            <div class="mt-3 flex items-start gap-3 p-4 bg-brgyGreen/5 rounded-2xl border border-brgyGreen/10" id="reply-display-{{ $item->id }}">
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
            <div id="reply-form-{{ $item->id }}" class="hidden mt-3">
                <div class="flex flex-wrap gap-2 mb-3">
                    @foreach([
                        'Thank you for your feedback! — Barangay 419',
                        'Noted. We appreciate you letting us know.',
                        'Your feedback has been received. We will look into this.',
                        'Thank you! We are working on improvements based on your input.',
                    ] as $quick)
                    <button type="button" onclick="setQuickReply({{ $item->id }}, '{{ addslashes($quick) }}')"
                            class="px-3 py-1.5 text-[9px] font-bold uppercase tracking-widest rounded-xl bg-gray-50 text-gray-500 border border-gray-100 hover:border-brgyGreen/30 hover:bg-brgyGreen/5 hover:text-brgyGreen transition-all">
                        {{ $quick }}
                    </button>
                    @endforeach
                </div>
                <textarea id="reply-textarea-{{ $item->id }}" rows="3"
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
                    <span id="reply-status-{{ $item->id }}" class="text-[10px] font-black text-brgyGreen hidden ml-auto">✓ Reply saved</span>
                </div>
            </div>
        </div>
    </div>
</div>
