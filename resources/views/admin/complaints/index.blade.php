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
        <nav class="flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider">
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-brgyGreen transition-colors">Dashboard</a>
            <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            <span class="text-brgyGreen">Complaints</span>
        </nav>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        @php
            $cards = [
                ['label' => 'Total',    'value' => $totalComplaints,        'bg' => 'bg-gray-50',    'text' => 'text-gray-800'],
                ['label' => 'Open',     'value' => $openComplaints,         'bg' => 'bg-amber-50',   'text' => 'text-amber-700'],
                ['label' => 'Closed',   'value' => $closedComplaints,       'bg' => 'bg-green-50',   'text' => 'text-green-700'],
                ['label' => 'Critical', 'value' => $bySeverity['critical'], 'bg' => 'bg-red-50',     'text' => 'text-red-700'],
                ['label' => 'Medium',   'value' => $bySeverity['medium'],   'bg' => 'bg-orange-50',  'text' => 'text-orange-700'],
            ];
        @endphp
        @foreach($cards as $card)
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 p-5 text-center">
            <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">{{ $card['label'] }}</p>
            <div class="inline-flex items-center justify-center px-4 py-1.5 {{ $card['bg'] }} rounded-xl">
                <p class="text-2xl font-extrabold {{ $card['text'] }}">{{ $card['value'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

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
        <div class="flex items-center gap-3 mt-4">
            <button type="submit"
                    class="bg-brgyGreen text-white px-6 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-xl hover:shadow-lg hover:shadow-brgyGreen/20 transition-all">
                Filter
            </button>
            @if(request()->hasAny(['search','severity','status']))
                <a href="{{ route('admin.complaints.index') }}"
                   class="px-6 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-xl border-2 border-gray-100 text-gray-400 hover:border-gray-200 hover:text-gray-600 transition-all">
                    Clear
                </a>
            @endif
            <span class="ml-auto text-[10px] font-black text-gray-300 uppercase tracking-widest">
                {{ $complaints->total() }} {{ Str::plural('complaint', $complaints->total()) }}
            </span>
        </div>
    </form>

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
                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $statusStyle }}">
                                {{ $complaint->status ?? 'open' }}
                            </span>
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
@endsection
