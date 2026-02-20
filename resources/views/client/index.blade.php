@extends('layouts.client')

@section('content')
    {{-- Header / Hero Section --}}
    <header class="relative pt-32 pb-20 md:pt-48 md:pb-32 overflow-hidden hero-gradient">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-white blur-3xl"></div>
            <div class="absolute top-1/2 -right-24 w-64 h-64 rounded-full bg-brgyGold blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 text-center text-white">
            <span class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-xs font-bold tracking-[0.2em] uppercase mb-6">Official Web Portal</span>
            <h1 class="text-5xl md:text-8xl font-extrabold leading-[1.1] mb-8 tracking-tight">
                Welcome to <br>
                <span class="text-brgyGold">Barangay 419</span>
            </h1>
            
            <p class="text-lg md:text-xl text-white/80 max-w-2xl mx-auto mb-12 font-medium leading-relaxed">
                Dedicated to transparency, unity, and professional public service for every resident of Zone 43.
            </p>

            <div class="flex flex-wrap justify-center gap-5">
                <a href="#services" class="px-10 py-4 bg-white text-brgyGreen font-bold rounded-2xl hover:bg-brgyGold hover:text-white transition-all shadow-2xl uppercase text-xs tracking-widest">
                    Request Documents
                </a>
                @guest
                <a href="{{ route('login') }}" class="px-10 py-4 border-2 border-white/30 text-white hover:bg-white/10 rounded-2xl transition-all uppercase text-xs tracking-widest font-bold backdrop-blur-sm">
                    Resident Login
                </a>
                @endguest
            </div>
        </div>
    </header>

    {{-- Community Services Section --}}
    <section id="services" class="py-32 max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div>
                <span class="text-brgyGreen font-bold tracking-[0.3em] uppercase text-xs block mb-3">Online Office</span>
                <h2 class="text-4xl font-extrabold text-slate-900 tracking-tight">Community Services</h2>
            </div>
            <p class="text-slate-500 max-w-md font-medium">Streamlined administrative support. Request your documents online for faster processing.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php $services = [
                ['icon' => '', 'title' => 'Business Permits'],
                ['icon' => '', 'title' => 'Barangay ID'],
                ['icon' => '', 'title' => 'Cedula'],
                ['icon' => '', 'title' => 'Clearances']
            ]; @endphp

            @foreach($services as $s)
            <a href="{{ route('client.request') }}" class="group p-10 bg-white rounded-[2rem] shadow-[0_10px_40px_rgba(0,0,0,0.03)] border border-slate-100 hover:border-brgyGreen hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition-transform duration-300">
                    {{ $s['icon'] }}
                </div>
                <h3 class="text-xl font-bold text-slate-800 group-hover:text-brgyGreen transition-colors">{{ $s['title'] }}</h3>
                <p class="text-slate-400 text-sm mt-2 font-medium">Click to start request →</p>
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

    {{-- Upcoming Activities Section --}}
    <section id="schedule" class="py-32 max-w-7xl mx-auto px-6">
        <div class="mb-16">
            <span class="text-brgyGreen font-bold tracking-[0.3em] uppercase text-xs block mb-3">Bulletin</span>
            <h2 class="text-4xl font-extrabold text-slate-900 tracking-tight">Upcoming Activities</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($events as $event)
                <div class="bg-white p-10 rounded-[2.5rem] shadow-[0_10px_40px_rgba(0,0,0,0.02)] border border-slate-100 hover:shadow-xl transition-all group overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-brgyGreen/5 rounded-bl-[3rem]"></div>
                    <div class="flex items-center gap-5 mb-8">
                        <div class="bg-brgyGreen text-white px-5 py-3 rounded-2xl text-center shadow-lg shadow-brgyGreen/20">
                            <span class="block text-2xl font-black leading-none">{{ \Carbon\Carbon::parse($event->schedule_date)->format('d') }}</span>
                            <span class="text-[10px] uppercase font-bold tracking-widest">{{ \Carbon\Carbon::parse($event->schedule_date)->format('M') }}</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-lg group-hover:text-brgyGreen transition-colors">{{ $event->title }}</h3>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">{{ $event->location ?? 'Barangay Hall' }}</p>
                        </div>
                    </div>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6 line-clamp-3">{{ $event->description }}</p>
                    <div class="pt-6 border-t border-slate-50">
                        <span class="text-xs font-bold text-brgyGreen uppercase tracking-widest">Details →</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white p-16 rounded-[2.5rem] text-center border border-slate-100">
                    <p class="text-slate-400 font-medium italic">No activities posted at the moment.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Floating Scroll Top Button --}}
    <a href="#" class="fixed bottom-10 right-10 w-14 h-14 bg-brgyGold rounded-2xl flex items-center justify-center text-brgyGreen shadow-2xl hover:-translate-y-2 transition-all duration-300 z-50">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"></path></svg>
    </a>
@endsection