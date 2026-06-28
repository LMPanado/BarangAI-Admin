@extends('layouts.admin')

@section('content')
<div class="space-y-8 animate-fade-in max-w-[1600px] mx-auto">

    {{-- Page Header --}}
    <div class="flex justify-between items-center border-b border-gray-100 pb-6">
        <div>
            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-1">{{ now()->format('l, F j, Y') }}</p>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Announcements</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium italic">
                Official bulletins and news for <span class="text-brgyGreen font-bold not-italic">Barangay 419</span> residents.
            </p>
        </div>
        <nav class="flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider">
            <a href="#" class="text-gray-400 hover:text-brgyGreen transition-colors">Home</a>
            <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            <span class="text-brgyGreen">Announcements</span>
        </nav>
    </div>

    {{-- Search & Action Bar --}}
    <div class="flex flex-col lg:flex-row gap-6 justify-between items-stretch lg:items-center bg-white p-2 rounded-2xl shadow-sm border border-gray-100">
        <div class="relative flex-1 group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-300 group-focus-within:text-brgyGreen transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" id="searchInput" placeholder="Search announcements..."
                   class="pl-12 pr-4 py-4 text-xs font-bold border-none rounded-xl focus:ring-0 w-full transition-all bg-transparent placeholder:text-gray-300 uppercase tracking-widest">
        </div>
        <div class="flex gap-3 px-2 pb-2 lg:pb-0">
            <a href="{{ route('admin.announcements.create') }}"
               class="bg-brgyGreen text-white px-8 py-4 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl hover:shadow-lg hover:shadow-brgyGreen/20 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                New Announcement
            </a>
        </div>
    </div>


    {{-- Table Section --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="announcementsTable">
                <thead>
                    <tr class="text-gray-400 text-[10px] uppercase font-black tracking-[0.2em] border-b border-gray-100">
                        <th class="px-8 py-4 font-black">Title / Content</th>
                        <th class="px-8 py-4 font-black">Category</th>
                        <th class="px-8 py-4 font-black">Status</th>
                        <th class="px-8 py-4 font-black">Posted Date</th>
                        <th class="px-8 py-4 text-right font-black">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($announcements as $announcement)
                    <tr class="hover:bg-brgyGreen/[0.02] transition-all group announcement-row">
                        <td class="px-8 py-5 max-w-md">
                            <div class="flex flex-col">
                                <span class="font-black text-gray-800 uppercase tracking-tight group-hover:text-brgyGreen transition-colors line-clamp-1 announcement-title">
                                    {{ $announcement->title }}
                                </span>
                                <span class="text-xs text-gray-400 line-clamp-2 mt-1 leading-relaxed font-medium">
                                    {{ $announcement->content }}
                                </span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-600 text-[9px] font-black rounded-lg border border-green-100 uppercase tracking-widest">
                                <span class="w-1 h-1 bg-green-500 rounded-full"></span>
                                {{ $announcement->category }}
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            @if($announcement->is_pinned)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-600 text-[9px] font-black rounded-lg border border-amber-100 uppercase tracking-widest">
                                    <span class="w-1 h-1 bg-amber-500 rounded-full"></span>
                                    Pinned
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-50 text-gray-400 text-[9px] font-black rounded-lg border border-gray-100 uppercase tracking-widest">
                                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                    Standard
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col gap-0.5">
                                <span class="text-xs font-black text-gray-700">{{ $announcement->created_at->format('M d, Y') }}</span>
                                <span class="text-[10px] font-bold text-gray-400">{{ $announcement->created_at->format('h:i A') }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end gap-3 items-center">
                                <a href="{{ route('admin.announcements.edit', $announcement->id) }}"
                                   title="Edit Announcement"
                                   class="p-2 bg-green-50 text-brgyGreen rounded-xl border border-green-100 shadow-sm hover:bg-brgyGreen hover:text-white hover:border-brgyGreen hover:-translate-y-0.5 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form id="del-ann-{{ $announcement->id }}" action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                </form>
                                <button onclick="confirmDelete('del-ann-{{ $announcement->id }}', 'Delete announcement: {{ addslashes($announcement->title) }}?')"
                                        title="Delete Announcement"
                                        class="p-2 bg-red-50 text-red-500 rounded-xl border border-red-100 shadow-sm hover:bg-red-500 hover:text-white hover:border-red-500 hover:-translate-y-0.5 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="p-4 bg-gray-50 rounded-full mb-4">
                                    <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-sm font-black text-gray-400 uppercase tracking-widest">No Announcements Posted Yet</h4>
                                <p class="text-xs text-gray-400 mt-1">Use the button above to create your first bulletin.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        document.querySelectorAll('.announcement-row').forEach(row => {
            const title = row.querySelector('.announcement-title').textContent.toLowerCase();
            row.style.display = title.includes(query) ? '' : 'none';
        });
    });
</script>
@endsection
