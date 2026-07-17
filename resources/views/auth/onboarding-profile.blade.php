<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Profil - WilmarBOOKS</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between relative bg-cover bg-center bg-no-repeat bg-fixed" style="background-image: url('{{ asset('images/Login-Background.png') }}');">
    <div class="absolute inset-0 bg-black/10 z-0 pointer-events-none"></div>
    
    <div class="flex-grow flex items-center justify-center p-0 md:p-6">
        <div class="bg-white/85 backdrop-blur-md border-0 md:border md:border-white/40 p-6 sm:p-8 md:p-10 rounded-none md:rounded-2xl shadow-none md:shadow-[0_8px_32px_rgba(0,0,0,0.1)] max-w-md w-full min-h-screen md:min-h-0 flex flex-col justify-center relative z-10">
            
            <a href="{{ url('/') }}" class="absolute top-8 left-8 text-gray-400 hover:text-primary transition-transform hover:-translate-x-1 flex items-center justify-center p-2 -ml-2 -mt-2">
                <span class="material-symbols-outlined text-[24px]">arrow_back</span>
            </a>

            <!-- Logo -->
            <div class="flex justify-center mb-6 mt-2">
                <img src="{{ asset('images/wil.png') }}" alt="Wilmar Logo" class="h-12 object-contain">
            </div>
            
            <!-- Headers -->
            <div class="text-center mb-8">
                <h1 class="text-xl font-bold text-primary mb-2">Lengkapi Profil Anda</h1>
                <p class="text-sm text-gray-500">Konfirmasi nama Anda dan beri tahu kami status Anda.</p>
            </div>

            <!-- Form -->
            <form action="{{ route('onboarding.profile.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap / Username</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xl">person</span>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" maxlength="50" class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-sm" required>
                    </div>
                    <p class="text-xs text-yellow-600 mt-1 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">info</span>
                        Mohon gunakan nama asli anda
                    </p>
                    @error('nama_lengkap') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <label class="block text-sm font-medium text-gray-700 mb-3 text-center">Apakah Anda Mahasiswa WBI?</label>
                    <div class="flex flex-col gap-3">
                        <button type="submit" name="is_student" value="1" class="w-full bg-primary text-white font-semibold py-3 rounded-lg hover:bg-primary/90 transition-colors flex items-center justify-center gap-2 shadow-sm">
                            <span class="material-symbols-outlined text-lg">school</span>
                            Ya, Saya Mahasiswa WBI
                        </button>
                        <button type="submit" name="is_student" value="0" class="w-full bg-white text-gray-700 border border-gray-300 font-semibold py-3 rounded-lg hover:bg-gray-50 transition-colors flex items-center justify-center gap-2 shadow-sm">
                            Lewatkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
