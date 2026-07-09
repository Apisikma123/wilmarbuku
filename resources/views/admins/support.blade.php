@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 py-6">
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Bantuan</h2>
        <p class="text-slate-500 mt-2 text-base">Dapatkan bantuan, hubungi tim kami, dan temukan sumber daya yang berguna.</p>
    </div>

    <div class="w-full">
        <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-14 h-14 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shadow-sm">
                    <i data-lucide="contact" class="w-7 h-7"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Informasi Kontak</h3>
                    <p class="text-slate-500 text-sm mt-0.5">Hubungi tim kami</p>
                </div>
            </div>
            <div class="space-y-4">
                <div class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 hover:border-slate-200 hover:bg-slate-50 transition-colors">
                    <div class="w-10 h-10 rounded-full bg-white shadow-sm border border-slate-200 flex items-center justify-center shrink-0">
                        <i data-lucide="mail" class="w-5 h-5 text-slate-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Email</p>
                        <a href="mailto:support@wilmarbuku.com" class="text-slate-900 font-medium hover:text-blue-600 transition-colors">support@wilmarbuku.com</a>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 hover:border-slate-200 hover:bg-slate-50 transition-colors">
                    <div class="w-10 h-10 rounded-full bg-white shadow-sm border border-slate-200 flex items-center justify-center shrink-0">
                        <i data-lucide="phone" class="w-5 h-5 text-slate-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Telepon</p>
                        <p class="text-slate-900 font-medium">(061) 42074111</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-4 rounded-xl border border-slate-100 hover:border-slate-200 hover:bg-slate-50 transition-colors">
                    <div class="w-10 h-10 rounded-full bg-white shadow-sm border border-slate-200 flex items-center justify-center shrink-0 mt-0.5">
                        <i data-lucide="map-pin" class="w-5 h-5 text-slate-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Alamat</p>
                        <p class="text-slate-900 text-sm leading-relaxed">
                            Laut Dendang, Jl. Warakauri, Kenangan, Kec. Percut Sei Tuan,<br>Kabupaten Deli Serdang, Sumatera Utara 20371
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="mt-6 bg-[#004b23] rounded-2xl p-6 md:p-8 shadow-lg text-white">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Column 1: Brand Info -->
            <div class="space-y-4">
                <a href="/" class="hover:opacity-90 transition-opacity inline-block">
                    <img src="/images/wil.png" alt="WilmarBOOKS" class="h-10 object-contain bg-white px-3 py-1.5 rounded-lg shadow-sm">
                </a>
                <p class="text-white/80 text-xs md:text-sm leading-relaxed max-w-sm">
                    Platform donasi buku resmi Wilmar Business Indonesia Polytechnic. Nurturing Entrepreneurs through literacy and accessible education.
                </p>
            </div>
            
            <!-- Column 2: Informasi & Social Media -->
            <div>
                <h2 class="text-xs font-bold text-[#fdc34d] mb-4 uppercase tracking-widest">INFORMASI</h2>
                <ul class="space-y-3 mb-6">
                    <li><a class="text-white/70 hover:text-[#fdc34d] transition-colors text-xs md:text-sm" href="/tentang-kami">Tentang Kami</a></li>
                    <li><a class="text-white/70 hover:text-[#fdc34d] transition-colors text-xs md:text-sm" href="/kebijakan-privasi">Kebijakan Privasi</a></li>
                    <li><a class="text-white/70 hover:text-[#fdc34d] transition-colors text-xs md:text-sm" href="/faq">FAQ</a></li>
                </ul>
                
                <!-- Social Media -->
                <div class="flex items-center gap-3">
                    <a href="https://github.com/Apisikma123" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center border border-white/20 hover:bg-white/20 hover:text-white hover:-translate-y-1 transition-all" title="Dev 1 - Apisikma123">
                        <svg class="w-5 h-5 text-white/80" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
                    </a>
                    <a href="https://github.com/M-RapeliHSN" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center border border-white/20 hover:bg-white/20 hover:text-white hover:-translate-y-1 transition-all" title="Dev 2 - M-RapeliHSN">
                        <svg class="w-5 h-5 text-white/80" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
                    </a>
                    <a href="https://github.com/r4hmansun" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center border border-white/20 hover:bg-white/20 hover:text-white hover:-translate-y-1 transition-all" title="Dev 3 - r4hmansun">
                        <svg class="w-5 h-5 text-white/80" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="border-t border-white/10 pt-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex flex-col items-center md:items-start gap-1">
                <p class="text-[10px] md:text-xs text-white/50">&copy; {{ date('Y') }} Wilmar Business Indonesia Polytechnic.</p>
                <span class="text-[10px] font-bold text-white/30 tracking-widest uppercase">Versi v1.0.0 (Rilis)</span>
            </div>
            <div class="flex gap-6 text-[10px] md:text-xs text-white/50">
                <a class="hover:text-white transition-colors" href="/terms">Syarat dan Ketentuan</a>
                <a class="hover:text-white transition-colors" href="/cookie-policy">Kebijakan Cookie</a>
            </div>
        </div>
    </div>
</div>
@endsection
