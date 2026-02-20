@extends('layouts.admin')

@section('content')
<div class="space-y-8 p-4 font-sans">
    {{-- Page Header --}}
    <div class="flex justify-between items-center border-b border-slate-100 pb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Edit Resident Record</h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">
                Updating profile for: 
                <span class="text-barangayGreen font-bold">#{{ str_pad($resident->id, 5, '0', STR_PAD_LEFT) }}</span>
            </p>
        </div>
        <a href="{{ route('admin.residents.index') }}" class="text-[10px] font-black text-slate-400 hover:text-barangayGreen uppercase tracking-[0.2em] transition-all flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to List
        </a>
    </div>

    {{-- Main Form Card --}}
    <div class="bg-white rounded-[2.5rem] shadow-[0_10px_40px_rgba(0,0,0,0.03)] border border-slate-100 overflow-hidden">
        <div class="bg-slate-50/50 px-8 py-5 border-b border-slate-50">
            <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Personal Information Details</h2>
        </div>

        <form action="{{ route('admin.residents.update', $resident->id) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                
                {{-- Column 1: Names --}}
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $resident->last_name) }}" 
                               class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-barangayGreen focus:ring-0 outline-none transition-all" required>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $resident->first_name) }}" 
                               class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-barangayGreen focus:ring-0 outline-none transition-all" required>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Middle Name</label>
                        <input type="text" name="middle_name" value="{{ old('middle_name', $resident->middle_name) }}" 
                               class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-barangayGreen focus:ring-0 outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Gender</label>
                            <select name="gender" class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-4 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-barangayGreen focus:ring-0 outline-none transition-all appearance-none">
                                <option value="Male" {{ old('gender', $resident->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $resident->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Civil Status</label>
                            <select name="civil_status" class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-4 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-barangayGreen focus:ring-0 outline-none transition-all appearance-none">
                                <option value="Single" {{ old('civil_status', $resident->civil_status) == 'Single' ? 'selected' : '' }}>Single</option>
                                <option value="Married" {{ old('civil_status', $resident->civil_status) == 'Married' ? 'selected' : '' }}>Married</option>
                                <option value="Widowed" {{ old('civil_status', $resident->civil_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                <option value="Separated" {{ old('civil_status', $resident->civil_status) == 'Separated' ? 'selected' : '' }}>Separated</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Column 2: Bio --}}
                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Birth Date</label>
                            <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $resident->birth_date) }}" 
                                   class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-4 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-barangayGreen focus:ring-0 outline-none transition-all" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Age</label>
                            <input type="number" name="age" id="age" value="{{ old('age', $resident->age) }}" 
                                   class="w-full bg-slate-100 border-2 border-slate-100 rounded-2xl px-5 py-3 text-sm font-black text-slate-400 cursor-not-allowed outline-none" readonly>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Place of Birth</label>
                        <input type="text" name="place_birth" value="{{ old('place_birth', $resident->place_birth) }}" 
                               class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-barangayGreen focus:ring-0 outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $resident->email) }}" 
                               class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-barangayGreen focus:ring-0 outline-none transition-all" required>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $resident->phone) }}" 
                               class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-barangayGreen focus:ring-0 outline-none transition-all">
                    </div>
                </div>

                {{-- Column 3: Stats & Address --}}
                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Height (CM)</label>
                            <input type="number" name="height_cm" value="{{ old('height_cm', $resident->height_cm) }}" 
                                   class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-barangayGreen focus:ring-0 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Weight (KG)</label>
                            <input type="number" name="weight_kg" value="{{ old('weight_kg', $resident->weight_kg) }}" 
                                   class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-barangayGreen focus:ring-0 outline-none transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Voter Status</label>
                        <select name="is_voter" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-4 py-3 text-sm font-extrabold text-barangayGreen focus:bg-white focus:border-barangayGreen focus:ring-0 outline-none transition-all appearance-none">
                            <option value="0" {{ old('is_voter', $resident->is_voter) == 0 ? 'selected' : '' }}>NOT REGISTERED</option>
                            <option value="1" {{ old('is_voter', $resident->is_voter) == 1 ? 'selected' : '' }}>REGISTERED VOTER</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Resident Address</label>
                        <textarea name="address" rows="4" class="w-full bg-slate-50 border-2 border-slate-50 rounded-[2rem] px-6 py-4 text-sm font-bold text-slate-700 focus:bg-white focus:border-barangayGreen focus:ring-0 outline-none transition-all resize-none" required>{{ old('address', $resident->address) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="mt-12 pt-8 border-t border-slate-50 flex flex-col sm:flex-row justify-end gap-4">
                <a href="{{ route('admin.residents.index') }}" class="px-8 py-4 text-xs font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition-all text-center">
                    Discard Changes
                </a>
                <button type="submit" class="bg-barangayGreen text-white text-xs font-black uppercase tracking-widest px-10 py-4 rounded-2xl shadow-lg shadow-barangayGreen/20 hover:bg-barangayDark transition-all active:scale-95">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>

<script>
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
    window.onload = calculateAge;
</script>

<style>
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(32%) sepia(12%) saturate(1432%) hue-rotate(65deg) brightness(95%) contrast(85%);
        cursor: pointer;
    }
</style>
@endsection