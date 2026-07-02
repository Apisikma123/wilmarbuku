<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - WilmarBOOKS</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: "#003215",
                        secondary: "#7b5800",
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>
<body class="bg-pattern min-h-screen flex flex-col justify-between">
    
    <div class="flex-grow flex items-center justify-center p-6">
        <div class="bg-white p-8 md:p-10 rounded-2xl shadow-[0_0_40px_rgba(0,0,0,0.05)] max-w-md w-full relative z-10">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/wil.png') }}" alt="Wilmar Logo" class="h-12 object-contain">
            </div>
            
            <!-- Headers -->
            <div class="text-center mb-8">
                <h1 class="text-xl font-bold text-primary mb-2">Masuk ke Wilmar Literacy Hub</h1>
                <p class="text-sm text-gray-500">Silakan masuk dengan akun institusi Anda.</p>
            </div>

            <!-- Form -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf
                
                @if($errors->any())
                <div class="bg-red-50 text-red-500 text-sm p-3 rounded-lg border border-red-100">
                    {{ $errors->first() }}
                </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xl">email</span>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-sm" placeholder="Masukkan email" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xl">lock</span>
                        <input type="password" name="password" class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-sm" placeholder="Masukkan kata sandi" required>
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" class="rounded border-gray-300 text-primary focus:ring-primary w-4 h-4">
                        <span class="text-gray-600">Ingat saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-primary font-semibold hover:underline">Lupa Kata Sandi?</a>
                </div>

                <button type="submit" class="w-full bg-primary text-white font-semibold py-3 rounded-lg hover:bg-primary/90 transition-colors flex items-center justify-center gap-2 shadow-sm mt-2">
                    <span class="material-symbols-outlined text-lg">login</span>
                    Masuk
                </button>
            </form>

            <div class="my-6 flex items-center gap-3">
                <hr class="flex-grow border-gray-200">
                <span class="text-sm text-gray-500">Atau</span>
                <hr class="flex-grow border-gray-200">
            </div>

            <a href="{{ route('auth.google') }}" class="w-full bg-white border border-gray-300 text-gray-700 font-medium py-3 rounded-lg hover:bg-gray-50 transition-colors flex items-center justify-center gap-3 shadow-sm">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5">
                Masuk dengan Google
            </a>
            


            <p class="text-center text-sm text-gray-600 mt-8">
                Belum punya akun? <a href="/register" class="text-secondary font-bold hover:underline">Daftar Sekarang</a>
            </p>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-[#e2e8f0]/60 border-t border-gray-200 py-8 px-6 md:px-12 text-sm text-gray-600 flex flex-col md:flex-row items-center justify-between gap-4">
        <p class="font-bold text-gray-800">
            &copy; {{ date('Y') }} Wilmar Business Indonesia Polytechnic. Nurturing Entrepreneurs.
        </p>
        <div class="flex items-center gap-6 underline font-medium text-gray-600">
            <a href="#" class="hover:text-gray-900">Privacy Policy</a>
            <a href="#" class="hover:text-gray-900">Terms of Service</a>
            <a href="#" class="hover:text-gray-900">Contact Support</a>
        </div>
    </footer>
</body>
</html>
