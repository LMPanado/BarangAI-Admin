@extends('layouts.admin')

@section('content')
<div class="space-y-8 animate-fade-in max-w-[1600px] mx-auto">

    {{-- Page Header --}}
    <div class="flex justify-between items-center border-b border-gray-100 pb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Manage User Roles</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Manage staff permissions and resident roles for <span class="text-brgyGreen font-bold">Barangay 419</span>.</p>
        </div>
        <div class="flex items-center gap-4">
            @if(auth()->user()->role === 1)
            <button onclick="document.getElementById('create-staff-modal').classList.remove('hidden')"
                    style="background:#1d4ed8;"
                    class="flex items-center gap-2 text-white text-[10px] font-black uppercase tracking-widest px-5 py-3 rounded-2xl shadow-md hover:opacity-90 transition-all active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Create Staff Account
            </button>
            @endif
            <nav class="flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider">
                <span class="text-gray-400">Home</span>
                <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                <span class="text-brgyGreen">Roles</span>
            </nav>
        </div>
    </div>

    {{-- Quick Stats --}}
    @php
        use App\Models\User;
        $rTotal    = User::count();
        $rAdmins   = User::where('role', 1)->count();
        $rCaptains = User::where('role', 2)->count();
        $rOfficials= User::where('role', 3)->count();
    @endphp
    <div class="grid grid-cols-4 gap-4">
        @foreach([
            ['Total Users', $rTotal,    'text-gray-700',   'bg-gray-50',   'border-gray-100'],
            ['IT Admin',    $rAdmins,   'text-violet-600', 'bg-violet-50', 'border-violet-100'],
            ['Captain',     $rCaptains, 'text-amber-600',  'bg-amber-50',  'border-amber-100'],
            ['Staff',   $rOfficials,'text-blue-600',   'bg-blue-50',   'border-blue-100'],
        ] as [$lbl, $val, $clr, $bg, $border])
        <div class="rounded-2xl {{ $bg }} border {{ $border }} px-5 py-4 flex items-center gap-3">
            <p class="text-2xl font-extrabold {{ $clr }}">{{ $val }}</p>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-tight">{{ $lbl }}</p>
        </div>
        @endforeach
    </div>

    {{-- Search + Sort Bar --}}
    <div class="flex flex-col sm:flex-row items-center gap-3 w-full">
        <form action="{{ route('admin.roles.index') }}" method="GET"
              class="relative flex-1 group flex items-center bg-white border-2 border-slate-100 rounded-2xl shadow-sm focus-within:border-brgyGreen transition-all">
            <div class="absolute left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-slate-400 group-focus-within:text-brgyGreen transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by name or email..."
                   class="pl-11 pr-4 py-3.5 text-xs font-bold bg-transparent focus:ring-0 outline-none w-full placeholder:text-slate-400 placeholder:font-medium">
            <input type="hidden" name="sort" value="{{ $sort }}">
            @if(request('search'))
                <a href="{{ route('admin.roles.index', ['sort' => $sort]) }}" class="pr-4 text-slate-300 hover:text-red-400 flex-shrink-0">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                </a>
            @endif
        </form>

        {{-- Sort Buttons --}}
        <div class="flex items-center gap-1 bg-white border-2 border-slate-100 rounded-2xl p-1 shadow-sm flex-shrink-0">
            @foreach([['latest', 'Latest'], ['az', 'A–Z'], ['role', 'By Role']] as [$val, $label])
                <a href="{{ route('admin.roles.index', ['sort' => $val, 'search' => request('search')]) }}"
                   class="px-4 py-2 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all
                          {{ $sort === $val ? 'bg-brgyGreen text-white shadow-sm' : 'text-slate-400 hover:bg-slate-50 hover:text-slate-700' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Users Table Container --}}
    <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-400 text-[10px] uppercase font-black tracking-[0.2em]">
                        <th class="px-8 py-6">User Account</th>
                        <th class="px-8 py-6">Current Designation</th>
                        <th class="px-8 py-6 text-right">Administrative Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($users as $user)
                    @php
                        $fullName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
                        $initials = strtoupper(substr($user->first_name ?? '?', 0, 1) . substr($user->last_name ?? '', 0, 1));
                        if (blank($fullName)) $fullName = $user->email;
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition-all group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 rounded-2xl bg-brgyGreen/5 flex items-center justify-center text-brgyGreen font-black text-sm border border-brgyGreen/10 group-hover:bg-brgyGreen group-hover:text-white transition-all duration-300 flex-shrink-0">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <p class="font-extrabold text-slate-800 text-sm leading-tight group-hover:text-brgyGreen transition-colors">
                                        {{ $fullName }}
                                    </p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="w-1 h-1 bg-brgyGold rounded-full"></span>
                                        <p class="text-[10px] font-bold text-slate-400 tracking-wide">
                                            {{ $user->email }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            @php
                                $roleBadge = match((int)$user->role) {
                                    1 => 'bg-violet-50 text-violet-600 border-violet-100',
                                    2 => 'bg-amber-50 text-amber-600 border-amber-100',
                                    3 => 'bg-blue-50 text-blue-600 border-blue-100',
                                    default => 'bg-slate-50 text-slate-500 border-slate-100',
                                };
                                $roleLabel = match((int)$user->role) {
                                    1 => 'I.T. Administrator',
                                    2 => 'Captain Level',
                                    3 => 'Barangay Staff',
                                    default => 'Resident User',
                                };
                            @endphp
                            <span class="px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest border {{ $roleBadge }}">
                                {{ $roleLabel }}
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex justify-end items-center gap-2">
                                <form action="{{ route('admin.roles.update', $user->id) }}" method="POST" class="w-full max-w-[200px]">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" onchange="confirmAction(this.form, 'Change role for this user to \'' + this.options[this.selectedIndex].text + '\'?')"
                                        class="w-full text-[9px] font-black uppercase tracking-widest px-4 py-2.5 rounded-xl border-2 border-slate-100 bg-slate-50/50 cursor-pointer transition-all focus:border-brgyGreen focus:ring-0 outline-none hover:bg-white hover:border-slate-200 shadow-sm">
                                        <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>Resident</option>
                                        <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Captain Level</option>
                                        <option value="3" {{ $user->role == 3 ? 'selected' : '' }}>Brgy Staff</option>
                                    </select>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                <p class="text-slate-400 font-black uppercase text-[10px] tracking-[0.3em]">No User Records Found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="pt-6 pb-10">
        <div class="bg-white px-6 py-4 rounded-3xl border border-slate-100 shadow-sm">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@if(auth()->user()->role === 1)
{{-- Create Staff Account Modal --}}
<div id="create-staff-modal" class="{{ $errors->any() ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md mx-4 p-8 relative">
        <button onclick="document.getElementById('create-staff-modal').classList.add('hidden')"
                class="absolute top-5 right-5 text-gray-300 hover:text-gray-500 transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
        </button>
        <div class="mb-6">
            <h2 class="text-lg font-extrabold text-gray-800 tracking-tight">Create Staff Account</h2>
            <p class="text-xs text-gray-400 mt-1">Create a Barangay Captain or Staff account directly.</p>
        </div>

        @if($errors->any())
        <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:12px;padding:12px 16px;margin-bottom:16px;">
            <p style="font-size:11px;font-weight:800;color:#dc2626;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Please fix the following:</p>
            @foreach($errors->all() as $error)
                <p style="font-size:12px;color:#dc2626;margin:2px 0;">• {{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form action="{{ route('admin.roles.create-staff') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1">First Name</label>
                    <input type="text" name="first_name" required value="{{ old('first_name') }}"
                           style="width:100%;padding:10px 16px;font-size:14px;border-radius:12px;border:2px solid {{ $errors->has('first_name') ? '#fca5a5' : '#e2e8f0' }};outline:none;box-sizing:border-box;"
                           placeholder="Juan">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1">Last Name</label>
                    <input type="text" name="last_name" required value="{{ old('last_name') }}"
                           style="width:100%;padding:10px 16px;font-size:14px;border-radius:12px;border:2px solid {{ $errors->has('last_name') ? '#fca5a5' : '#e2e8f0' }};outline:none;box-sizing:border-box;"
                           placeholder="dela Cruz">
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1">Email Address</label>
                <input type="email" name="email" required value="{{ old('email') }}"
                       style="width:100%;padding:10px 16px;font-size:14px;border-radius:12px;border:2px solid {{ $errors->has('email') ? '#fca5a5' : '#e2e8f0' }};outline:none;box-sizing:border-box;"
                       placeholder="staff@barangay419.gov.ph">
            </div>
            <div>
                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1">Role</label>
                <select name="role" required
                        style="width:100%;padding:10px 16px;font-size:14px;border-radius:12px;border:2px solid #e2e8f0;outline:none;box-sizing:border-box;cursor:pointer;background:white;">
                    <option value="2" {{ old('role') == '2' ? 'selected' : '' }}>Barangay Captain</option>
                    <option value="3" {{ old('role') == '3' ? 'selected' : '' }}>Barangay Staff</option>
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1">Password</label>
                <div style="position:relative;">
                    <input type="password" name="password" id="staff-password" required minlength="8"
                           style="width:100%;padding:10px 44px 10px 16px;font-size:14px;border-radius:12px;border:2px solid {{ $errors->has('password') ? '#fca5a5' : '#e2e8f0' }};outline:none;box-sizing:border-box;"
                           placeholder="Min. 8 characters">
                    <button type="button" onclick="togglePw('staff-password','staff-pw-eye')"
                            style="position:absolute;top:50%;right:12px;transform:translateY(-50%);background:none;border:none;cursor:pointer;padding:0;color:#9ca3af;display:flex;align-items:center;">
                        <svg id="staff-pw-eye" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1">Confirm Password</label>
                <div style="position:relative;">
                    <input type="password" name="password_confirmation" id="staff-password-confirm" required
                           style="width:100%;padding:10px 44px 10px 16px;font-size:14px;border-radius:12px;border:2px solid #e2e8f0;outline:none;box-sizing:border-box;"
                           placeholder="Repeat password">
                    <button type="button" onclick="togglePw('staff-password-confirm','staff-pw-confirm-eye')"
                            style="position:absolute;top:50%;right:12px;transform:translateY(-50%);background:none;border:none;cursor:pointer;padding:0;color:#9ca3af;display:flex;align-items:center;">
                        <svg id="staff-pw-confirm-eye" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="pt-2">
                <button type="submit"
                        style="background:#1d4ed8;"
                        class="w-full text-white text-[10px] font-black uppercase tracking-widest py-3.5 rounded-2xl hover:opacity-90 transition-all active:scale-95">
                    Create Account
                </button>
            </div>
        </form>
    </div>
</div>

@endif

<script>
function togglePw(inputId, eyeId) {
    const input = document.getElementById(inputId);
    const eye   = document.getElementById(eyeId);
    const show  = input.type === 'password';
    input.type  = show ? 'text' : 'password';
    eye.innerHTML = show
        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>'
        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
}
</script>

@endsection
