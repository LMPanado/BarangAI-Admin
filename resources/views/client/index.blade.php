@extends('layouts.client')

@section('content')
    {{-- Header / Hero Section --}}
    <header class="relative pt-32 pb-20 md:pt-48 md:pb-32 overflow-hidden hero-gradient">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-white blur-3xl"></div>
            <div class="absolute top-1/2 -right-24 w-64 h-64 rounded-full bg-brgyGold blur-3xl"></div>
        </div>

        @if(session('success'))
            <div class="relative z-20 max-w-2xl mx-auto px-6 mb-8">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 text-white p-4 rounded-2xl font-bold text-center shadow-2xl animate-bounce">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="relative z-10 max-w-7xl mx-auto px-6 text-center text-white">
            <span class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-xs font-bold tracking-[0.2em] uppercase mb-6">Official Information Portal</span>
            <h1 class="text-5xl md:text-8xl font-extrabold leading-[1.1] mb-8 tracking-tight">
                Welcome to <br>
                <span class="text-brgyGold">Barangay 419</span>
            </h1>
            
            <p class="text-lg md:text-xl text-white/80 max-w-2xl mx-auto mb-12 font-medium leading-relaxed">
                Dedicated to transparency, unity, and professional public service. Access our community services and announcements here.
            </p>

            <div class="flex flex-wrap justify-center gap-5">
                <a href="#announcements" class="px-10 py-4 border-2 border-white/30 text-white hover:bg-white/10 rounded-2xl transition-all uppercase text-xs tracking-widest font-bold backdrop-blur-sm">
                    View Announcements
                </a>
            </div>
        </div>
    </header>

    {{-- Community Services Section --}}
    <section id="services" class="py-32 max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div>
                <span class="text-brgyGreen font-bold tracking-[0.3em] uppercase text-xs block mb-3">Public Information</span>
                <h2 class="text-4xl font-extrabold text-slate-900 tracking-tight">Available Documents</h2>
            </div>
            <p class="text-slate-500 max-w-md font-medium">Learn about the requirements and processes for various barangay issuances.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php 
            $services = [
                ['title' => 'Business Permits', 'slug' => 'business-permit', 'path' => '<path d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615 4.806 4.806 0 0 1 6.75 0 4.806 4.806 0 0 1 6.75 0 3.001 3.001 0 0 0 3.75.615V21M3.75 9.349m0 0a3.001 3.001 0 0 1 3.75-.615 4.806 4.806 0 0 0 6.75 0 4.806 4.806 0 0 0 6.75 0 3.001 3.001 0 0 1 3.75.615V15a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V9.349Z" />'],
                ['title' => 'Barangay ID', 'slug' => 'barangay-id', 'path' => '<path d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />'],
                ['title' => 'Cedula', 'slug' => 'cedula', 'path' => '<path d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75m0 3v.75m0 3v.75m0 3v.75m15-10.5v10.5m-15-10.5a2.25 2.25 0 0 1 2.25-2.25h9a2.25 2.25 0 0 1 2.25 2.25v10.5m-15-10.5h15a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75A2.25 2.25 0 0 1 3.75 4.5Z" />'],
                ['title' => 'Clearances', 'slug' => 'barangay-clearance', 'path' => '<path d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.959 11.959 0 0 1 12 2.714Z" />']
            ]; 
            @endphp

            @foreach($services as $s)
            <a href="{{ route('services.show', $s['slug']) }}" class="group p-10 bg-white rounded-[2rem] shadow-[0_10px_40px_rgba(0,0,0,0.03)] border border-slate-100 hover:border-brgyGreen hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-brgyGreen/10 transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-brgyGreen">
                        {!! $s['path'] !!}
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 group-hover:text-brgyGreen transition-colors">{{ $s['title'] }}</h3>
                <p class="text-slate-400 text-sm mt-2 font-medium">View Requirements →</p>
            </a>
            @endforeach
        </div>
    </section>

    {{-- Elected Officials Section --}}
    <section id="officials" class="py-32 bg-darkGreen rounded-[3rem] mx-4 md:mx-10 mb-20 text-white shadow-2xl overflow-hidden relative">
        <div class="absolute top-0 right-0 w-96 h-96 bg-brgyGreen/20 blur-[100px] rounded-full"></div>
        <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
            <div class="mb-20">
                <span class="text-brgyGold font-bold tracking-[0.3em] uppercase text-xs block mb-3">Leadership</span>
                <h2 class="text-4xl font-extrabold uppercase tracking-tight">Our Elected Officials</h2>
            </div>
            <div class="flex flex-col items-center mb-24">
                <div class="group relative">
                    <div class="absolute inset-0 bg-brgyGold rounded-full blur-xl opacity-20 group-hover:opacity-40 transition-opacity"></div>
                    <div class="w-48 h-48 bg-white/5 rounded-full border-2 border-brgyGold/50 mb-8 flex items-center justify-center overflow-hidden shadow-2xl relative">
                        <span class="text-6xl">👤</span>
                    </div>
                </div>
                <h3 class="text-3xl font-extrabold tracking-tight">Erwin R. Molina</h3>
                <p class="text-brgyGold uppercase tracking-[0.2em] text-xs font-bold mt-2">Punong Barangay</p>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-y-16 gap-x-8 max-w-6xl mx-auto">
                @php $officials = [
                    ['name' => 'John Carlo C. Solomon', 'role' => 'Kagawad'],
                    ['name' => 'Reynaldo J. Dauz Jr.', 'role' => 'Kagawad'],
                    ['name' => 'Jesus C. Anunciacion', 'role' => 'Kagawad'],
                    ['name' => 'Claudine A. Dizon', 'role' => 'Kagawad'],
                    ['name' => 'Ian M. Perez', 'role' => 'Kagawad'],
                    ['name' => 'Ma. Teresita G. Quintana', 'role' => 'Kagawad'],
                    ['name' => 'Enerson R. Molina', 'role' => 'Kagawad'],
                    ['name' => 'Alaine Joy T. Ambito', 'role' => 'SK Chairperson']
                ]; @endphp
                @foreach($officials as $off)
                <div class="flex flex-col items-center group">
                    <div class="w-28 h-28 bg-white/5 rounded-3xl border border-white/10 mb-5 flex items-center justify-center group-hover:bg-white/10 transition-colors">
                        <span class="text-3xl opacity-50">👤</span>
                    </div>
                    <h4 class="font-bold text-sm tracking-tight text-center px-4 leading-relaxed">{{ $off['name'] }}</h4>
                    <p class="text-brgyGold/80 text-[10px] uppercase font-bold mt-2 tracking-widest">{{ $off['role'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Barangay Announcements Section --}}
    <section id="announcements" class="py-32 max-w-7xl mx-auto px-6 border-b border-slate-100">
        <div class="mb-16">
            <span class="text-brgyGreen font-bold tracking-[0.3em] uppercase text-xs block mb-3">Community Feed</span>
            <h2 class="text-4xl font-extrabold text-slate-900 tracking-tight">Barangay Announcements</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($announcements as $announcement)
                <div class="bg-white rounded-[2.5rem] shadow-[0_10px_40px_rgba(0,0,0,0.02)] border border-slate-100 hover:shadow-2xl transition-all group overflow-hidden relative flex flex-col justify-between">
                    @if($announcement->is_pinned)
                        <div class="absolute top-4 right-4 bg-brgyGold text-white text-[9px] uppercase tracking-widest px-3 py-1 rounded-xl font-extrabold shadow-md z-10">
                            📌 Pinned
                        </div>
                    @endif
                    
                    <div>
                        @if($announcement->image_url)
                            <div class="h-48 w-full overflow-hidden border-b border-slate-50">
                                <img src="{{ Storage::url($announcement->image_url) }}" class="w-full h-full object-cover group-hover:scale-102 transition-transform duration-500" alt="Announcement Image">
                            </div>
                        @endif

                        <div class="p-8 pb-0">
                            <div class="flex items-center gap-2 text-slate-400 font-bold uppercase text-[9px] tracking-widest mb-3">
                                <span class="px-2 py-0.5 bg-brgyGreen/10 text-brgyGreen rounded-md font-black">
                                    {{ $announcement->category }}
                                </span>
                                <span>•</span>
                                <span>{{ $announcement->created_at->diffForHumans() }}</span>
                            </div>
                            <h3 class="font-bold text-slate-800 text-xl group-hover:text-brgyGreen transition-colors mb-3 leading-snug">
                                {{ $announcement->title }}
                            </h3>
                            <p class="text-slate-500 text-sm leading-relaxed line-clamp-4">
                                {{ $announcement->content }}
                            </p>
                        </div>
                    </div>

                    <div class="p-8 pt-6">
                        <div class="pt-4 border-t border-slate-50 flex justify-between items-center">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Official Bulletin</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white p-16 rounded-[2.5rem] text-center border border-slate-100">
                    <p class="text-slate-400 font-medium italic">No announcements posted at the moment.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Upcoming Activities Section --}}
    <section id="schedule" class="py-32 max-w-7xl mx-auto px-6">
        <div class="mb-16">
            <span class="text-brgyGreen font-bold tracking-[0.3em] uppercase text-xs block mb-3">Bulletin</span>
            <h2 class="text-4xl font-extrabold text-slate-900 tracking-tight">Upcoming Activities</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($events as $event)
                @php 
                    $eventImageUrl = $event->image ? asset('storage/' . $event->image) : '';
                @endphp

                <div onclick="openEventModal('{{ addslashes($event->title) }}', '{{ $eventImageUrl }}', '{{ \Carbon\Carbon::parse($event->schedule_date)->format('M d, Y') }}', '{{ \Carbon\Carbon::parse($event->schedule_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($event->schedule_time_to)->format('h:i A') }}')" 
                     class="bg-white rounded-[2.5rem] shadow-[0_10px_40px_rgba(0,0,0,0.02)] border border-slate-100 hover:shadow-2xl transition-all group overflow-hidden cursor-pointer">
                    
                    <div class="h-56 w-full overflow-hidden relative">
                        @if($event->image)
                            <img src="{{ $eventImageUrl }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Event Pubmat">
                        @else
                            <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                                <span class="text-4xl">📅</span>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4 bg-brgyGreen text-white px-4 py-2 rounded-xl text-center shadow-lg">
                            <span class="block text-xl font-black leading-none">{{ \Carbon\Carbon::parse($event->schedule_date)->format('d') }}</span>
                            <span class="text-[8px] uppercase font-bold tracking-widest">{{ \Carbon\Carbon::parse($event->schedule_date)->format('M') }}</span>
                        </div>
                    </div>

                    <div class="p-8">
                        <div class="flex flex-col gap-2 mb-4">
                            <h3 class="font-bold text-slate-800 text-lg group-hover:text-brgyGreen transition-colors">{{ $event->title }}</h3>
                            <div class="flex items-center gap-2 text-slate-400 font-bold uppercase text-[10px] tracking-widest">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ \Carbon\Carbon::parse($event->schedule_time)->format('h:i A') }}
                            </div>
                        </div>
                        <div class="pt-4 border-t border-slate-50 flex justify-between items-center">
                            <span class="text-xs font-bold text-brgyGreen uppercase tracking-widest">View Details →</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white p-16 rounded-[2.5rem] text-center border border-slate-100">
                    <p class="text-slate-400 font-medium italic">No activities posted at the moment.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Event Detail Modal --}}
    <div id="eventDetailModal" 
         onclick="handleBackdropClick(event)"
         class="fixed inset-0 bg-slate-900/80 backdrop-blur-md z-[100] hidden items-center justify-center p-4">
        
        <div class="bg-white rounded-[3rem] w-full max-w-2xl overflow-hidden shadow-2xl transform transition-all scale-95 opacity-0 duration-300 relative" id="modalContainer">
            
            <button onclick="closeEventModal()" class="absolute top-6 right-6 w-12 h-12 bg-white/20 backdrop-blur-md text-white rounded-full flex items-center justify-center hover:bg-white hover:text-slate-900 transition-all z-[110] border border-white/30">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <div class="relative h-80 md:h-96 w-full bg-slate-100">
                <img id="modalImg" src="" class="w-full h-full object-contain bg-slate-900 hidden" alt="Event Pubmat">
                <div id="modalNoImg" class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                     <span class="text-6xl mb-4">📅</span>
                     <p class="font-bold uppercase tracking-widest text-xs">No Pubmat Available</p>
                </div>
            </div>
            <div class="p-10">
                <span id="modalDate" class="text-brgyGreen font-bold tracking-[0.2em] uppercase text-[10px] block mb-2"></span>
                <h3 id="modalTitle" class="text-3xl font-extrabold text-slate-900 mb-4"></h3>
                <div class="flex items-center gap-2 text-slate-500 text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span id="modalTime"></span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openEventModal(title, image, date, time) {
            const modal = document.getElementById('eventDetailModal');
            const container = document.getElementById('modalContainer');
            const imgElement = document.getElementById('modalImg');
            const noImgElement = document.getElementById('modalNoImg');
            
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalDate').innerText = date;
            document.getElementById('modalTime').innerText = time;
            
            if(image && image !== '') {
                imgElement.src = image;
                imgElement.classList.remove('hidden');
                noImgElement.classList.add('hidden');
            } else {
                imgElement.src = '';
                imgElement.classList.add('hidden');
                noImgElement.classList.remove('hidden');
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                container.classList.remove('scale-95', 'opacity-0');
            }, 10);

            document.body.style.overflow = 'hidden';
        }

        function closeEventModal() {
            const modal = document.getElementById('eventDetailModal');
            const container = document.getElementById('modalContainer');
            
            container.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }, 300);
        }

        function handleBackdropClick(event) {
            const container = document.getElementById('modalContainer');
            if (!container.contains(event.target)) {
                closeEventModal();
            }
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeEventModal();
        });
    </script>
@endsection