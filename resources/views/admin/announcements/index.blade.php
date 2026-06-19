@extends('layouts.admin') {{-- Change this if your main admin layout file has a different filename --}}

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-black text-gray-800 uppercase tracking-wider">Barangay Announcements</h1>
            <p class="text-xs text-gray-500 mt-1">Manage official news items and system bulletins displayed on the resident portal feed.</p>
        </div>
        <a href="{{ route('admin.announcements.create') }}" class="px-4 py-2 bg-brgyGreen text-white text-xs font-bold rounded-xl uppercase tracking-widest hover:bg-darkGreen transition-all duration-300 shadow-md">
            + Create New Announcement
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 text-sm rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-gray-400 text-[10px] uppercase tracking-widest font-bold">
                    <th class="p-4">Title / Content</th>
                    <th class="p-4">Category</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Posted Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-sm text-gray-600">
                @forelse($announcements as $announcement)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 max-w-md">
                            <div class="font-bold text-gray-800">{{ $announcement->title }}</div>
                            <div class="text-xs text-gray-400 line-clamp-1 mt-0.5">{{ $announcement->content }}</div>
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 bg-brgyGreen/10 text-brgyGreen text-[10px] font-bold rounded-md uppercase tracking-wider">
                                {{ $announcement->category }}
                            </span>
                        </td>
                        <td class="p-4">
                            @if($announcement->is_pinned)
                                <span class="px-2 py-0.5 bg-brgyGold text-white text-[10px] font-bold rounded-md uppercase tracking-wider">
                                    Pinned
                                </span>
                            @else
                                <span class="text-xs text-gray-400">Standard</span>
                            @endif
                        </td>
                        <td class="p-4 text-xs text-gray-400">
                            {{ $announcement->created_at->format('M d, Y h:i A') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-400 text-sm">
                            No announcements posted yet. Click the button above to add your first post!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection