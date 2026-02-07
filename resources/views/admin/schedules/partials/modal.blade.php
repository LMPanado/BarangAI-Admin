{{-- Modal --}}
<div id="scheduleModal" class="fixed inset-0 bg-slate-900/50 hidden items-center justify-center z-50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
        <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="font-bold text-gray-700">Add New Event</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-lg">✕</button>
        </div>
        
        <form action="{{ route('admin.schedules.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Selected Date</label>
                <input type="date" name="schedule_date" id="modal_date" class="w-full border border-gray-200 rounded-md p-2.5 text-sm bg-gray-50 font-bold text-gray-700 focus:outline-none" readonly>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Event Title</label>
                <input type="text" name="title" placeholder="e.g. Community Cleanup" class="w-full border border-gray-200 rounded-md p-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Time From</label>
                    <input type="time" name="schedule_time" class="w-full border border-gray-200 rounded-md p-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Time To</label>
                    <input type="time" name="schedule_time_to" class="w-full border border-gray-200 rounded-md p-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none" required>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-md hover:bg-blue-700 transition-all shadow-lg active:scale-95">
                    Save Schedule
                </button>
            </div>
        </form>
    </div>
</div>