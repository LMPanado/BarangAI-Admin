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
    <tbody class="divide-y divide-gray-50" id="complaints-tbody-{{ $tbodyId ?? 'default' }}">
        @foreach($complaints as $complaint)
            @include('admin.complaints._row', ['complaint' => $complaint, 'messageCounts' => $messageCounts])
        @endforeach
    </tbody>
</table>
