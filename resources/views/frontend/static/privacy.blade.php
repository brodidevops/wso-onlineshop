@extends('frontend.layouts.app')

@section('title', 'Kebijakan Privasi - Toko Online')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center gap-2 text-sm">
                <li>
                    <a href="{{ route('home') }}" class="text-mist hover:text-ink transition-colors">Beranda</a>
                </li>
                <li class="text-pearl">/</li>
                <li class="text-ink font-medium">Kebijakan Privasi</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-ink mb-3">Kebijakan Privasi</h1>
            <p class="text-silver">Terakhir diperbarui: {{ date('d F Y') }}</p>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-xl border border-stone-200 p-8 md:p-10">
            <!-- Introduction -->
            <div class="mb-8">
                <p class="text-silver leading-relaxed mb-4">
                    Toko Online sangat menghormati privasi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi informasi pribadi Anda ketika Anda menggunakan layanan kami.
                </p>
                <p class="text-silver leading-relaxed">
                    Dengan menggunakan situs dan layanan kami, Anda menyetujui pengumpulan dan penggunaan data sesuai dengan kebijakan ini.
                </p>
            </div>

            <!-- Section 1 -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-ink mb-4">1. Informasi yang Kami Kumpulkan</h2>
                <p class="text-silver leading-relaxed mb-4">Kami mengumpulkan berbagai jenis informasi untuk meningkatkan layanan kami, termasuk:</p>
                <ul class="text-silver leading-relaxed space-y-2 list-disc list-inside">
                    <li><strong>Data Pribadi:</strong> Nama, alamat email, nomor telepon, alamat pengiriman, dan tanggal lahir</li>
                    <li><strong>Data Transaksi:</strong> Riwayat pesanan, informasi pembayaran, dan preferensi belanja</li>
                    <li><strong>Data Teknis:</strong> Alamat IP, jenis browser, sistem operasi, dan aktivitas di situs</li>
                    <li><strong>Data Komunikasi:</strong> Pesan yang Anda kirim kepada kami melalui email atau formulir kontak</li>
                </ul>
            </div>

            <!-- Section 2 -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-ink mb-4">2. Penggunaan Informasi</h2>
                <p class="text-silver leading-relaxed mb-4">Informasi yang kami kumpulkan digunakan untuk:</p>
                <ul class="text-silver leading-relaxed space-y-2 list-disc list-inside">
                    <li>Memproses dan mengelola pesanan Anda</li>
                    <li>Mengirimkan informasi terkait pesanan dan pengiriman</li>
                    <li>Memberikan layanan pelanggan yang responsif</li>
                    <li>Mengirimkan promo dan informasi produk (dengan persetujuan Anda)</li>
                    <li>Memperbaiki dan mengembangkan layanan kami</li>
                    <li>Mencegah penipuan dan menjaga keamanan platform</li>
                    <li>Memenuhi kewajiban hukum dan peraturan yang berlaku</li>
                </ul>
            </div>

            <!-- Section 3 -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-ink mb-4">3. Cookies dan Teknologi Pelacakan</h2>
                <p class="text-silver leading-relaxed mb-4">
                    Kami menggunakan cookies dan teknologi serupa untuk meningkatkan pengalaman browsing Anda:
                </p>
                <ul class="text-silver leading-relaxed space-y-2 list-disc list-inside">
                    <li><strong>Cookies Esensial:</strong> Diperlukan untuk operasi dasar situs</li>
                    <li><strong>Cookies Analitik:</strong> Membantu kami memahami bagaimana pengunjung menggunakan situs</li>
                    <li><strong>Cookies Fungsional:</strong> Menyimpan preferensi Anda untuk pengalaman yang lebih personal</li>
                    <li><strong>Cookies Marketing:</strong> Digunakan untuk menampilkan iklan yang relevan</li>
                </ul>
                <p class="text-silver leading-relaxed mt-4">
                    Anda dapat mengelola preferensi cookies melalui pengaturan browser Anda.
                </p>
            </div>

            <!-- Section 4 -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-ink mb-4">4. Berbagi Informasi</h2>
                <p class="text-silver leading-relaxed mb-4">
                    Kami tidak menjual informasi pribadi Anda kepada pihak ketiga. Namun, kami dapat berbagi informasi dengan:
                </p>
                <ul class="text-silver leading-relaxed space-y-2 list-disc list-inside">
                    <li><strong>Penyedia Layanan:</strong> Perusahaan logistik untuk pengiriman pesanan</li>
                    <li><strong>Prosesor Pembayaran:</strong> Untuk memproses transaksi pembayaran secara aman</li>
                    <li><strong>Mitra Bisnis:</strong> Untuk menyediakan layanan atau promo bersama (dengan persetujuan)</li>
                    <li><strong>Kewajiban Hukum:</strong> Ketika diperlukan oleh hukum atau permintaan resmi</li>
                </ul>
            </div>

            <!-- Section 5 -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-ink mb-4">5. Keamanan Data</h2>
                <p class="text-silver leading-relaxed mb-4">
                    Kami berkomitmen untuk menjaga keamanan data Anda dengan berbagai langkah:
                </p>
                <ul class="text-silver leading-relaxed space-y-2 list-disc list-inside">
                    <li>Penggunaan enkripsi SSL untuk transmisi data</li>
                    <li>Penyimpanan data di server yang aman dengan akses terbatas</li>
                    <li>Pemindaian keamanan rutin untuk mencegah pelanggaran</li>
                    <li>Pelatihan staff tentang praktik keamanan data</li>
                    <li>Pembaruan sistem dan perangkat lunak secara berkala</li>
                </ul>
            </div>

            <!-- Section 6 -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-ink mb-4">6. Hak Anda</h2>
                <p class="text-silver leading-relaxed mb-4">Anda memiliki hak untuk:</p>
                <ul class="text-silver leading-relaxed space-y-2 list-disc list-inside">
                    <li><strong>Akses:</strong> Meminta salinan data pribadi Anda</li>
                    <li><strong>Koreksi:</strong> Memperbaiki data yang tidak akurat</li>
                    <li><strong>Hapus:</strong> Meminta penghapusan data Anda (dengan beberapa pengecualian)</li>
                    <li><strong>Portabilitas:</strong> Mendapatkan data Anda dalam format yang dapat dibaca</li>
                    <li><strong>Menolak:</strong> Menolak penggunaan data untuk pemasaran langsung</li>
                    <li><strong>Pengaduan:</strong> Mengajukan keluhan ke otoritas perlindungan data</li>
                </ul>
            </div>

            <!-- Section 7 -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-ink mb-4">7. Retensi Data</h2>
                <p class="text-silver leading-relaxed">
                    Kami menyimpan data pribadi Anda hanya selama diperlukan untuk tujuan yang dijelaskan dalam kebijakan ini. Data akun akan disimpan selama akun Anda aktif, dan data transaksi akan disimpan sesuai dengan ketentuan peraturan perundang-undangan yang berlaku di Indonesia.
                </p>
            </div>

            <!-- Section 8 -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-ink mb-4">8. Anak-Anak</h2>
                <p class="text-silver leading-relaxed">
                    Layanan kami tidak ditujukan untuk anak-anak di bawah 18 tahun. Kami tidak secara sadar mengumpulkan informasi pribadi dari anak-anak. Jika kami mengetahui bahwa kami telah mengumpulkan data dari anak-anak, kami akan segera menghapusnya.
                </p>
            </div>

            <!-- Section 9 -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-ink mb-4">9. Perubahan Kebijakan</h2>
                <p class="text-silver leading-relaxed">
                    Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Perubahan akan di posting di halaman ini dengan tanggal revision yang diperbarui. Kami encourage Anda untuk revisar kebijakan ini secara berkala untuk tetap informed tentang bagaimana kami melindungi informasi Anda.
                </p>
            </div>

            <!-- Section 10 -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-ink mb-4">10. Hubungi Kami</h2>
                <p class="text-silver leading-relaxed">
                    Jika Anda memiliki pertanyaan, kekhawatiran, atau permintaan terkait Kebijakan Privasi ini, jangan ragu untuk menghubungi kami:
                </p>
                <div class="mt-4 p-4 bg-stone-50 rounded-lg border border-stone-200">
                    <p class="text-silver mb-2"><strong>Toko Online</strong></p>
                    <p class="text-silver mb-1">Email: <a href="mailto:privacy@tokoonline.com" class="text-ink hover:text-graphite transition-colors">privacy@tokoonline.com</a></p>
                    <p class="text-silver mb-1">Telepon: +62 123 4567 890</p>
                    <p class="text-silver">Alamat: Jakarta, Indonesia</p>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="mt-8 text-center">
            <p class="text-silver mb-4">Terima kasih telah mempercayai Toko Online dengan data Anda.</p>
            <a href="{{ route('home') }}" class="inline-flex items-center text-sm text-silver hover:text-ink transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
@endsection