<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay 417 | Zone 43 Official Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brgyGreen: '#2d5a27', // Forest Green from Logo
                        brgyGold: '#f1c40f',  // Golden Yellow from Logo
                        brgyNavy: '#0a192f',  
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

    <nav class="fixed top-0 w-full bg-white/90 backdrop-blur-md shadow-sm z-50 border-b border-brgyGreen/20">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-brgyGreen rounded-lg flex items-center justify-center font-bold text-white shadow-sm">417</div>
                <span class="font-bold tracking-tight text-brgyGreen uppercase">Barangay 417</span>
            </div>
            <div class="hidden md:flex items-center gap-8 text-sm font-medium uppercase tracking-wider">
                <a href="#" class="hover:text-brgyGreen transition">Dashboard</a>
                <a href="#services" class="hover:text-brgyGreen transition">Services</a>
                <a href="#officials" class="hover:text-brgyGreen transition">Officials</a>
                <a href="#schedule" class="hover:text-brgyGreen transition">Schedule</a>
                <a href="#" class="text-brgyGreen font-bold border-b-2 border-brgyGreen">Contact</a>
                
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="ml-4 px-5 py-2 bg-brgyNavy text-white rounded-full text-xs font-bold hover:bg-brgyGreen transition-all shadow-md">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="ml-4 px-5 py-2 bg-brgyGreen text-white rounded-full text-xs font-bold hover:bg-brgyNavy transition-all shadow-md">
                            Member Login
                        </a>
                    @endauth
                @endif
                </div>
        </div>
    </nav>

    <header class="relative h-[60vh] md:h-[80vh] flex items-center justify-center overflow-hidden bg-brgyGreen">
        <div class="absolute inset-0 z-0 bg-gradient-to-b from-black/10 to-transparent"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center text-white">
            <h1 class="text-5xl md:text-7xl font-bold leading-tight mb-6">
                Welcome to<br>
                <span class="text-brgyGold">Barangay 417</span>
            </h1>
            
            <p class="text-lg md:text-xl text-slate-100 max-w-2xl mx-auto mb-10 font-light leading-relaxed">
                A community built on transparency, unity, and dedicated service to every resident of Zone 43.
            </p>

            <div class="flex flex-wrap justify-center gap-4">
                <a href="#services" class="px-10 py-3 bg-white text-brgyGreen font-bold rounded-md hover:bg-brgyGold hover:text-white transition-all shadow-lg uppercase text-sm tracking-wider">
                    Explore Services
                </a>
                <a href="#schedule" class="px-10 py-3 border-2 border-brgyGold text-brgyGold hover:bg-brgyGold/10 rounded-md transition-all uppercase text-sm tracking-wider font-bold">
                    Calendar of Activities
                </a>
            </div>
        </div>
    </header>

    <section id="services" class="py-24 max-w-7xl mx-auto px-6">
        <div class="mb-16">
            <div class="w-12 h-1 bg-brgyGold mb-4"></div> 
            <h2 class="text-3xl font-bold text-brgyGreen">Community Services</h2>
            <p class="text-slate-500 mt-2">Efficient and accessible administrative support for all citizens.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="#" class="group p-8 bg-white border border-slate-100 rounded-xl shadow-sm hover:shadow-md hover:border-brgyGreen transition-all">
                <span class="text-3xl mb-4 block">📂</span>
                <h3 class="font-bold text-brgyGreen group-hover:text-brgyGold transition-colors">Business Permits</h3>
            </a>
            <a href="#" class="group p-8 bg-white border border-slate-100 rounded-xl shadow-sm hover:shadow-md hover:border-brgyGreen transition-all">
                <span class="text-3xl mb-4 block">🪪</span>
                <h3 class="font-bold text-brgyGreen group-hover:text-brgyGold transition-colors">Barangay ID</h3>
            </a>
            <a href="#" class="group p-8 bg-white border border-slate-100 rounded-xl shadow-sm hover:shadow-md hover:border-brgyGreen transition-all">
                <span class="text-3xl mb-4 block">📄</span>
                <h3 class="font-bold text-brgyGreen group-hover:text-brgyGold transition-colors">Cedula</h3>
            </a>
            <a href="#" class="group p-8 bg-white border border-slate-100 rounded-xl shadow-sm hover:shadow-md hover:border-brgyGreen transition-all">
                <span class="text-3xl mb-4 block">📜</span>
                <h3 class="font-bold text-brgyGreen group-hover:text-brgyGold transition-colors">Clearances</h3>
            </a>
        </div>
    </section>

    <section id="officials" class="py-24 bg-brgyGreen text-white"> 
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="mb-20">
                <h2 class="text-3xl font-bold mb-4 uppercase tracking-widest">Our Elected Officials</h2>
                <div class="w-16 h-1 bg-brgyGold mx-auto"></div>
            </div>

            <div class="flex flex-col items-center mb-20">
                <div class="w-40 h-40 bg-white/10 rounded-full border-4 border-brgyGold mb-6 flex items-center justify-center overflow-hidden shadow-2xl">
                    <span class="text-4xl text-white">👤</span>
                </div>
                <h3 class="text-2xl font-bold">Cynthia D. Cervantes</h3>
                <p class="text-brgyGold uppercase tracking-widest text-xs font-bold mt-1">Barangay Captain</p>
                <p class="text-slate-200 text-sm mt-2 font-light">Health and Sanitation</p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-3 gap-12 max-w-4xl mx-auto">
                <div class="flex flex-col items-center">
                    <div class="w-24 h-24 bg-white/10 rounded-full border-2 border-brgyGold/30 mb-4 flex items-center justify-center">
                        <span class="text-2xl">👤</span>
                    </div>
                    <h4 class="font-bold text-sm leading-tight">Kevin Andrew T. Dionisio</h4>
                    <p class="text-brgyGold text-[10px] uppercase font-bold mt-1">Kagawad</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-24 h-24 bg-white/10 rounded-full border-2 border-brgyGold/30 mb-4 flex items-center justify-center">
                        <span class="text-2xl">👤</span>
                    </div>
                    <h4 class="font-bold text-sm leading-tight">Joan O. Asuncion</h4>
                    <p class="text-brgyGold text-[10px] uppercase font-bold mt-1">Kagawad</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-24 h-24 bg-white/10 rounded-full border-2 border-brgyGold/30 mb-4 flex items-center justify-center">
                        <span class="text-2xl">👤</span>
                    </div>
                    <h4 class="font-bold text-sm leading-tight">Constancia Q. Lichauco</h4>
                    <p class="text-brgyGold text-[10px] uppercase font-bold mt-1">Kagawad</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-[#1e3d1a] text-white pt-16 pb-8 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-brgyGold rounded flex items-center justify-center font-bold text-brgyGreen text-sm">417</div>
                    <span class="font-bold tracking-tight uppercase">Barangay 417</span>
                </div>
                <p class="text-slate-300 text-sm leading-relaxed">
                    Dedicated to providing efficient public service and fostering a safe, 
                    progressive environment for all residents of Zone 43.
                </p>
            </div>

            <div>
                <h4 class="font-bold text-brgyGold uppercase tracking-widest text-xs mb-6">Quick Navigation</h4>
                <ul class="space-y-3 text-sm text-slate-300">
                    <li><a href="{{ route('dashboard') }}" class="hover:text-brgyGold transition">Dashboard</a></li>
                    <li><a href="#services" class="hover:text-brgyGold transition">Barangay Services</a></li>
                    <li><a href="#officials" class="hover:text-brgyGold transition">Elected Officials</a></li>
                    <li><a href="#schedule" class="hover:text-brgyGold transition">Announcements</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-brgyGold uppercase tracking-widest text-xs mb-6">Contact Us</h4>
                <ul class="space-y-4 text-sm text-slate-300">
                    <li class="flex items-start gap-3">
                        <span class="text-brgyGold font-bold">📍</span>
                        <span>123 Barangay Hall Street, Zone 43, Manila, Philippines</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="text-brgyGold font-bold">📞</span>
                        <span>+63 (02) 8123-4567</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="text-brgyGold font-bold">📧</span>
                        <span>info@barangay417.gov.ph</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 mt-16 pt-8 border-t border-white/5 text-center text-xs text-slate-400">
            <p>&copy; 2026 Barangay 417, Zone 43. All Rights Reserved.</p>
        </div>
    </footer>

    <a href="#" class="fixed bottom-8 right-8 w-12 h-12 bg-brgyGold rounded-full flex items-center justify-center text-brgyGreen shadow-lg hover:brightness-110 transition-all">
        ↑
    </a>
</body>
</html>