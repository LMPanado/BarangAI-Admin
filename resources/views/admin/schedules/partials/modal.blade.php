{{-- Modal --}}
<div id="scheduleModal" class="fixed inset-0 bg-slate-900/60 hidden items-center justify-center z-50 backdrop-blur-md p-4 transition-all duration-300">
    <div class="bg-white rounded-[2.5rem] shadow-[0_20px_60px_rgba(0,0,0,0.15)] w-full max-w-md overflow-hidden transform transition-all border border-slate-100">
        
        {{-- Modal Header --}}
        <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <div>
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Add New Event</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Barangay 419 Operations</p>
            </div>
            <button onclick="closeModal()" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-red-500 hover:border-red-100 transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <form action="{{ route('admin.schedules.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            {{-- Selected Date (Read Only Style) --}}
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Selected Date</label>
                <div class="relative">
                    <input type="date" name="schedule_date" id="modal_date" 
                           class="w-full bg-slate-100 border-2 border-slate-100 rounded-2xl px-5 py-3.5 text-sm font-black text-slate-500 cursor-not-allowed outline-none" 
                           readonly>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Event Title --}}
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Event Title</label>
                <input type="text" name="title" placeholder="e.g. Community Cleanup Drive" 
                       class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3.5 text-sm font-bold text-slate-700 focus:bg-white focus:border-barangayGreen focus:ring-0 outline-none transition-all placeholder:text-slate-300" 
                       required>
            </div>
            
            {{-- Time Grid --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Time From</label>
                    <input type="time" name="schedule_time" 
                           class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3.5 text-sm font-bold text-slate-700 focus:bg-white focus:border-barangayGreen focus:ring-0 outline-none transition-all" 
                           required>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Time To</label>
                    <input type="time" name="schedule_time_to" 
                           class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3.5 text-sm font-bold text-slate-700 focus:bg-white focus:border-barangayGreen focus:ring-0 outline-none transition-all" 
                           required>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="pt-4">
                <button type="submit" 
                        class="w-full bg-barangayGreen text-white text-xs font-black uppercase tracking-widest py-4 rounded-2xl shadow-lg shadow-barangayGreen/20 hover:bg-barangayDark hover:shadow-none transition-all active:scale-95 flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                    Save Schedule
                </button>
                <button type="button" onclick="closeModal()" 
                        class="w-full mt-3 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] hover:text-slate-600 transition-colors py-2">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>