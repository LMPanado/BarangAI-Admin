@extends('layouts.admin')

@section('content')
<div class="space-y-8 animate-fade-in max-w-[1600px] mx-auto">

    {{-- Page Header --}}
    <div class="flex justify-between items-center border-b border-gray-100 pb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">New Event</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium italic">
                Schedule a new event for <span class="text-brgyGreen font-bold not-italic">Barangay 419</span>.
            </p>
        </div>
        <nav class="flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider">
            <a href="{{ route('admin.schedules.index') }}" class="text-gray-400 hover:text-brgyGreen transition-colors">Schedules</a>
            <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            <span class="text-brgyGreen">Create</span>
        </nav>
    </div>

    <form action="{{ route('admin.schedules.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Main Fields --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 space-y-6">

                    @if($errors->any())
                        <div class="p-4 bg-red-50 text-red-600 text-[10px] font-black rounded-2xl border border-red-100 flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            <ul class="list-none uppercase tracking-wide">
                                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Title --}}
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Event Title</label>
                        <input type="text" name="title" required value="{{ old('title') }}"
                               placeholder="e.g. Community Cleanup Drive"
                               class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-5 py-4 text-sm font-bold text-gray-700 focus:bg-white focus:border-brgyGreen focus:ring-4 focus:ring-brgyGreen/5 outline-none transition-all placeholder:text-gray-300">
                    </div>

                    {{-- Location --}}
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Location</label>
                        <input type="text" name="location" value="{{ old('location') }}"
                               placeholder="e.g. Covered Court"
                               class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-5 py-4 text-sm font-bold text-gray-700 focus:bg-white focus:border-brgyGreen focus:ring-4 focus:ring-brgyGreen/5 outline-none transition-all placeholder:text-gray-300">
                    </div>

                    {{-- Date --}}
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Event Date</label>
                        <input type="date" name="schedule_date" required value="{{ old('schedule_date', $date) }}"
                               onclick="this.showPicker()"
                               class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-5 py-4 text-sm font-bold text-gray-700 focus:bg-white focus:border-brgyGreen focus:ring-4 focus:ring-brgyGreen/5 outline-none transition-all cursor-pointer">
                    </div>

                    {{-- Time Grid --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Time From</label>
                            <input type="time" name="schedule_time" required value="{{ old('schedule_time') }}"
                                   onclick="this.showPicker()"
                                   class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-5 py-4 text-sm font-bold text-gray-700 focus:bg-white focus:border-brgyGreen focus:ring-4 focus:ring-brgyGreen/5 outline-none transition-all cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Time To</label>
                            <input type="time" name="schedule_time_to" required value="{{ old('schedule_time_to') }}"
                                   onclick="this.showPicker()"
                                   class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-5 py-4 text-sm font-bold text-gray-700 focus:bg-white focus:border-brgyGreen focus:ring-4 focus:ring-brgyGreen/5 outline-none transition-all cursor-pointer">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">

                {{-- Image Upload --}}
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Promo Image</label>
                    <div class="relative group h-44">
                        <label for="imageUpload" class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed border-gray-200 rounded-[2rem] cursor-pointer bg-gray-50 group-hover:bg-gray-100 group-hover:border-brgyGreen/30 transition-all overflow-hidden">
                            <div class="flex flex-col items-center justify-center py-4">
                                <div class="p-2.5 bg-white rounded-xl shadow-sm mb-2 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-brgyGreen transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <p id="upload-label-text" class="text-[9px] font-black text-gray-400 uppercase tracking-widest group-hover:text-brgyGreen transition-colors">Upload Image</p>
                                <p class="text-[9px] text-gray-300 mt-1">JPG, PNG · Max 2MB</p>
                            </div>
                            <input id="imageUpload" name="image" type="file" class="hidden" accept="image/*" onchange="previewImage(this)">
                        </label>

                        <div id="image-preview" class="hidden absolute inset-0 rounded-[2rem] overflow-hidden bg-white border-2 border-brgyGreen group/prev">
                            <img src="" id="preview-src" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/prev:opacity-100 transition-opacity flex items-center justify-center">
                                <button type="button" onclick="removeImage(event)"
                                        class="bg-red-500 text-white rounded-2xl px-4 py-2 text-[10px] font-black uppercase tracking-widest shadow-xl transform translate-y-2 group-hover/prev:translate-y-0 transition-all">
                                    Remove Image
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 space-y-3">
                    <button type="submit"
                            class="w-full bg-brgyGreen text-white py-4 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl hover:shadow-lg hover:shadow-brgyGreen/20 hover:-translate-y-0.5 transition-all active:scale-95 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        Confirm Schedule
                    </button>
                    <a href="{{ route('admin.schedules.index') }}"
                       class="w-full block text-center py-4 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl border-2 border-gray-100 text-gray-400 hover:border-gray-200 hover:text-gray-600 transition-all">
                        Cancel
                    </a>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const previewSrc = document.getElementById('preview-src');
        const label = document.getElementById('upload-label-text');
        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (file.size > 2 * 1024 * 1024) {
                alert('File too large! Max size is 2MB.');
                input.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = e => {
                previewSrc.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
            label.textContent = file.name;
        }
    }

    function removeImage(e) {
        e.preventDefault();
        document.getElementById('image-preview').classList.add('hidden');
        document.getElementById('preview-src').src = '';
        document.getElementById('imageUpload').value = '';
        document.getElementById('upload-label-text').textContent = 'Upload Image';
    }
</script>
@endsection
