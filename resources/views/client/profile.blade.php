<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | Barangay 419</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { brgyGreen: '#2d5a27', brgyGold: '#f1c40f', darkGreen: '#1e3d1a' },
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        .glass { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(12px); }
        .hero-gradient { background: linear-gradient(135deg, #2d5a27 0%, #1e3d1a 100%); }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 font-sans">
    <nav class="fixed top-0 w-full glass shadow-sm z-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center gap-4">
                <div class="w-10 h-10 bg-brgyGreen rounded-xl flex items-center justify-center font-bold text-white">419</div>
                <span class="font-extrabold text-brgyGreen text-lg uppercase">Profile Portal</span>
            </a>
            <a href="/" class="text-xs font-bold text-slate-400 hover:text-brgyGreen transition uppercase tracking-widest">← Back to Home</a>
        </div>
    </nav>

    <main class="pt-32 pb-20 px-6">
        <div class="max-w-4xl mx-auto">
            <div class="relative rounded-[3rem] overflow-hidden mb-8 shadow-2xl">
                <div class="h-48 hero-gradient"></div>
                <div class="bg-white px-8 pb-8">
                    <div class="relative flex justify-between items-end -mt-16 mb-6">
                        <div class="w-32 h-32 bg-white rounded-full p-2 shadow-xl">
                            <div class="w-full h-full bg-slate-100 rounded-full flex items-center justify-center text-4xl border-4 border-white">👤</div>
                        </div>
                        <span class="px-6 py-2 bg-brgyGold/10 text-brgyGreen rounded-full text-xs font-black uppercase tracking-widest border border-brgyGold/20">Verified Resident</span>
                    </div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ Auth::user()->resident->first_name }} {{ Auth::user()->resident->last_name }}</h1>
                    <p class="text-slate-500 font-medium italic">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <h3 class="text-xs font-black text-brgyGreen uppercase tracking-[0.2em] mb-6">Personal Information</h3>
                    <div class="space-y-4">
                        <div><p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Full Name</p>
                        <p class="font-bold text-slate-700">{{ Auth::user()->resident->first_name }} {{ Auth::user()->resident->middle_name }} {{ Auth::user()->resident->last_name }}</p></div>
                        
                        <div><p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Gender / Age</p>
                        <p class="font-bold text-slate-700">{{ Auth::user()->resident->gender }} / {{ Auth::user()->resident->age }} yrs old</p></div>
                        
                        <div><p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Voter Status</p>
                        <p class="font-bold {{ Auth::user()->resident->is_voter ? 'text-green-600' : 'text-slate-400' }}">
                            {{ Auth::user()->resident->is_voter ? '✓ Registered Voter' : 'Not Registered' }}
                        </p></div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <h3 class="text-xs font-black text-brgyGreen uppercase tracking-[0.2em] mb-6">Contact & Address</h3>
                    <div class="space-y-4">
                        <div><p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Phone Number</p>
                        <p class="font-bold text-slate-700">{{ Auth::user()->resident->phone ?? 'Not Provided' }}</p></div>
                        
                        <div><p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Residential Address</p>
                        <p class="font-bold text-slate-700 leading-relaxed">{{ Auth::user()->resident->address }}</p></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>