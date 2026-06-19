{{-- Modal --}}
<div id="scheduleModal" class="fixed inset-0 bg-slate-900/60 hidden items-center justify-center z-[100] backdrop-blur-md p-4 transition-all duration-300">
    <div class="bg-white rounded-[2.5rem] shadow-[0_25px_70px_rgba(0,0,0,0.2)] w-full max-w-md overflow-hidden transform transition-all border border-slate-100 relative">
        
        {{-- Brgy Gold Accent Top Bar --}}
        <div class="h-2 w-full bg-brgyGold"></div>

        {{-- Modal Header --}}
        <div class="px-8 pt-8 pb-6 flex justify-between items-start">
            <div>
                <h3 id="modalTitle" class="text-xl font-black text-slate-900 uppercase tracking-tight leading-none">Add New Event</h3>
                <p class="text-[10px] text-brgyGreen font-black uppercase tracking-widest mt-2">Barangay 419 Operations</p>
            </div>
            <button onclick="closeModal()" class="group w-10 h-10 flex items-center justify-center rounded-2xl bg-slate-50 border border-slate-100 text-slate-400 hover:bg-red-50 hover:text-red-500 hover:border-red-100 transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        {{-- Form with enctype for Image Upload --}}
        <form id="scheduleForm" action="{{ route('admin.schedules.store') }}" method="POST" enctype="multipart/form-data" class="px-8 pb-8 space-y-5">
            @csrf
            <input type="hidden" name="_method" id="methodField" value="POST">
            <input type="hidden" name="remove_image" id="remove_image_input" value="0">
            
            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="p-4 bg-red-50 text-red-600 text-[10px] font-black rounded-2xl border border-red-100 flex items-center gap-3">
                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                    <ul class="list-none">
                        @foreach ($errors->all() as $error)
                            <li class="uppercase tracking-wide">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Selected Date --}}
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Event Date</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input type="date" name="schedule_date" id="modal_date" 
                           class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl pl-12 pr-5 py-4 text-sm font-black text-slate-500 outline-none pointer-events-none appearance-none" 
                           required>
                </div>
            </div>

            {{-- Event Title --}}
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Title</label>
                <input type="text" name="title" id="modal_title" placeholder="Community Cleanup..." 
                       class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:bg-white focus:border-brgyGreen focus:ring-4 focus:ring-brgyGreen/5 outline-none transition-all placeholder:text-slate-300" 
                       required>
            </div>

            {{-- Location --}}
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Location</label>
                <input type="text" name="location" id="modal_location" placeholder="e.g. Covered Court" 
                       class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:bg-white focus:border-brgyGreen focus:ring-4 focus:ring-brgyGreen/5 outline-none transition-all placeholder:text-slate-300">
            </div>
            
            {{-- Pubmat Upload Section --}}
            <div>
                <div class="flex justify-between items-center mb-2 ml-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Promo Image</label>
                    <span id="file-size-badge" class="hidden text-[8px] font-black text-white bg-brgyGreen px-2 py-0.5 rounded-full uppercase tracking-widest"></span>
                </div>
                <div class="relative group h-32">
                    <label for="pubmat" class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed border-slate-200 rounded-[2rem] cursor-pointer bg-slate-50 group-hover:bg-slate-100 group-hover:border-brgyGreen/30 transition-all overflow-hidden">
                        <div class="flex flex-col items-center justify-center py-4">
                            <div class="p-2.5 bg-white rounded-xl shadow-sm mb-2 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-slate-400 group-hover:text-brgyGreen transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p id="upload-label-text" class="text-[9px] font-black text-slate-400 uppercase tracking-widest group-hover:text-brgyGreen">Upload Publication Material</p>
                        </div>
                        <input id="pubmat" name="image" type="file" class="hidden" accept="image/*" onchange="previewImage(this)" />
                    </label>

                    <div id="image-preview" class="hidden absolute inset-0 rounded-[2rem] overflow-hidden bg-white border-2 border-brgyGreen group">
                        <img src="" id="preview-src" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <button type="button" onclick="removeImage(event)" class="bg-red-500 text-white rounded-2xl px-4 py-2 text-[10px] font-black uppercase tracking-widest shadow-xl transform translate-y-2 group-hover:translate-y-0 transition-all">
                                Remove Image
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Time Grid --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Time From</label>
                    <input type="time" name="schedule_time" id="modal_time_from"
                           class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-black text-slate-700 focus:bg-white focus:border-brgyGreen outline-none transition-all" 
                           required>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Time To</label>
                    <input type="time" name="schedule_time_to" id="modal_time_to"
                           class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-black text-slate-700 focus:bg-white focus:border-brgyGreen outline-none transition-all" 
                           required>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="pt-4">
                <button type="submit" 
                        class="w-full bg-brgyGreen text-white text-[10px] font-black uppercase tracking-[0.2em] py-5 rounded-[1.5rem] shadow-xl shadow-brgyGreen/30 hover:bg-slate-900 transition-all active:scale-[0.98] flex items-center justify-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                    Confirm Schedule
                </button>
            </div>
        </form>
    </div>
</div>