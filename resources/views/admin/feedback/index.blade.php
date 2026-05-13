@extends('layouts.admin')

@section('content')
<div class="space-y-8 p-2">
    
    {{-- Page Header --}}
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 pb-2">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-2 h-8 bg-brgyGold rounded-full"></div>
                <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">Community Feedback</h1>
            </div>
            <p class="text-slate-500 text-sm font-medium ml-5">
                Sentiment analysis and resident suggestions for <span class="text-brgyGreen font-bold">Barangay 419</span>.
            </p>
        </div>
        
        <div class="flex gap-2">
            <span class="px-5 py-3 bg-white rounded-2xl shadow-sm text-[10px] font-black text-brgyGreen border-2 border-slate-100 uppercase tracking-[0.2em]">
                Live Analytics Mode
            </span>
        </div>
    </div>

    {{-- Stats Row (Matching Document Request Style) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Positive Feedback</p>
                <h3 class="text-2xl font-extrabold text-slate-800">{{ $sentimentCounts['positive'] }}%</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Neutral Sentiment</p>
                <h3 class="text-2xl font-extrabold text-slate-800">{{ $sentimentCounts['neutral'] }}%</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-500">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Negative Sentiment</p>
                <h3 class="text-2xl font-extrabold text-slate-800">{{ $sentimentCounts['negative'] }}%</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Sentiment Chart Card --}}
        <div class="lg:col-span-1 bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100 h-fit">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Visualization</h3>
            <div class="relative h-64">
                <canvas id="sentimentChart"></canvas>
            </div>
        </div>

        {{-- Feedback List Card --}}
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50 bg-slate-50/50">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Recent Comments</h3>
            </div>
            <div class="divide-y divide-slate-50">
                @foreach($feedbacks as $item)
                <div class="p-8 hover:bg-slate-50/50 transition-all group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-brgyGreen/5 flex items-center justify-center text-brgyGreen font-black text-sm border border-brgyGreen/10">
                                {{ substr($item->resident, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-800 uppercase tracking-tight group-hover:text-brgyGreen transition-colors italic">
                                    {{ $item->resident }}
                                </p>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="w-1 h-1 bg-brgyGold rounded-full"></span>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest font-mono">{{ $item->date }}</p>
                                </div>
                            </div>
                        </div>
                        <span class="px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest 
                            {{ $item->sentiment == 'positive' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : ($item->sentiment == 'negative' ? 'bg-rose-50 text-rose-600 border border-rose-100' : 'bg-amber-50 text-amber-600 border border-amber-100') }}">
                            {{ $item->sentiment }}
                        </span>
                    </div>
                    
                    <p class="text-slate-500 text-sm leading-relaxed italic ml-16 mb-6">"{{ $item->comment }}"</p>
                    
                    <div class="flex justify-end ml-16">
                        <button onclick="openReplyModal('{{ $item->resident }}', '{{ addslashes($item->comment) }}')" 
                            class="px-5 py-2.5 bg-brgyGreen/5 text-brgyGreen hover:bg-brgyGreen hover:text-white rounded-xl text-[9px] font-black uppercase tracking-[0.2em] transition-all duration-300 flex items-center gap-2 shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                            Acknowledge
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Reply Modal (Design Matched) --}}
<div id="replyModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-sm">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-[2.5rem] shadow-2xl max-w-lg w-full p-10 border border-slate-100">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center gap-3">
                    <div class="w-1.5 h-6 bg-brgyGold rounded-full"></div>
                    <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Send Reply</h3>
                </div>
                <button onclick="closeReplyModal()" class="text-slate-400 hover:text-slate-600 transition-transform hover:rotate-90 duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="mb-8 p-6 bg-slate-50/80 rounded-[2rem] border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <svg class="w-12 h-12 text-brgyGreen" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9125 16 16.0171 16H19.0171V14.5C19.0171 11.4624 16.5547 9 13.5171 9H12.0171V7H13.5171C17.6592 7 21.0171 10.3579 21.0171 14.5V21H14.0171Z"/></svg>
                </div>
                <p id="modalResident" class="text-[10px] font-black text-brgyGreen uppercase tracking-widest mb-2 font-mono"></p>
                <p id="modalComment" class="text-slate-500 text-xs italic leading-relaxed relative z-10"></p>
            </div>

            <div class="mb-8">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-3 ml-2">Message Content</label>
                <textarea rows="4" class="w-full bg-slate-50 border-2 border-slate-100 rounded-[1.5rem] p-5 text-sm font-medium focus:border-brgyGreen focus:ring-0 outline-none transition-all placeholder:text-slate-300 italic" placeholder="How would you like to respond?"></textarea>
            </div>

            <button onclick="closeReplyModal()" class="w-full py-5 bg-brgyGreen text-white rounded-[1.5rem] text-[10px] font-black uppercase tracking-[0.3em] hover:bg-darkGreen shadow-xl shadow-brgyGreen/20 transition-all active:scale-95">
                Dispatch Acknowledgment
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function openReplyModal(resident, comment) {
        document.getElementById('modalResident').innerText = 'FROM: ' + resident;
        document.getElementById('modalComment').innerText = '"' + comment + '"';
        document.getElementById('replyModal').classList.remove('hidden');
    }

    function closeReplyModal() {
        document.getElementById('replyModal').classList.add('hidden');
    }

    const ctx = document.getElementById('sentimentChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Positive', 'Neutral', 'Negative'],
            datasets: [{
                data: [{{ $sentimentCounts['positive'] }}, {{ $sentimentCounts['neutral'] }}, {{ $sentimentCounts['negative'] }}],
                backgroundColor: ['#10b981', '#f59e0b', '#f43f5e'],
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '80%',
            plugins: { legend: { display: false } }
        }
    });
</script>
@endsection