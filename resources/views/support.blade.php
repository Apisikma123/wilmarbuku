@extends('layouts.user')

@section('content')
<div class="px-6 md:px-12 xl:px-24 max-w-[1280px] mx-auto py-10">
    <!-- Header Section -->
    <div class="mb-10">
        <h1 class="text-3xl font-bold font-display text-on-surface tracking-tight mb-2">Support</h1>
        <p class="text-on-surface-variant font-medium text-sm md:text-base max-w-2xl">Get help, contact our team, and find useful resources.</p>
    </div>

    <!-- Content Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/30 p-6 md:p-8">
        
        <div class="flex items-center gap-4 mb-8">
            <div class="w-14 h-14 bg-surface-container-low rounded-xl flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[28px]">contact_support</span>
            </div>
            <div>
                <h2 class="text-xl font-bold text-on-surface mb-1">Contact Information</h2>
                <p class="text-sm text-on-surface-variant font-medium">Get in touch with our team</p>
            </div>
        </div>

        <div class="space-y-4">
            
            
            
            <!-- Telepon -->
            <div class="flex items-center gap-4 bg-surface-bright rounded-xl p-5 border border-outline-variant/30">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm border border-outline-variant/30 shrink-0">
                    <span class="material-symbols-outlined text-outline">call</span>
                </div>
                <div>
                    <p class="text-[10px] uppercase font-bold text-on-surface-variant tracking-wider mb-0.5">TELEPON</p>
                    <p class="text-base font-semibold text-on-surface">(061) 42074111</p>
                </div>
            </div>
            
            <!-- Alamat -->
            <div class="flex items-center gap-4 bg-surface-bright rounded-xl p-5 border border-outline-variant/30">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm border border-outline-variant/30 shrink-0">
                    <span class="material-symbols-outlined text-outline">location_on</span>
                </div>
                <div>
                    <p class="text-[10px] uppercase font-bold text-on-surface-variant tracking-wider mb-0.5">ALAMAT</p>
                    <p class="text-sm font-medium text-on-surface leading-relaxed">
                        Laut Dendang, Jl. Warakauri, Kenangan, Kec. Percut Sei Tuan,
                        Kabupaten Deli Serdang,
                        Sumatera Utara 20371
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
