@extends('layouts.admin')

@section('content')
<div class="space-y-8 animate-fade-in max-w-[1600px] mx-auto">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-gray-100 pb-8 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Audit Logs</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium italic">
                Full activity trail for <span class="text-brgyGreen font-bold not-italic">Barangay 419</span> admin portal.
            </p>
        </div>
        <nav class="flex items-center space-x-2 text-[10px] font-bold uppercase tracking-[0.15em] bg-gray-50 px-4 py-2 rounded-full border border-gray-100">
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-brgyGreen transition-colors">Dashboard</a>
            <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            <span class="text-brgyGreen">Audit Logs</span>
        </nav>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.audit-logs.index') }}" class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by name or record..."
                   class="col-span-2 bg-gray-50 border-2 border-gray-100 rounded-2xl px-5 py-3 text-sm font-bold text-gray-700 focus:bg-white focus:border-brgyGreen focus:ring-4 focus:ring-brgyGreen/5 outline-none transition-all placeholder:text-gray-300">

            <select name="action"
                    class="bg-gray-50 border-2 border-gray-100 rounded-2xl px-5 py-3 text-sm font-bold text-gray-700 focus:bg-white focus:border-brgyGreen outline-none transition-all">
                <option value="">All Actions</option>
                <option value="created"        {{ request('action') === 'created'        ? 'selected' : '' }}>Created</option>
                <option value="updated"        {{ request('action') === 'updated'        ? 'selected' : '' }}>Updated</option>
                <option value="deleted"        {{ request('action') === 'deleted'        ? 'selected' : '' }}>Deleted</option>
                <option value="status_changed" {{ request('action') === 'status_changed' ? 'selected' : '' }}>Status Changed</option>
                <option value="role_changed"   {{ request('action') === 'role_changed'   ? 'selected' : '' }}>Role Changed</option>
                <option value="login"          {{ request('action') === 'login'          ? 'selected' : '' }}>Login</option>
                <option value="logout"         {{ request('action') === 'logout'         ? 'selected' : '' }}>Logout</option>
            </select>

            <select name="subject"
                    class="bg-gray-50 border-2 border-gray-100 rounded-2xl px-5 py-3 text-sm font-bold text-gray-700 focus:bg-white focus:border-brgyGreen outline-none transition-all">
                <option value="">All Categories</option>
                <option value="Announcement"    {{ request('subject') === 'Announcement'    ? 'selected' : '' }}>Announcement</option>
                <option value="Resident"        {{ request('subject') === 'Resident'        ? 'selected' : '' }}>Resident</option>
                <option value="Schedule"        {{ request('subject') === 'Schedule'        ? 'selected' : '' }}>Schedule</option>
                <option value="DocumentRequest" {{ request('subject') === 'DocumentRequest' ? 'selected' : '' }}>Document Request</option>
                <option value="User"            {{ request('subject') === 'User'            ? 'selected' : '' }}>User / Role</option>
            </select>
        </div>

        <div class="flex items-center gap-3 mt-4">
            <button type="submit"
                    class="bg-brgyGreen text-white px-6 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-xl hover:shadow-lg hover:shadow-brgyGreen/20 transition-all">
                Filter
            </button>
            @if(request()->hasAny(['search','action','subject']))
                <a href="{{ route('admin.audit-logs.index') }}"
                   class="px-6 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-xl border-2 border-gray-100 text-gray-400 hover:border-gray-200 hover:text-gray-600 transition-all">
                    Clear
                </a>
            @endif
            <span class="ml-auto text-[10px] font-black text-gray-300 uppercase tracking-widest">
                {{ $logs->total() }} {{ Str::plural('entry', $logs->total()) }}
            </span>
        </div>
    </form>

    {{-- Log Table --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        @if($logs->isEmpty())
            <div class="py-24 text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">No activity found</p>
            </div>
        @else
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-50 bg-gray-50/50">
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">When</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Admin</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Action</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Category</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Details</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($logs as $log)
                    @php
                        $color = $log->actionColor();
                        $colorMap = [
                            'green'  => ['bg' => 'bg-green-50',  'text' => 'text-green-700',  'dot' => 'bg-green-400'],
                            'blue'   => ['bg' => 'bg-blue-50',   'text' => 'text-blue-700',   'dot' => 'bg-blue-400'],
                            'red'    => ['bg' => 'bg-red-50',    'text' => 'text-red-700',    'dot' => 'bg-red-400'],
                            'amber'  => ['bg' => 'bg-amber-50',  'text' => 'text-amber-700',  'dot' => 'bg-amber-400'],
                            'purple' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'dot' => 'bg-purple-400'],
                            'teal'   => ['bg' => 'bg-teal-50',   'text' => 'text-teal-700',   'dot' => 'bg-teal-400'],
                            'gray'   => ['bg' => 'bg-gray-50',   'text' => 'text-gray-600',   'dot' => 'bg-gray-300'],
                        ];
                        $c = $colorMap[$color];
                    @endphp
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-xs font-bold text-gray-700">{{ $log->created_at->format('M d, Y') }}</p>
                            <p class="text-[10px] text-gray-400 font-medium mt-0.5">{{ $log->created_at->format('h:i A') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($log->user)
                                <p class="text-xs font-bold text-gray-800">{{ $log->user->last_name }}, {{ $log->user->first_name }}</p>
                                <p class="text-[10px] text-gray-400 font-medium mt-0.5">
                                    {{ ['','System Admin','Barangay Captain','Barangay Official'][$log->user->role] ?? 'Staff' }}
                                </p>
                            @else
                                <span class="text-[10px] text-gray-300 font-bold italic">Deleted account</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $c['bg'] }} {{ $c['text'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $c['dot'] }}"></span>
                                {{ str_replace('_', ' ', $log->action) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="p-1.5 bg-gray-50 rounded-lg">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $log->subjectIcon() }}"/>
                                    </svg>
                                </div>
                                <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">
                                    {{ str_replace('DocumentRequest', 'Document', $log->subject_type) }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 max-w-xs">
                            <p class="text-xs font-bold text-gray-700 truncate" title="{{ $log->subject_label }}">
                                {{ $log->subject_label }}
                            </p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-[10px] font-mono text-gray-400">{{ $log->ip_address ?? '—' }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($logs->hasPages())
                <div class="px-6 py-4 border-t border-gray-50">
                    {{ $logs->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
