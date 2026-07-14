<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masukkan NIM - WilmarBOOKS</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <!-- SweetAlert2 for nicer popups -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between relative bg-cover bg-center bg-no-repeat bg-fixed" style="background-image: url('{{ asset('images/Login-Background.png') }}');">
    <div class="absolute inset-0 bg-black/10 z-0 pointer-events-none"></div>
    
    <div class="flex-grow flex items-center justify-center p-0 md:p-6">
        <div class="bg-white/85 backdrop-blur-md border-0 md:border md:border-white/40 p-6 sm:p-8 md:p-10 rounded-none md:rounded-2xl shadow-none md:shadow-[0_8px_32px_rgba(0,0,0,0.1)] max-w-md w-full min-h-screen md:min-h-0 flex flex-col justify-center relative z-10">
            
            <a href="javascript:history.back()" class="absolute top-8 left-8 text-gray-400 hover:text-primary transition-transform hover:-translate-x-1 flex items-center justify-center p-2 -ml-2 -mt-2">
                <span class="material-symbols-outlined text-[24px]">arrow_back</span>
            </a>

            <!-- Logo -->
            <div class="flex justify-center mb-6 mt-2">
                <img src="{{ asset('images/wil.png') }}" alt="Wilmar Logo" class="h-12 object-contain">
            </div>
            
            <!-- Headers -->
            <div class="text-center mb-8">
                <h1 class="text-xl font-bold text-primary mb-2">Masukkan NIM</h1>
                <p class="text-sm text-gray-500">Mohon masukkan Nomor Induk Mahasiswa Anda.</p>
            </div>

            <!-- Form -->
            <form id="nimForm" action="{{ route('onboarding.nim.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIM (Nomor Induk Mahasiswa)</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xl">badge</span>
                        <input type="text" name="identitas_kampus" id="identitas_kampus" maxlength="15" class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-sm" placeholder="Contoh: 12345678" required>
                    </div>
                    @error('identitas_kampus') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <button type="button" onclick="confirmSubmit()" class="w-full bg-primary text-white font-semibold py-3 rounded-lg hover:bg-primary/90 transition-colors flex items-center justify-center gap-2 shadow-sm mt-4">
                    <span class="material-symbols-outlined text-lg">check_circle</span>
                    Lanjutkan
                </button>
            </form>
        </div>
    </div>
    
    <script>
        function confirmSubmit() {
            const nim = document.getElementById('identitas_kampus').value.trim();
            if(!nim) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'NIM tidak boleh kosong!',
                });
                return;
            }

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Pastikan NIM Anda sudah benar',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('nimForm').submit();
                }
            });
        }
    </script>
</body>
</html>
