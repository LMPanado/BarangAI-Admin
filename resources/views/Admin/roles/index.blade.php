@extends('layouts.admin')

@section('content')
<div class="space-y-8 p-2">
    
    {{-- Page Header --}}
    <div class="flex justify-between items-center border-b border-gray-100 pb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Manage User Roles</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Manage staff permissions and resident roles for <span class="text-brgyGreen font-bold">Barangay 419</span>.</p>
        </div>
        <nav class="flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider">
            <span class="text-gray-400">Home</span>
            <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            <span class="text-brgyGreen">Roles</span>
        </nav>
    </div>

        <div>
        
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
            {{-- Search Bar --}}
            <form action="{{ route('admin.roles.index') }}" method="GET" class="relative w-full sm:w-80 group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400 group-focus-within:text-brgyGreen transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="SEARCH NAME OR EMAIL..." 
                       class="pl-11 pr-4 py-3.5 text-xs font-bold border-2 border-slate-100 rounded-2xl focus:border-brgyGreen focus:ring-0 outline-none w-full transition-all bg-white shadow-sm placeholder:text-slate-400 placeholder:font-black placeholder:uppercase placeholder:tracking-widest">
            </form>
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
                    <tr class="hover:bg-slate-50/50 transition-all group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-brgyGreen/5 flex items-center justify-center text-brgyGreen font-black text-sm border border-brgyGreen/10 group-hover:bg-brgyGold group-hover:text-white transition-all duration-300">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 text-base leading-tight group-hover:text-brgyGreen transition-colors italic">
                                        {{ $user->name }}
                                    </p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="w-1 h-1 bg-brgyGold rounded-full"></span>
                                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 font-mono">
                                            {{ $user->email }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            @php
                                $roleBadge = match((int)$user->role) {
                                    2 => 'bg-amber-50 text-amber-600 border-amber-100',
                                    3 => 'bg-blue-50 text-blue-600 border-blue-100',
                                    default => 'bg-slate-50 text-slate-500 border-slate-100',
                                };
                                $roleLabel = match((int)$user->role) {
                                    2 => 'Barangay Captain',
                                    3 => 'Barangay Official',
                                    default => 'Resident User',
                                };
                            @endphp
                            <span class="px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest border {{ $roleBadge }}">
                                {{ $roleLabel }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex justify-end">
                                <form action="{{ route('admin.roles.update', $user->id) }}" method="POST" class="relative w-full max-w-[200px]">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" onchange="this.form.submit()" 
                                        class="w-full text-[9px] font-black uppercase tracking-widest px-4 py-2.5 rounded-xl border-2 border-slate-100 bg-slate-50/50 cursor-pointer transition-all focus:border-brgyGreen focus:ring-0 outline-none hover:bg-white hover:border-slate-200 shadow-sm">
                                        <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>Resident</option>
                                        <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Brgy Captain</option>
                                        <option value="3" {{ $user->role == 3 ? 'selected' : '' }}>Brgy Official</option>
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
                                <p class="text-slate-400 font-black uppercase text-[10px] tracking-[0.3em]">No User Records Identified</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if(method_exists($users, 'hasPages') && $users->hasPages())
    <div class="pt-6 pb-10">
        <div class="bg-white px-6 py-4 rounded-3xl border border-slate-100 shadow-sm">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
    @endif
</div>
@endsection