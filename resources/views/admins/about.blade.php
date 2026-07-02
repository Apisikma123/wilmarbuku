@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 py-6">
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-900 tracking-tight">About Application</h2>
        <p class="text-slate-500 mt-2 text-base">Learn more about our application, how to reach us, and follow our updates.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Application Information -->
        <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-14 h-14 rounded-xl bg-green-50 border border-green-100 flex items-center justify-center text-green-600 shadow-sm">
                    <i data-lucide="laptop" class="w-7 h-7"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Application Information</h3>
                    <p class="text-slate-500 text-sm mt-0.5">System details & specifications</p>
                </div>
            </div>
            <div class="space-y-5">
                <!-- Logo & Nama -->
                <div class="flex items-start gap-4 p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <div class="w-12 h-12 bg-white rounded-lg shadow-sm flex items-center justify-center border border-slate-200 shrink-0">
                        <i data-lucide="book" class="w-6 h-6 text-green-700"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Nama Aplikasi</p>
                        <p class="text-slate-900 font-bold text-lg">Wilmar Buku Hub</p>
                    </div>
                </div>
                
                <!-- Deskripsi -->
                <div>
                    <p class="text-sm text-slate-500 font-medium mb-1.5 flex items-center gap-2">
                        <i data-lucide="file-text" class="w-4 h-4 text-slate-400"></i> Deskripsi
                    </p>
                    <p class="text-slate-700 leading-relaxed text-sm bg-white border border-slate-100 p-4 rounded-xl shadow-sm">
                        Platform manajemen perpustakaan digital untuk memudahkan pencatatan, peminjaman, dan pengelolaan buku secara efisien dan terintegrasi.
                    </p>
                </div>
                
                <!-- Versi -->
                <div>
                    <p class="text-sm text-slate-500 font-medium mb-1.5 flex items-center gap-2">
                        <i data-lucide="tag" class="w-4 h-4 text-slate-400"></i> Versi
                    </p>
                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-semibold bg-slate-900 text-white shadow-sm">
                        v1.0.0 (Release)
                    </span>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
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

    <!-- Integrated Green Footer with Social Media -->
    <div class="mt-8 bg-green-800 rounded-2xl p-8 shadow-lg text-white">
        <div class="flex flex-col md:flex-row justify-between items-start gap-8">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-green-700/60 rounded-xl flex items-center justify-center border border-green-600/50">
                    <i data-lucide="book-open" class="w-7 h-7 text-green-50"></i>
                </div>
                <div>
                    <h4 class="font-bold text-xl text-white">Wilmar Buku Hub</h4>
                    <p class="text-sm text-green-200 mt-0.5">Empowering minds through knowledge.</p>
                </div>
            </div>
            
            <div class="flex flex-col md:items-end gap-6">
                <!-- Quick Links -->
                <div class="flex flex-wrap gap-6">
                    <a href="#" class="text-sm font-medium text-green-100 hover:text-white transition-colors">Terms of Service</a>
                    <a href="#" class="text-sm font-medium text-green-100 hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="text-sm font-medium text-green-100 hover:text-white transition-colors">Help Center</a>
                </div>
                
                <!-- Social Media Icons -->
                <div class="flex items-center gap-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-green-700/60 flex items-center justify-center border border-green-600/50 hover:bg-green-600 hover:border-green-400 hover:text-white hover:-translate-y-1 transition-all" title="Instagram">
                        <i data-lucide="instagram" class="w-5 h-5 text-green-100"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-green-700/60 flex items-center justify-center border border-green-600/50 hover:bg-green-600 hover:border-green-400 hover:text-white hover:-translate-y-1 transition-all" title="Facebook">
                        <i data-lucide="facebook" class="w-5 h-5 text-green-100"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-green-700/60 flex items-center justify-center border border-green-600/50 hover:bg-green-600 hover:border-green-400 hover:text-white hover:-translate-y-1 transition-all" title="GitHub">
                        <i data-lucide="github" class="w-5 h-5 text-green-100"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="mt-8 pt-8 border-t border-green-700 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-sm text-green-200 font-medium">
                &copy; {{ date('Y') }} Wilmar Group. All rights reserved.
            </p>
            <div class="flex items-center gap-2 text-sm text-green-200 font-medium">
                Made with <i data-lucide="heart" class="w-4 h-4 text-red-400 fill-red-400 mx-1"></i> for our community
            </div>
        </div>
    </div>
</div>
@endsection
