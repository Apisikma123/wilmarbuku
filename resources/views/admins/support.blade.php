@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 py-6">
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Support</h2>
        <p class="text-slate-500 mt-2 text-base">Get help, contact our team, and find useful resources.</p>
    </div>

    <div class="w-full">
        <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-14 h-14 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shadow-sm">
                    <i data-lucide="contact" class="w-7 h-7"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Contact Information</h3>
                    <p class="text-slate-500 text-sm mt-0.5">Get in touch with our team</p>
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
                        <p class="text-slate-900 font-medium">+62 812 3456 7890</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-4 rounded-xl border border-slate-100 hover:border-slate-200 hover:bg-slate-50 transition-colors">
                    <div class="w-10 h-10 rounded-full bg-white shadow-sm border border-slate-200 flex items-center justify-center shrink-0 mt-0.5">
                        <i data-lucide="map-pin" class="w-5 h-5 text-slate-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Alamat</p>
                        <p class="text-slate-900 text-sm leading-relaxed">
                            Gedung Wilmar Lt. 5, Jl. Jend. Sudirman Kav. 1,<br>Jakarta Pusat, DKI Jakarta 10220
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
                    <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center border border-white/20 hover:bg-white/20 hover:text-white hover:-translate-y-1 transition-all" title="Instagram">
                        <i data-lucide="instagram" class="w-5 h-5 text-white/80"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center border border-white/20 hover:bg-white/20 hover:text-white hover:-translate-y-1 transition-all" title="Facebook">
                        <i data-lucide="facebook" class="w-5 h-5 text-white/80"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center border border-white/20 hover:bg-white/20 hover:text-white hover:-translate-y-1 transition-all" title="GitHub">
                        <i data-lucide="github" class="w-5 h-5 text-white/80"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="border-t border-white/10 pt-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex flex-col items-center md:items-start gap-1">
                <p class="text-[10px] md:text-xs text-white/50">&copy; {{ date('Y') }} Wilmar Business Indonesia Polytechnic.</p>
                <span class="text-[10px] font-bold text-white/30 tracking-widest uppercase">Version v1.0.0 (Release)</span>
            </div>
            <div class="flex gap-6 text-[10px] md:text-xs text-white/50">
                <a class="hover:text-white transition-colors" href="/terms">Terms of Service</a>
                <a class="hover:text-white transition-colors" href="/cookie-policy">Cookie Policy</a>
            </div>
        </div>
    </div>
</div>
@endsection
