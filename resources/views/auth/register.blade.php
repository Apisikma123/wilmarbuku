<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - WilmarBOOKS</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between relative bg-cover bg-center bg-no-repeat bg-fixed" style="background-image: url('{{ asset('images/Login-Background.png') }}');">
    <div class="absolute inset-0 bg-black/10 z-0 pointer-events-none"></div>
    
    <div class="flex-grow flex items-center justify-center p-0 md:p-6">
        <div class="bg-white/85 backdrop-blur-md border-0 md:border md:border-white/40 p-6 sm:p-8 md:p-10 rounded-none md:rounded-2xl shadow-none md:shadow-[0_8px_32px_rgba(0,0,0,0.1)] max-w-md w-full min-h-screen md:min-h-0 flex flex-col justify-center relative z-10">
            <!-- Back Arrow -->
            <a href="{{ url('/') }}" class="absolute top-8 left-8 text-gray-400 hover:text-primary transition-transform hover:-translate-x-1 flex items-center justify-center p-2 -ml-2 -mt-2">
                <span class="material-symbols-outlined text-[24px]">arrow_back</span>
            </a>

            <!-- Logo -->
            <div class="flex justify-center mb-6 mt-2">
                <img src="{{ asset('images/wil.png') }}" alt="Wilmar Logo" class="h-12 object-contain">
            </div>
            
            <!-- Headers -->
            <div class="text-center mb-8">
                <h1 class="text-xl font-bold text-primary mb-2">Daftar Akun Baru</h1>
                <p class="text-sm text-gray-500">Buat akun untuk mulai berdonasi buku.</p>
            </div>

            <!-- Form -->
            <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xl">person</span>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-sm" placeholder="Masukkan nama lengkap" required>
                    </div>
                    @error('nama_lengkap') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xl">mail</span>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-sm" placeholder="Masukkan email" required>
                    </div>
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>



                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xl">lock</span>
                        <input type="password" name="password" id="password" class="w-full pl-10 pr-10 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-sm" placeholder="Buat kata sandi (min 8 karakter)" required>
                        <button type="button" onclick="toggleVisibility('password', 'toggleIcon1')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none flex items-center justify-center">
                            <span class="material-symbols-outlined text-xl" id="toggleIcon1">visibility</span>
                        </button>
                    </div>
                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xl">lock</span>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full pl-10 pr-10 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-sm" placeholder="Ulangi kata sandi" required>
                        <button type="button" onclick="toggleVisibility('password_confirmation', 'toggleIcon2')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none flex items-center justify-center">
                            <span class="material-symbols-outlined text-xl" id="toggleIcon2">visibility</span>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-primary text-white font-semibold py-3 rounded-lg hover:bg-primary/90 transition-colors flex items-center justify-center gap-2 shadow-sm mt-2">
                    <span class="material-symbols-outlined text-lg">how_to_reg</span>
                    Daftar Sekarang
                </button>
            </form>

            <div class="my-6 flex items-center gap-3">
                <hr class="flex-grow border-gray-200">
                <span class="text-sm text-gray-500">Atau</span>
                <hr class="flex-grow border-gray-200">
            </div>

            <a href="{{ route('auth.google') }}" class="w-full bg-white border border-gray-300 text-gray-700 font-medium py-3 rounded-lg hover:bg-gray-50 transition-colors flex items-center justify-center gap-3 shadow-sm">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5">
                Daftar dengan Google
            </a>

            <p class="text-center text-sm text-gray-600 mt-8">
                Sudah punya akun? <a href="/login" class="text-secondary font-bold hover:underline">Masuk</a>
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

    <script>
        function toggleVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            icon.textContent = type === 'password' ? 'visibility' : 'visibility_off';
        }
    </script>
</body>
</html>
