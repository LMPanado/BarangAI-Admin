<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Barangay 419</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brgyGreen: '#2d5a27',
                        brgyGold: '#f1c40f',
                        darkGreen: '#1e3d1a'
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#f8fafc] min-h-screen flex items-center justify-center p-4">

    <a href="/" class="absolute top-8 left-8 text-sm font-semibold text-slate-500 hover:text-brgyGreen transition flex items-center gap-2 group">
        <span class="group-hover:-translate-x-1 transition-transform">←</span> Back to Home
    </a>

    <div class="max-w-4xl w-full bg-white rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.05)] overflow-hidden flex flex-col md:flex-row min-h-[600px]">
        
        <div class="md:w-5/12 bg-brgyGreen relative flex items-center justify-center p-12 overflow-hidden">
            <div class="absolute inset-0 opacity-20">
                <div class="absolute -top-24 -left-24 w-64 h-64 rounded-full bg-white blur-3xl"></div>
                <div class="absolute -bottom-24 -right-24 w-64 h-64 rounded-full bg-brgyGold blur-3xl"></div>
            </div>
            
            <div class="relative z-10 text-center">
                <div class="w-20 h-20 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl flex items-center justify-center font-bold text-white shadow-2xl mx-auto mb-6 text-3xl">
                    419
                </div>
                <h1 class="text-white text-3xl font-bold tracking-tight mb-4">Official Resident Portal</h1>
                <p class="text-white/70 text-sm leading-relaxed font-light">
                    Access your documents, view community updates, and stay connected with Zone 43.
                </p>
            </div>
        </div>

        <div class="md:w-7/12 p-8 md:p-16 flex flex-col justify-center">
            <div class="mb-10">
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Welcome Back</h2>
                <p class="text-slate-500 mt-2 font-medium">Please enter your details to sign in.</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-slate-700 ml-1">Email Address</label>
                    <input type="email" name="email" 
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-brgyGreen/10 focus:border-brgyGreen focus:bg-white outline-none transition-all duration-200 placeholder:text-slate-400" 
                        placeholder="name@email.com"
                        required>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center ml-1">
                        <label class="text-sm font-semibold text-slate-700">Password</label>
                        <a href="#" class="text-xs font-bold text-brgyGreen hover:text-brgyGold transition">Forgot Password?</a>
                    </div>
                    <input type="password" name="password" 
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-brgyGreen/10 focus:border-brgyGreen focus:bg-white outline-none transition-all duration-200 placeholder:text-slate-400" 
                        placeholder="••••••••"
                        required>
                </div>

                <div class="flex items-center gap-2 ml-1">
                    <input type="checkbox" id="remember" class="w-4 h-4 rounded text-brgyGreen focus:ring-brgyGreen">
                    <label for="remember" class="text-sm text-slate-600 cursor-pointer">Remember this device</label>
                </div>

                <button type="submit" 
                    class="w-full py-4 bg-brgyGreen text-white font-bold rounded-2xl hover:bg-darkGreen transition-all duration-300 shadow-lg shadow-brgyGreen/20 hover:shadow-xl active:scale-[0.98] uppercase tracking-widest text-xs">
                    Sign In
                </button>
            </form>

            <div class="mt-10 pt-8 border-t border-slate-100 text-center">
                <p class="text-slate-500 text-sm font-medium">
                    New resident? 
                    <a href="{{ route('register') }}" class="text-brgyGreen font-bold hover:underline decoration-brgyGold decoration-2 underline-offset-4 transition-all">
                        Create an account
                    </a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>