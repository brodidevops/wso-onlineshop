@extends('frontend.layouts.app')

@section('title', 'Syarat dan Ketentuan - Toko Online')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center gap-2 text-sm">
                <li>
                    <a href="{{ route('home') }}" class="text-mist hover:text-ink transition-colors">Beranda</a>
                </li>
                <li class="text-pearl">/</li>
                <li class="text-ink font-medium">Syarat dan Ketentuan</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-ink mb-3">Syarat dan Ketentuan</h1>
            <p class="text-silver">Terakhir diperbarui: {{ date('d F Y') }}</p>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-xl border border-stone-200 p-8 md:p-10">
            <!-- Introduction -->
            <div class="mb-8">
                <p class="text-silver leading-relaxed">
                    Selamat datang di Toko Online. Dengan mengakses atau menggunakan situs web kami, Anda dianggap telah membaca, memahami, dan menyetujui untuk terikat oleh Syarat dan Ketentuan ini. Jika Anda tidak setuju dengan syarat dan ketentuan ini, mohon untuk tidak menggunakan situs kami.
                </p>
            </div>

            <!-- Section 1 -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-ink mb-4">1. Penerimaan Syarat</h2>
                <p class="text-silver leading-relaxed mb-4">
                    Dengan mengakses atau menggunakan layanan kami, Anda menyatakan bahwa Anda berusia minimal 18 tahun atau memiliki persetujuan orang tua/wali yang sah. Anda bertanggung jawab atas semua aktivitas yang terjadi di bawah akun Anda.
                </p>
            </div>

            <!-- Section 2 -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-ink mb-4">2. Akun Pengguna</h2>
                <ul class="text-silver leading-relaxed space-y-2 list-disc list-inside">
                    <li>Anda bertanggung jawab untuk menjaga kerahasiaan akun dan kata sandi Anda</li>
                    <li>Kami berhak menangguhkan atau menghentikan akun yang melanggar syarat dan ketentuan</li>
                    <li>Anda setuju untuk memberikan informasi yang akurat dan lengkap saat mendaftar</li>
                    <li>Setiap akun bersifat pribadi dan tidak dapat dipindahkan</li>
                </ul>
            </div>

            <!-- Section 3 -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-ink mb-4">3. Pesanan dan Pembayaran</h2>
                <ul class="text-silver leading-relaxed space-y-2 list-disc list-inside">
                    <li>Semua harga yang tertera sudah termasuk pajak kecuali stated otherwise</li>
                    <li>Pembayaran harus dilakukan secara penuh sebelum pesanan diproses</li>
                    <li>Kami berhak membatalkan pesanan jika terdapat kecurangan atau ketidaksesuaian harga</li>
                    <li>Pesanan yang sudah dikonfirmasi tidak dapat dibatalkan kecuali dengan persetujuan kami</li>
                </ul>
            </div>

            <!-- Section 4 -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-ink mb-4">4. Pengiriman</h2>
                <ul class="text-silver leading-relaxed space-y-2 list-disc list-inside">
                    <li>Waktu pengiriman adalah estimasi dan dapat berubah sewaktu-waktu</li>
                    <li>Biaya pengiriman akan disesuaikan berdasarkan lokasi dan berat paket</li>
                    <li>Risiko kehilangan atau kerusakan barang beralih kepada pembeli setelah barang dikirim</li>
                    <li>Kami tidak bertanggung jawab atas keterlambatan yang disebabkan oleh pihak ketiga (kurir)</li>
                </ul>
            </div>

            <!-- Section 5 -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-ink mb-4">5. Pengembalian dan Refund</h2>
                <ul class="text-silver leading-relaxed space-y-2 list-disc list-inside">
                    <li>Produk dapat dikembalikan dalam waktu 7 hari setelah penerimaan dengan kondisi belum digunakan</li>
                    <li>Pengembalian dana akan diproses dalam waktu 7-14 hari kerja setelah produk diterima</li>
                    <li>Biaya pengiriman untuk pengembalian ditanggung oleh pembeli kecuali jika kesalahan ada di pihak kami</li>
                    <li>Produk custom atau yang sudah dimodifikasi tidak dapat dikembalikan</li>
                </ul>
            </div>

            <!-- Section 6 -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-ink mb-4">6. Harga dan Promo</h2>
                <ul class="text-silver leading-relaxed space-y-2 list-disc list-inside">
                    <li>Harga dapat berubah sewaktu-waktu tanpa pemberitahuan sebelumnya</li>
                    <li>Kode promo hanya dapat digunakan sekali per transaksi</li>
                    <li>Promo tidak dapat digabungkan dengan promo lainnya kecuali stated otherwise</li>
                    <li>Kami berhak mengubah atau menghentikan promo kapan saja tanpa pemberitahuan</li>
                </ul>
            </div>

            <!-- Section 7 -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-ink mb-4">7. Hak Kekayaan Intelektual</h2>
                <p class="text-silver leading-relaxed">
                    Semua konten yang ditampilkan di situs ini, termasuk tetapi tidak terbatas pada teks, grafik, logo, gambar, dan perangkat lunak, adalah milik Toko Online atau pemberi lisensinya dan dilindungi oleh hukum hak cipta Indonesia.
                </p>
            </div>

            <!-- Section 8 -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-ink mb-4">8. Batasan Tanggung Jawab</h2>
                <p class="text-silver leading-relaxed">
                    Toko Online tidak bertanggung jawab atas kerusakan langsung, tidak langsung, insidental, atau konsekuensial yang timbul dari penggunaan situs atau layanan kami. Penggunaan situs ini dilakukan atas risiko pengguna sendiri.
                </p>
            </div>

            <!-- Section 9 -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-ink mb-4">9. Perubahan Syarat</h2>
                <p class="text-silver leading-relaxed">
                    Kami berhak untuk mengubah syarat dan ketentuan ini kapan saja tanpa pemberitahuan sebelumnya. Perubahan akan berlaku segera setelah diposting di situs ini. Dengan melanjutkan penggunaan situs setelah perubahan posted, Anda dianggap telah menyetujui perubahan tersebut.
                </p>
            </div>

            <!-- Section 10 -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-ink mb-4">10. Hukum yang Berlaku</h2>
                <p class="text-silver leading-relaxed">
                    Syarat dan ketentuan ini diatur oleh dan ditafsirkan sesuai dengan hukum Republik Indonesia. Setiap perselisihan yang timbul akan diselesaikan melalui negosiasi terlebih dahulu, dan jika tidak berhasil, akan diselesaikan melalui pengadilan yang berwenang di Indonesia.
                </p>
            </div>

            <!-- Contact -->
            <div class="mt-10 pt-8 border-t border-stone-200">
                <p class="text-silver">
                    Jika Anda memiliki pertanyaan tentang Syarat dan Ketentuan ini, silakan hubungi kami di
                    <a href="mailto:info@tokoonline.com" class="text-ink hover:text-graphite transition-colors">info@tokoonline.com</a>.
                </p>
            </div>
        </div>

        <!-- CTA -->
        <div class="mt-8 text-center">
            <p class="text-silver mb-4">Dengan menggunakan layanan kami, Anda menyetujui syarat dan ketentuan di atas.</p>
            <a href="{{ route('home') }}" class="inline-flex items-center text-sm text-silver hover:text-ink transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
@endsection