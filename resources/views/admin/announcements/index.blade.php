@extends('layouts.admin')

@section('content')
<div class="space-y-8 animate-fade-in max-w-[1600px] mx-auto">

    {{-- Page Header --}}
    <div class="flex justify-between items-center border-b border-gray-100 pb-6">
        <div>
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
    <div class="flex flex-col lg:flex-row gap-4 justify-between items-stretch lg:items-center bg-white p-2 rounded-2xl shadow-sm border border-gray-100">
        <div class="relative flex-1 group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-300 group-focus-within:text-brgyGreen transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" id="searchInput" placeholder="Search announcements..."
                   class="pl-11 pr-4 py-3.5 text-xs font-bold border-none rounded-xl focus:ring-0 w-full transition-all bg-transparent placeholder:text-gray-300 uppercase tracking-widest">
        </div>
        <div class="flex gap-3 px-2 pb-2 lg:pb-0">
            <a href="{{ route('admin.announcements.create') }}"
               class="bg-brgyGreen text-white px-6 py-3.5 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl hover:shadow-lg hover:shadow-brgyGreen/20 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                New Announcement
            </a>
        </div>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="flex items-center gap-3 px-5 py-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-700 text-xs font-black uppercase tracking-widest">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Cards --}}
    @if($announcements->isEmpty())
        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-20 flex flex-col items-center justify-center text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-5">
                <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
            </div>
            <h4 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-1">No Announcements Posted Yet</h4>
            <p class="text-xs text-gray-300 font-medium">Use the button above to create your first bulletin.</p>
        </div>
    @else
        <div class="flex flex-col gap-4" id="announcementsList">
            @foreach($announcements as $announcement)
            @php
                $catColors = match(strtolower($announcement->category ?? 'general')) {
                    'health', 'health advisory' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-100', 'dot' => 'bg-emerald-500'],
                    'security'                  => ['bg' => 'bg-red-50',     'text' => 'text-red-600',     'border' => 'border-red-100',     'dot' => 'bg-red-500'],
                    'advisory'                  => ['bg' => 'bg-orange-50',  'text' => 'text-orange-600',  'border' => 'border-orange-100',  'dot' => 'bg-orange-500'],
                    default                     => ['bg' => 'bg-blue-50',    'text' => 'text-blue-600',    'border' => 'border-blue-100',    'dot' => 'bg-blue-500'],
                };
            @endphp

            <div class="group bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md hover:border-brgyGreen/20 transition-all duration-200 flex items-stretch overflow-hidden announcement-card">

                {{-- Thumbnail --}}
                <div class="w-36 flex-shrink-0 relative overflow-hidden bg-gray-50">
                    @if($announcement->image_url)
                        <img src="{{ Storage::url($announcement->image_url) }}"
                             alt="{{ $announcement->title }}"
                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100">
                            <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                </div>

                {{-- Main Content --}}
                <div class="flex-1 px-6 py-5 flex flex-col justify-between min-w-0">
                    <div>
                        {{-- Badges row --}}
                        <div class="flex items-center flex-wrap gap-2 mb-2">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 {{ $catColors['bg'] }} {{ $catColors['text'] }} {{ $catColors['border'] }} border text-[9px] font-black rounded-lg uppercase tracking-widest">
                                <span class="w-1.5 h-1.5 rounded-full {{ $catColors['dot'] }}"></span>
                                {{ $announcement->category }}
                            </span>

                            @if($announcement->is_pinned)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-50 text-amber-600 border border-amber-100 text-[9px] font-black rounded-lg uppercase tracking-widest">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 24 24"><path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5.2v6h1.6v-6H18v-2l-2-2z"/></svg>
                                    Pinned
                                </span>
                            @endif

                            @if($announcement->expires_at)
                                @if($announcement->isExpired())
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-red-500 border border-red-100 text-[9px] font-black rounded-lg uppercase tracking-widest">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                        Expired · {{ $announcement->expires_at->format('M d, Y') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-sky-50 text-sky-600 border border-sky-100 text-[9px] font-black rounded-lg uppercase tracking-widest">
                                        <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span>
                                        Expires {{ $announcement->expires_at->format('M d, Y') }}
                                    </span>
                                @endif
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-600 border border-emerald-100 text-[9px] font-black rounded-lg uppercase tracking-widest">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                    No Expiry
                                </span>
                            @endif
                        </div>

                        {{-- Title --}}
                        <h3 class="font-extrabold text-gray-800 text-sm leading-snug group-hover:text-brgyGreen transition-colors line-clamp-1 announcement-title">
                            {{ $announcement->title }}
                        </h3>

                        {{-- Preview --}}
                        <p class="text-xs text-gray-400 font-medium mt-1 line-clamp-1 leading-relaxed">
                            {{ $announcement->content }}
                        </p>
                    </div>

                    {{-- Date --}}
                    <div class="flex items-center gap-1.5 mt-3 text-[10px] font-black text-gray-300 uppercase tracking-widest">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Posted {{ $announcement->created_at->format('M d, Y') }} · {{ $announcement->created_at->format('h:i A') }}
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col items-center justify-center gap-2 px-5 border-l border-gray-50 flex-shrink-0">
                    <a href="{{ route('admin.announcements.edit', $announcement->id) }}"
                       title="Edit"
                       class="w-9 h-9 flex items-center justify-center rounded-xl bg-brgyGreen/8 text-brgyGreen hover:bg-brgyGreen hover:text-white transition-all hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                    <form id="del-ann-{{ $announcement->id }}" action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST">
                        @csrf @method('DELETE')
                    </form>
                    <button onclick="confirmDelete('del-ann-{{ $announcement->id }}', 'Delete announcement: {{ addslashes($announcement->title) }}?')"
                            title="Delete"
                            class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-50 text-red-400 hover:bg-red-500 hover:text-white transition-all hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>

            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-4">{{ $announcements->links() }}</div>
    @endif

</div>

<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        document.querySelectorAll('.announcement-card').forEach(card => {
            const title = card.querySelector('.announcement-title').textContent.toLowerCase();
            card.style.display = title.includes(query) ? '' : 'none';
        });
    });
</script>
@endsection
