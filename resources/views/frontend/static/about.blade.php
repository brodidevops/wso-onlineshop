@extends('frontend.layouts.app')

@section('title', 'Tentang Kami - Toko Online')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center gap-2 text-sm">
                <li>
                    <a href="{{ route('home') }}" class="text-mist hover:text-ink transition-colors">Beranda</a>
                </li>
                <li class="text-pearl">/</li>
                <li class="text-ink font-medium">Tentang Kami</li>
            </ol>
        </nav>

        <!-- Hero Section -->
        <div class="text-center mb-16">
            <h1 class="text-3xl md:text-4xl font-bold text-ink mb-4">Tentang Kami</h1>
            <p class="text-silver max-w-2xl mx-auto leading-relaxed">
                Toko Online adalah platform belanja online terpercaya yang menghadirkan produk berkualitas untuk kebutuhan sehari-hari Anda.
            </p>
        </div>

        <!-- Main Content -->
        <div class="grid md:grid-cols-2 gap-12 items-center mb-16">
            <div>
                <div class="bg-stone-100 rounded-2xl p-10 aspect-square flex items-center justify-center">
                    <svg class="w-32 h-32 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-ink mb-4">Cerita Kami</h2>
                <p class="text-silver leading-relaxed mb-4">
                    Didirikan pada tahun 2024, Toko Online bermula dari visi sederhana: memberikan pengalaman belanja online yang mudah, aman, dan menyenangkan bagi masyarakat Indonesia.
                </p>
                <p class="text-silver leading-relaxed mb-4">
                    Kami percaya bahwa belanja online seharusnya mudah dan menyenangkan. Dengan komitmen kami terhadap kualitas produk, harga kompetitif, dan layanan pelanggan yang prima, kami berusaha menjadi pilihan utama bagi kebutuhan belanja online Anda.
                </p>
                <p class="text-silver leading-relaxed">
                    Setiap hari, kami bekerja keras untuk memastikan setiap pelanggan mendapatkan pengalaman terbaik dari awal hingga akhir perjalanan belanja mereka.
                </p>
            </div>
        </div>

        <!-- Values -->
        <div class="mb-16">
            <div class="text-center mb-10">
                <h2 class="text-2xl font-bold text-ink mb-3">Nilai-Nilai Kami</h2>
                <div class="w-12 h-0.5 bg-ink mx-auto"></div>
            </div>

            <div class="grid md:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl border border-stone-200 p-6 text-center">
                    <div class="w-12 h-12 mx-auto mb-4 bg-stone-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-ink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-ink mb-2">Kualitas</h3>
                    <p class="text-sm text-silver">Hanya produk berkualitas tinggi yang lolos standar kami</p>
                </div>

                <div class="bg-white rounded-xl border border-stone-200 p-6 text-center">
                    <div class="w-12 h-12 mx-auto mb-4 bg-stone-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-ink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-ink mb-2">Terjangkau</h3>
                    <p class="text-sm text-silver">Harga kompetitif dengan berbagai pilihan payment</p>
                </div>

                <div class="bg-white rounded-xl border border-stone-200 p-6 text-center">
                    <div class="w-12 h-12 mx-auto mb-4 bg-stone-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-ink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-ink mb-2">Cepat</h3>
                    <p class="text-sm text-silver">Pengiriman cepat ke seluruh Indonesia</p>
                </div>

                <div class="bg-white rounded-xl border border-stone-200 p-6 text-center">
                    <div class="w-12 h-12 mx-auto mb-4 bg-stone-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-ink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-ink mb-2">Peduli</h3>
                    <p class="text-sm text-silver">Layanan pelanggan yang ramah dan responsif</p>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="bg-ink rounded-2xl p-10 mb-16">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <p class="text-3xl md:text-4xl font-bold text-white mb-1">100+</p>
                    <p class="text-sm text-stone-400">Produk</p>
                </div>
                <div>
                    <p class="text-3xl md:text-4xl font-bold text-white mb-1">50+</p>
                    <p class="text-sm text-stone-400">Kategori</p>
                </div>
                <div>
                    <p class="text-3xl md:text-4xl font-bold text-white mb-1">10K+</p>
                    <p class="text-sm text-stone-400">Pelanggan</p>
                </div>
                <div>
                    <p class="text-3xl md:text-4xl font-bold text-white mb-1">99%</p>
                    <p class="text-sm text-stone-400">Kepuasan</p>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="mb-16">
            <div class="text-center mb-10">
                <h2 class="text-2xl font-bold text-ink mb-3">Tim Kami</h2>
                <div class="w-12 h-0.5 bg-ink mx-auto mb-4"></div>
                <p class="text-silver max-w-xl mx-auto">Bertemu dengan tim profesional kami yang berdedikasi untuk memberikan pengalaman terbaik bagi Anda.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-24 h-24 mx-auto mb-4 bg-stone-100 rounded-full flex items-center justify-center">
                        <span class="text-3xl font-bold text-stone-400">JD</span>
                    </div>
                    <h3 class="font-semibold text-ink mb-1">John Doe</h3>
                    <p class="text-sm text-mist mb-2">Chief Executive Officer</p>
                    <p class="text-xs text-silver"> visioner di balik Toko Online dengan pengalaman lebih dari 10 tahun di industri e-commerce</p>
                </div>

                <div class="text-center">
                    <div class="w-24 h-24 mx-auto mb-4 bg-stone-100 rounded-full flex items-center justify-center">
                        <span class="text-3xl font-bold text-stone-400">JS</span>
                    </div>
                    <h3 class="font-semibold text-ink mb-1">Jane Smith</h3>
                    <p class="text-sm text-mist mb-2">Chief Operating Officer</p>
                    <p class="text-xs text-silver">memastikan setiap operasional berjalan lancar dan efisien</p>
                </div>

                <div class="text-center">
                    <div class="w-24 h-24 mx-auto mb-4 bg-stone-100 rounded-full flex items-center justify-center">
                        <span class="text-3xl font-bold text-stone-400">AK</span>
                    </div>
                    <h3 class="font-semibold text-ink mb-1">Ahmad Khan</h3>
                    <p class="text-sm text-mist mb-2">Head of Technology</p>
                    <p class="text-xs text-silver">memimpin pengembangan platform teknologi kami</p>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="bg-stone-100 rounded-2xl p-10 text-center">
            <h2 class="text-2xl font-bold text-ink mb-3">Siap Berbelanja?</h2>
            <p class="text-silver mb-6 max-w-lg mx-auto">Jelajahi koleksi produk kami dan temukan apa yang Anda butuhkan. Daftar sekarang dan nikmati berbagai promo eksklusif!</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 bg-ink text-white font-medium rounded-lg hover:bg-graphite transition-colors">
                    Mulai Belanja
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
@endsection