@extends('layouts.admin')

@section('content')
<div class="space-y-8 p-4">
    {{-- Page Header --}}
    <div class="flex justify-between items-center border-b border-gray-100 pb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Document Requests</h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">Manage and process resident document applications.</p>
        </div>
        {{-- Counter Badge --}}
        <div class="bg-amber-50 border border-amber-100 px-4 py-2 rounded-2xl">
            <span class="text-amber-600 text-[10px] font-black uppercase tracking-widest">Pending: </span>
            <span class="text-amber-700 font-bold">{{ $requests->where('status', 'pending')->count() }}</span>
        </div>
    </div>

    {{-- Table Container --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-50">
                <tr>
                    <th class="px-8 py-5">Resident Name</th>
                    <th class="px-8 py-5">Document Type</th>
                    <th class="px-8 py-5">Purpose</th>
                    <th class="px-8 py-5">Target Pickup</th>
                    <th class="px-8 py-5">Status</th>
                    <th class="px-8 py-5 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($requests as $request)
                <tr class="hover:bg-slate-50/30 transition-all group">
                    <td class="px-8 py-6">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-slate-700">
                                @if($request->resident)
                                    {{ $request->resident->first_name }} {{ $request->resident->last_name }}
                                @else
                                    <span class="text-red-400 italic font-medium text-xs">Resident Deleted</span>
                                @endif
                            </span>
                            <span class="text-[10px] text-slate-400 font-medium tracking-tight">ID: #{{ str_pad($request->resident_id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="text-[11px] font-black text-emerald-700 bg-emerald-50 px-3 py-1 rounded-lg uppercase tracking-wider">
                            {{ str_replace('_', ' ', $request->document_type) }}
                        </span>
                    </td>
                    <td class="px-8 py-6 text-xs text-slate-500 italic max-w-[200px]">
                        "{{ $request->purpose }}"
                    </td>
                    <td class="px-8 py-6 text-sm font-semibold text-slate-600">
                        {{ \Carbon\Carbon::parse($request->pickup_date)->format('M d, Y') }}
                    </td>
                    <td class="px-8 py-6">
                        <form action="{{ route('admin.documents.updateStatus', $request->id) }}" method="POST" class="status-form">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="updateStatusStyle(this); this.form.submit()" 
                                class="status-select text-[9px] font-black uppercase tracking-widest px-3 py-1.5 rounded-full border-none cursor-pointer transition-colors
                                {{ $request->status == 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                                {{ $request->status == 'ready' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $request->status == 'issued' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $request->status == 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                                <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="ready" {{ $request->status == 'ready' ? 'selected' : '' }}>Ready</option>
                                <option value="issued" {{ $request->status == 'issued' ? 'selected' : '' }}>Issued</option>
                                <option value="cancelled" {{ $request->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-8 py-6 text-right">
                        {{-- FIXED ACTION BUTTON: Changed to standard Tailwind emerald color for reliability --}}
                        <a href="{{ route('admin.documents.issuance', $request->id) }}" 
                           class="inline-flex items-center px-6 py-2.5 bg-emerald-700 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-800 hover:text-white hover:shadow-lg hover:shadow-emerald-900/20 transition-all active:scale-95 border-none">
                            Process Issuance
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <span class="text-4xl mb-4 text-slate-300">📂</span>
                            <p class="text-slate-400 font-bold uppercase text-xs tracking-widest">No document requests found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function updateStatusStyle(select) {
        select.classList.remove('bg-amber-100', 'text-amber-700', 'bg-blue-100', 'text-blue-700', 'bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700');
        
        if (select.value === 'pending') select.classList.add('bg-amber-100', 'text-amber-700');
        if (select.value === 'ready') select.classList.add('bg-blue-100', 'text-blue-700');
        if (select.value === 'issued') select.classList.add('bg-green-100', 'text-green-700');
        if (select.value === 'cancelled') select.classList.add('bg-red-100', 'text-red-700');
    }
</script>
@endsection