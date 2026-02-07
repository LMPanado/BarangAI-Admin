@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center border-b border-gray-200 pb-4">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Add New Resident</h1>
            <p class="text-sm text-gray-500">Add a new individual to the database.</p>
        </div>
        <a href="{{ route('admin.residents.index') }}" class="text-xs font-semibold text-gray-500 hover:text-adminBlue uppercase tracking-wider transition-colors">
            &larr; Back to List
        </a>
    </div>

    <div class="bg-white border border-gray-200 rounded shadow-sm overflow-hidden">
        <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
            <h2 class="text-xs font-bold text-gray-600 uppercase">Personal Information Fields</h2>
        </div>

        <form action="{{ route('admin.residents.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" 
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-adminBlue focus:border-adminBlue outline-none" placeholder="e.g. Dela Cruz" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" 
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-adminBlue focus:border-adminBlue outline-none" placeholder="e.g. Juan" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Middle Name</label>
                        <input type="text" name="middle_name" value="{{ old('middle_name') }}" 
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-adminBlue focus:border-adminBlue outline-none" placeholder="Optional">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Gender</label>
                            <select name="gender" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-adminBlue outline-none">
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Civil Status</label>
                            <select name="civil_status" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-adminBlue outline-none">
                                <option value="Single" {{ old('civil_status') == 'Single' ? 'selected' : '' }}>Single</option>
                                <option value="Married" {{ old('civil_status') == 'Married' ? 'selected' : '' }}>Married</option>
                                <option value="Widowed" {{ old('civil_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Birth Date</label>
                            <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" 
                                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-adminBlue outline-none" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Age</label>
                            <input type="number" name="age" id="age" value="{{ old('age') }}" 
                                   class="w-full border border-gray-200 bg-gray-50 rounded px-3 py-2 text-sm font-bold text-gray-500" readonly placeholder="0">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Place of Birth</label>
                        <input type="text" name="place_birth" value="{{ old('place_birth') }}" 
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-adminBlue outline-none" placeholder="City/Province">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-adminBlue outline-none" placeholder="email@example.com" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" 
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-adminBlue outline-none" placeholder="09xxxxxxxxx">
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Height (CM)</label>
                            <input type="number" name="height_cm" value="{{ old('height_cm') }}" 
                                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-adminBlue outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Weight (KG)</label>
                            <input type="number" name="weight_kg" value="{{ old('weight_kg') }}" 
                                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-adminBlue outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Voter Status</label>
                        <select name="is_voter" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-adminBlue outline-none">
                            <option value="0" {{ old('is_voter') == 0 ? 'selected' : '' }}>Not Registered</option>
                            <option value="1" {{ old('is_voter') == 1 ? 'selected' : '' }}>Registered Voter</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Resident Address</label>
                        <textarea name="address" rows="4" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-adminBlue outline-none resize-none" placeholder="Full residential address..." required>{{ old('address') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('admin.residents.index') }}" class="px-6 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold px-8 py-2 rounded shadow-sm transition-all active:scale-95">
                    Add New Resident
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
</script>
@endsection