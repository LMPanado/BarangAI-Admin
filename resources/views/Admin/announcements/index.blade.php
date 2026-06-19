@extends('layouts.admin') {{-- Change this if your main admin layout file has a different filename --}}

@section('content')
<div class="p-6 max-w-7xl mx-auto space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-green-50 rounded-xl text-brgyGreen">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-black text-gray-900 uppercase tracking-wider">Barangay Announcements</h1>
                <p class="text-sm text-gray-500 mt-0.5">Manage official news items and system bulletins displayed on the resident portal feed.</p>
            </div>
        </div>
        <a href="{{ route('admin.announcements.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-brgyGreen text-white text-xs font-bold rounded-xl uppercase tracking-widest hover:bg-darkGreen transition-all duration-300 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
            Create Announcement
        </a>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm rounded-xl shadow-sm">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        
        <div class="p-4 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="relative w-full sm:w-72">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4-4m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" placeholder="Search bulletins..." class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-xl text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:border-brgyGreen focus:ring-1 focus:ring-brgyGreen transition-all">
            </div>
            <div class="flex items-center gap-2 self-end sm:self-auto">
                <span class="text-xs font-semibold text-gray-500">Show:</span>
                <select class="bg-white border border-gray-200 text-xs font-medium text-gray-700 py-1.5 px-3 rounded-lg focus:outline-none focus:border-brgyGreen">
                    <option>All Items</option>
                    <option>Pinned Only</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 text-[11px] uppercase tracking-widest font-bold">
                        <th class="py-4 px-6">Title / Content Summary</th>
                        <th class="py-4 px-6 w-32">Category</th>
                        <th class="py-4 px-6 w-32">Status</th>
                        <th class="py-4 px-6 w-48">Posted Date</th>
                        <th class="py-4 px-6 w-16 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-600">
                    @forelse($announcements as $announcement)
                        <tr class="hover:bg-gray-50/70 transition-colors group">
                            <td class="py-4 px-6 max-w-md whitespace-normal">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-900 group-hover:text-brgyGreen transition-colors line-clamp-1">{{ $announcement->title }}</span>
                                    <span class="text-xs text-gray-400 line-clamp-2 mt-1 leading-relaxed">{{ $announcement->content }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 align-middle">
                                <span class="inline-flex items-center px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-lg uppercase tracking-wider border border-emerald-100 shadow-2xs">
                                    {{ $announcement->category }}
                                </span>
                            </td>
                            <td class="py-4 px-6 align-middle">
                                @if($announcement->is_pinned)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-500 text-white text-[10px] font-black rounded-lg uppercase tracking-widest shadow-xs">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                                        </svg>
                                        Pinned
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 bg-gray-100 text-gray-500 text-[10px] font-bold rounded-lg uppercase tracking-wider border border-gray-200">
                                        Standard
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 align-middle text-xs font-medium text-gray-500">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-gray-700 font-semibold">{{ $announcement->created_at->format('M d, Y') }}</span>
                                    <span class="text-[10px] text-gray-400">{{ $announcement->created_at->format('h:i A') }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 align-middle text-center">
                                <div class="inline-flex items-center justify-center gap-1">
                                    <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="p-1.5 text-gray-400 hover:text-brgyGreen rounded-lg hover:bg-gray-100 transition-all" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    
                                    <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this announcement? This action cannot be undone.');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 rounded-lg hover:bg-gray-100 transition-all" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 px-6 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center max-w-sm mx-auto space-y-3">
                                    <div class="p-4 bg-gray-50 text-gray-300 rounded-full">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                    </div>
                                    <div class="font-bold text-gray-700">No announcements posted yet</div>
                                    <p class="text-xs text-gray-400 leading-relaxed">System feeds are quiet right now. Use the link above to write your first official bulletin entry.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection