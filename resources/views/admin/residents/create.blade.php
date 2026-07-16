@extends('layouts.admin')

@section('content')
<div class="space-y-8 p-4">
    {{-- Page Header --}}
    <div class="flex justify-between items-center border-b border-gray-100 pb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Add New Resident</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Create a new profile for the <span class="text-brgyGreen font-bold">Barangay 419</span> database.</p>
        </div>
        <nav class="flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider">
            <span class="text-gray-400">Home</span>
            <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            <a href="{{ route('admin.residents.index') }}" class="text-gray-400 hover:text-brgyGreen transition-colors">Residents</a>
            <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            <span class="text-brgyGreen">Add New</span>
        </nav>
    </div>

    {{-- Main Form Card --}}
    <div class="bg-white rounded-[2.5rem] shadow-[0_10px_40px_rgba(0,0,0,0.03)] border border-slate-100 overflow-hidden">
        <div class="bg-slate-50/50 px-8 py-5 border-b border-slate-50">
            <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Personal Information Fields</h2>
        </div>

        <form action="{{ route('admin.residents.store') }}" method="POST" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                
                {{-- Column 1: Names --}}
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" 
                               class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-brgyGreen focus:ring-0 outline-none transition-all" placeholder="e.g. Dela Cruz" required>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" 
                               class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-brgyGreen focus:ring-0 outline-none transition-all" placeholder="e.g. Juan" required>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Middle Name</label>
                        <input type="text" name="middle_name" value="{{ old('middle_name') }}" 
                               class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-brgyGreen focus:ring-0 outline-none transition-all" placeholder="Optional">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Gender</label>
                            <select name="gender" class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-4 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-brgyGreen focus:ring-0 outline-none transition-all appearance-none">
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Civil Status</label>
                            <select name="civil_status" id="civil_status" onchange="toggleChildrenSection(this.value)" class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-4 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-brgyGreen focus:ring-0 outline-none transition-all appearance-none">
                                <option value="Single" {{ old('civil_status') == 'Single' ? 'selected' : '' }}>Single</option>
                                <option value="Married" {{ old('civil_status') == 'Married' ? 'selected' : '' }}>Married</option>
                                <option value="Widowed" {{ old('civil_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                <option value="Separated" {{ old('civil_status') == 'Separated' ? 'selected' : '' }}>Separated</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Column 2: Contact & Bio --}}
                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Birth Date</label>
                            <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" 
                                   class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-4 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-brgyGreen focus:ring-0 outline-none transition-all" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Age</label>
                            <input type="number" name="age" id="age" value="{{ old('age') }}" 
                                   class="w-full bg-slate-100 border-2 border-slate-100 rounded-2xl px-5 py-3 text-sm font-black text-slate-400 cursor-not-allowed outline-none" readonly placeholder="0">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Place of Birth</label>
                        <input type="text" name="place_birth" value="{{ old('place_birth') }}" 
                               class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-brgyGreen focus:ring-0 outline-none transition-all" placeholder="City/Province">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                               class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-brgyGreen focus:ring-0 outline-none transition-all" placeholder="email@example.com" required>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" 
                               class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-brgyGreen focus:ring-0 outline-none transition-all" placeholder="09xxxxxxxxx">
                    </div>
                </div>

                {{-- Column 3: Stats & Address --}}
                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Height (CM)</label>
                            <input type="number" name="height_cm" value="{{ old('height_cm') }}" 
                                   class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-brgyGreen focus:ring-0 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Weight (KG)</label>
                            <input type="number" name="weight_kg" value="{{ old('weight_kg') }}" 
                                   class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-brgyGreen focus:ring-0 outline-none transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Resident Address</label>
                        <textarea name="address" rows="4" class="w-full bg-slate-50 border-2 border-slate-50 rounded-[2rem] px-6 py-4 text-sm font-bold text-slate-700 focus:bg-white focus:border-brgyGreen focus:ring-0 outline-none transition-all resize-none" placeholder="Full residential address..." required>{{ old('address') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Children Section (Married / Widowed / Separated only) --}}
            @php $showChildren = in_array(old('civil_status'), ['Married', 'Widowed', 'Separated']); @endphp
            <div id="children-section" class="mt-10 pt-8 border-t border-slate-50 {{ $showChildren ? '' : 'hidden' }}">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Children's Age Groups</h3>
                <p class="text-xs text-slate-400 mb-5">Select the age groups of the resident's children. Used for targeted event notifications.</p>
                <div class="flex flex-wrap gap-3">
                    @foreach(['0-2' => 'Infant / Toddler', '3-5' => 'Preschool', '6-12' => 'School Age'] as $val => $lbl)
                    @php $checked = in_array($val, old('children_groups', [])); @endphp
                    <label id="child-create-lbl-{{ str_replace('-','_',$val) }}"
                           style="display:flex;align-items:center;gap:10px;padding:10px 18px;border-radius:12px;border:2px solid {{ $checked ? '#1d4ed8' : '#e2e8f0' }};background:{{ $checked ? '#eff6ff' : '#f8fafc' }};cursor:pointer;user-select:none;transition:all .15s;">
                        <input type="checkbox" name="children_groups[]" value="{{ $val }}"
                               style="width:15px;height:15px;accent-color:#1d4ed8;"
                               {{ $checked ? 'checked' : '' }}
                               onchange="styleCreateChildLabel(this)">
                        <div>
                            <p style="font-size:9px;font-weight:900;color:#374151;text-transform:uppercase;letter-spacing:.1em;line-height:1;">{{ $lbl }}</p>
                            <p style="font-size:9px;color:#94a3b8;margin-top:2px;">Ages {{ $val }} yrs</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="mt-12 pt-8 border-t border-slate-50 flex flex-col sm:flex-row justify-end gap-4">
                <a href="{{ route('admin.residents.index') }}" class="px-8 py-4 text-xs font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition-all text-center">
                    Cancel Registration
                </a>
                <button type="submit" class="bg-brgyGreen text-white text-xs font-black uppercase tracking-widest px-10 py-4 rounded-2xl shadow-lg shadow-brgyGreen/20 hover:bg-darkGreen transition-all active:scale-95">
                    Add New Resident
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleChildrenSection(val) {
        const show = ['Married', 'Widowed', 'Separated'].includes(val);
        document.getElementById('children-section').classList.toggle('hidden', !show);
    }

    function styleCreateChildLabel(cb) {
        const lbl = cb.closest('label');
        lbl.style.borderColor = cb.checked ? '#1d4ed8' : '#e2e8f0';
        lbl.style.background  = cb.checked ? '#eff6ff' : '#f8fafc';
    }

    function calculateAge() {
        const birthInput = document.getElementById('birth_date');
        const ageInput = document.getElementById('age');
        const birthDate = new Date(birthInput.value);
        const today = new Date();
        if (!isNaN(birthDate)) {
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) { age--; }
            ageInput.value = age >= 0 ? age : 0;
        }
    }
    document.getElementById('birth_date').addEventListener('change', calculateAge);
</script>

<style>
    /* Custom date indicator color to match brgyGreen */
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(32%) sepia(12%) saturate(1432%) hue-rotate(65deg) brightness(95%) contrast(85%);
        cursor: pointer;
    }
</style>
@endsection