@extends('layouts.client')

@section('content')
<div class="min-h-screen bg-[#f8fafc] font-sans pb-20">
    <div class="h-20"></div>

    <div class="hero-gradient py-24 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-white blur-3xl"></div>
            <div class="absolute top-1/2 -right-24 w-64 h-64 rounded-full bg-brgyGold blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 text-center">
            <span class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[10px] font-bold tracking-[0.3em] uppercase mb-6 text-white">Online Office</span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight leading-tight">
                Official <span class="text-brgyGold">Document</span> Request
            </h1>
            <p class="mt-6 text-white/70 max-w-xl mx-auto font-medium text-sm md:text-base leading-relaxed">
                Secure your required certifications online. Please ensure all details match your registered resident profile for faster verification.
            </p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-6 -mt-16 relative z-20">
        <div class="bg-white rounded-[3rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden">
            <div class="p-8 md:p-14">
                
                {{-- SUCCESS MESSAGE --}}
                @if(session('success'))
                <div class="mb-10 p-5 bg-green-50 border-l-4 border-brgyGreen rounded-r-2xl flex items-center animate-pulse">
                    <div class="w-8 h-8 bg-brgyGreen rounded-full flex items-center justify-center text-white mr-4 shadow-lg shadow-brgyGreen/20">✓</div>
                    <p class="text-sm font-bold text-brgyGreen tracking-tight">{{ session('success') }}</p>
                </div>
                @endif

                {{-- ERROR MESSAGE BLOCK --}}
                @if($errors->any())
                <div class="mb-10 p-5 bg-red-50 border-l-4 border-red-500 rounded-r-2xl">
                    <div class="flex items-center mb-3">
                        <div class="w-6 h-6 bg-red-500 rounded-full flex items-center justify-center text-white mr-3 text-[10px] font-bold">!</div>
                        <p class="text-xs font-black text-red-600 uppercase tracking-widest">Submission Failed</p>
                    </div>
                    <ul class="space-y-1 ml-9">
                        @foreach($errors->all() as $error)
                            <li class="text-sm text-red-500 font-semibold">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Added enctype for file uploads --}}
                <form action="{{ route('client.request.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                    @csrf
                    
                    <div class="relative group">
                        <label for="document_type" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-1">Document Category</label>
                        <div class="relative">
                            <select id="document_type" name="document_type" required 
                                    class="block w-full px-6 py-5 text-slate-700 bg-slate-50 border-2 {{ $errors->has('document_type') ? 'border-red-200' : 'border-slate-50' }} rounded-2xl appearance-none focus:outline-none focus:bg-white focus:border-brgyGreen/20 transition-all cursor-pointer font-semibold">
                                <option value="" disabled {{ old('document_type') ? '' : 'selected' }}>Choose type of certification...</option>
                                <option value="indigency" {{ old('document_type') == 'indigency' ? 'selected' : '' }}>Barangay Indigency</option>
                                <option value="clearance" {{ old('document_type') == 'clearance' ? 'selected' : '' }}>Barangay Clearance</option>
                                <option value="residency" {{ old('document_type') == 'residency' ? 'selected' : '' }}>Certificate of Residency</option>
                                <option value="permit" {{ old('document_type') == 'permit' ? 'selected' : '' }}>Business Permit</option>
                                <option value="brgyid" {{ old('document_type') == 'brgyid' ? 'selected' : '' }}>Barangay ID</option>
                                <option value="cedula" {{ old('document_type') == 'cedula' ? 'selected' : '' }}>Cedula</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-6 text-brgyGreen">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="purpose" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-1">Purpose of Request</label>
                        <textarea id="purpose" name="purpose" rows="4" required 
                                  placeholder="Provide specific reason (e.g. For Scholarship Application at TESDA)"
                                  class="block w-full px-6 py-5 text-slate-700 bg-slate-50 border-2 {{ $errors->has('purpose') ? 'border-red-200' : 'border-slate-50' }} rounded-2xl focus:outline-none focus:bg-white focus:border-brgyGreen/20 transition-all resize-none font-semibold">{{ old('purpose') }}</textarea>
                    </div>

                    {{-- NEW: Supporting Document Upload Section --}}
                    <div>
                        <label for="supporting_document" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-1">Supporting Document (Any Government Issued-ID)</label>
                        <div class="relative">
                            <input type="file" id="supporting_document" name="supporting_document" 
                                   class="block w-full text-sm text-slate-500 file:mr-6 file:py-4 file:px-8 file:rounded-2xl file:border-0 file:text-xs file:font-black file:uppercase file:tracking-widest file:bg-brgyGreen/10 file:text-brgyGreen hover:file:bg-brgyGreen/20 transition-all bg-slate-50 border-2 {{ $errors->has('supporting_document') ? 'border-red-200' : 'border-slate-50' }} rounded-2xl cursor-pointer">
                        </div>
                        <p class="mt-3 ml-1 text-[10px] font-bold text-slate-400 uppercase tracking-wider italic">Accepted: JPG, PNG, or PDF (Max 2MB)</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="pickup_date" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-1">Preferred Pickup Date</label>
                            <input type="date" id="pickup_date" name="pickup_date" value="{{ old('pickup_date') }}" required
                                   class="block w-full px-6 py-5 text-slate-700 bg-slate-50 border-2 {{ $errors->has('pickup_date') ? 'border-red-200' : 'border-slate-50' }} rounded-2xl focus:outline-none focus:bg-white focus:border-brgyGreen/20 transition-all font-semibold">
                        </div>
                        <div class="bg-brgyGold/10 p-6 rounded-3xl border border-brgyGold/20 flex items-center">
                            <p class="text-[11px] text-slate-600 font-bold leading-relaxed uppercase tracking-wider">
                                <span class="text-brgyGreen block mb-1">Office Hours:</span>
                                8:00 AM — 5:00 PM <br> Monday to Friday
                            </p>
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit" 
                                class="w-full py-6 px-8 rounded-2xl bg-brgyGreen text-white font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-brgyGreen/20 hover:bg-darkGreen hover:-translate-y-1 active:scale-[0.98] transition-all duration-300">
                            Confirm and Submit Request
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="bg-slate-50 px-10 py-8 border-t border-slate-100">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="flex -space-x-3">
                            <div class="w-10 h-10 rounded-full bg-brgyGreen border-4 border-white flex items-center justify-center text-[10px] text-white font-bold italic">419</div>
                            <div class="w-10 h-10 rounded-full bg-brgyGold border-4 border-white flex items-center justify-center text-[10px] text-brgyGreen font-bold italic">✓</div>
                        </div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2"></span>
                    </div>
                    <a href="/" class="text-[10px] font-black text-brgyGreen uppercase tracking-widest hover:text-brgyGold transition-colors">
                        ← Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection