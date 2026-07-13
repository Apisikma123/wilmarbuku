<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP Reset Password - WilmarBOOKS</title>
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
<body class="bg-pattern min-h-screen flex flex-col justify-between">
    
    <div class="flex-grow flex items-center justify-center p-6">
        <div class="bg-white p-8 md:p-10 rounded-2xl shadow-[0_0_40px_rgba(0,0,0,0.05)] max-w-md w-full relative z-10">
            <!-- Back Button -->
            <a href="{{ route('password.request') }}" class="absolute top-6 left-6 text-gray-400 hover:text-primary transition-colors flex items-center justify-center p-2 rounded-full hover:bg-gray-50" title="Kembali">
                <span class="material-symbols-outlined text-xl">arrow_back</span>
            </a>

            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/wil.png') }}" alt="Wilmar Logo" class="h-12 object-contain">
            </div>
            
            <!-- Headers -->
            <div class="text-center mb-8">
                <h1 class="text-xl font-bold text-primary mb-2">Verifikasi Email</h1>
                <p class="text-sm text-gray-500">Kami telah mengirimkan 6 digit kode OTP ke email Anda untuk mereset kata sandi.</p>
            </div>

            <!-- Form -->
            <form action="{{ route('password.otp.verify') }}" method="POST" class="space-y-5">
                @csrf
                
                @if($errors->any())
                <div class="bg-red-50 text-red-500 text-sm p-3 rounded-lg border border-red-100">
                    {{ $errors->first() }}
                </div>
                @endif
                
                @if(session('status'))
                <div class="bg-green-50 text-green-600 text-sm p-3 rounded-lg border border-green-100">
                    {{ session('status') }}
                </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode OTP (6 Digit)</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xl">pin</span>
                        <input type="text" name="otp_code" class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-sm text-center tracking-[0.5em] font-bold text-lg" placeholder="••••••" maxlength="6" required autofocus>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-primary text-white font-semibold py-3 rounded-lg hover:bg-primary/90 transition-colors flex items-center justify-center gap-2 shadow-sm">
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                        Verifikasi OTP
                    </button>
                </div>
            </form>

            <div class="text-center mt-8 text-sm">
                <form action="{{ route('password.otp.resend') }}" method="POST" id="resendForm">
                    @csrf
                    <span class="text-gray-600">Belum menerima kode?</span> 
                    <button type="submit" id="resendButton" class="text-secondary font-bold hover:underline disabled:opacity-50 disabled:cursor-not-allowed disabled:no-underline ml-1" {{ $cooldown > 0 ? 'disabled' : '' }}>
                        Kirim Ulang OTP <span id="countdownText" class="{{ $cooldown > 0 ? '' : 'hidden' }}">(<span id="timer">{{ $cooldown }}</span>s)</span>
                    </button>
                </form>
            </div>
            
            <script>
                let cooldown = {{ $cooldown }};
                const resendButton = document.getElementById('resendButton');
                const countdownText = document.getElementById('countdownText');
                const timerSpan = document.getElementById('timer');

                if (cooldown > 0) {
                    const interval = setInterval(() => {
                        cooldown--;
                        timerSpan.textContent = cooldown;
                        
                        if (cooldown <= 0) {
                            clearInterval(interval);
                            resendButton.disabled = false;
                            countdownText.classList.add('hidden');
                        }
                    }, 1000);
                }
            </script>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-[#e2e8f0]/60 border-t border-gray-200 py-8 px-6 md:px-12 text-sm text-gray-600 flex flex-col md:flex-row items-center justify-between gap-4">
        <p class="font-bold text-gray-800">
            &copy; {{ date('Y') }} Wilmar Business Indonesia Polytechnic. Nurturing Entrepreneurs.
        </p>
    </footer>
</body>
</html>
