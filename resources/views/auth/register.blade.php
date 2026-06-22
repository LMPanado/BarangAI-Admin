<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Barangay 419</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brgyGreen: '#1d4ed8',
                        brgyGold: '#1d4ed8',
                        darkGreen: '#1e3a8a'
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .hero-gradient { background: linear-gradient(135deg, #1d4ed8 0%, #1e3a8a 100%); }
    </style>
</head>
<body class="bg-[#f8fafc] min-h-screen flex items-center justify-center p-4 py-16">

    {{-- Back Button --}}
    <a href="/" 
       class="absolute top-8 left-8 text-[10px] font-black text-slate-400 hover:text-brgyGreen transition flex items-center gap-3 group uppercase tracking-[0.2em]">
        <div class="w-8 h-8 rounded-full border border-slate-200 flex items-center justify-center group-hover:border-brgyGreen transition-colors">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
            </svg>
        </div>
        Back to Home
    </a>

    <div class="max-w-6xl w-full bg-white rounded-[3rem] shadow-[0_40px_80px_rgba(0,0,0,0.06)] border border-slate-100 overflow-hidden flex flex-col md:flex-row">
        
        {{-- Left Side: Branding --}}
        <div class="md:w-5/12 hero-gradient relative flex items-center justify-center p-12 overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <svg class="absolute -top-24 -left-24 w-96 h-96 text-white" fill="currentColor" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="50" />
                </svg>
                <svg class="absolute -bottom-24 -right-24 w-96 h-96 text-brgyGold" fill="currentColor" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="50" />
                </svg>
            </div>
            
            <div class="relative z-10 text-center max-w-sm">
                {{-- Logo Section --}}
                <div class="w-32 h-32 bg-white/10 backdrop-blur-xl border border-white/20 rounded-[2.5rem] flex items-center justify-center shadow-2xl mx-auto mb-8 p-4">
                    <img src="{{ asset('images/brgy_logo.png') }}" alt="Barangay 419 Logo" class="w-full h-full object-contain">
                </div>
                
                <span class="text-brgyGold font-black tracking-[0.4em] uppercase text-[10px] block mb-4">Resident Registration</span>
                <h1 class="text-white text-4xl font-extrabold tracking-tight mb-6">Join Our <span class="text-white/70">Community</span></h1>
                <p class="text-white/50 text-xs leading-relaxed font-bold uppercase tracking-widest">
                    Apply for documents and stay connected with community updates instantly.
                </p>
            </div>
        </div>

        {{-- Right Side: Registration Form --}}
        <div class="md:w-7/12 p-8 md:p-16 bg-white">
            <div class="mb-10">
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Create Account</h2>
                <p class="text-slate-400 mt-3 text-sm font-medium">Please provide your details to register as a resident.</p>
            </div>

            @if ($errors->any())
                <div class="mb-8 p-6 bg-red-50 border border-red-100 text-red-600 text-[10px] font-black rounded-[2rem] uppercase tracking-[0.1em]">
                    <div class="flex items-center gap-3 mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Registration Errors
                    </div>
                    <ul class="list-disc list-inside opacity-80">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                {{-- Personal Info Section --}}
                <div class="space-y-6">
                    <div class="flex items-center gap-4 mb-2">
                        <div class="w-8 h-8 bg-brgyGreen/5 rounded-lg flex items-center justify-center text-brgyGreen">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h3 class="text-[10px] font-black text-brgyGreen uppercase tracking-[0.2em]">Personal Information</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">First Name</label>
                            <input type="text" name="first_name" class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-brgyGreen/5 focus:border-brgyGreen focus:bg-white outline-none transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300" placeholder="Juan" value="{{ old('first_name') }}" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Middle Name</label>
                            <input type="text" name="middle_name" class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-brgyGreen/5 focus:border-brgyGreen focus:bg-white outline-none transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300" placeholder="Protacio" value="{{ old('middle_name') }}">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Last Name</label>
                            <input type="text" name="last_name" class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-brgyGreen/5 focus:border-brgyGreen focus:bg-white outline-none transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300" placeholder="Dela Cruz" value="{{ old('last_name') }}" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Age</label>
                            <input type="number" name="age" class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-brgyGreen/5 focus:border-brgyGreen focus:bg-white outline-none transition-all duration-300 font-bold text-slate-700" placeholder="18" value="{{ old('age') }}" required min="0">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Supporting Document (ID)</label>
                            <div class="relative">
                                <input type="file" name="supporting_document" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-brgyGreen/5 focus:border-brgyGreen focus:bg-white outline-none transition-all duration-300 font-bold text-slate-400 file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-brgyGreen file:text-white hover:file:bg-darkGreen cursor-pointer" required>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Account Details Section --}}
                <div class="space-y-6 pt-4">
                    <div class="flex items-center gap-4 mb-2">
                        <div class="w-8 h-8 bg-brgyGold/10 rounded-lg flex items-center justify-center text-brgyGreen">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <h3 class="text-[10px] font-black text-brgyGreen uppercase tracking-[0.2em]">Account Security</h3>
                    </div>

                    <div class="space-y-2 group">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 transition-colors group-focus-within:text-brgyGreen">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <input type="email" name="email" class="w-full pl-12 pr-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-brgyGreen/5 focus:border-brgyGreen focus:bg-white outline-none transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300" placeholder="your@email.com" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2 group">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 transition-colors group-focus-within:text-brgyGreen">Password</label>
                            <input type="password" name="password" class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-brgyGreen/5 focus:border-brgyGreen focus:bg-white outline-none transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300" placeholder="Min. 8 chars" required>
                        </div>
                        <div class="space-y-2 group">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 transition-colors group-focus-within:text-brgyGreen">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-brgyGreen/5 focus:border-brgyGreen focus:bg-white outline-none transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300" placeholder="Repeat password" required>
                        </div>
                    </div>
                </div>

                <div class="flex items-start gap-4 ml-1">
                    <input type="checkbox" id="terms" class="mt-1 w-5 h-5 rounded-lg border-slate-200 text-brgyGreen focus:ring-brgyGreen transition-all" required>
                    <label for="terms" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-relaxed">
                        I agree to the <a href="#" class="text-brgyGreen hover:text-brgyGold underline underline-offset-4 decoration-2">Terms of Service</a> and <a href="#" class="text-brgyGreen hover:text-brgyGold underline underline-offset-4 decoration-2">Privacy Policy</a>.
                    </label>
                </div>

                <button type="submit" 
                    class="w-full py-5 bg-brgyGreen text-white font-black rounded-2xl hover:bg-darkGreen transition-all duration-300 shadow-xl shadow-brgyGreen/20 hover:shadow-2xl hover:shadow-brgyGreen/30 active:scale-[0.98] uppercase tracking-[0.2em] text-[10px] flex items-center justify-center gap-3">
                    Complete Registration
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>

            <div class="mt-12 pt-8 border-t border-slate-50 text-center">
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest">
                    Already registered? 
                    <a href="{{ route('login') }}" class="text-brgyGreen hover:text-brgyGold ml-2 transition-all underline underline-offset-4 decoration-2">
                        Sign in instead
                    </a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>