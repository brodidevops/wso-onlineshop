<?php

namespace Database\Seeders;

use App\Models\StoreSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // ==================== GENERAL ====================
            [
                'group' => 'general',
                'key' => 'store_name',
                'value' => 'Toko Online',
                'type' => 'text',
                'label' => 'Nama Toko',
                'description' => 'Nama toko Anda',
                'is_active' => true,
                'sort' => 1,
            ],
            [
                'group' => 'general',
                'key' => 'store_tagline',
                'value' => 'Belanja Mudah, Hemat, Terpercaya',
                'type' => 'text',
                'label' => 'Tagline',
                'description' => 'Tagline atau slogan toko',
                'is_active' => true,
                'sort' => 2,
            ],
            [
                'group' => 'general',
                'key' => 'store_description',
                'value' => 'Platform belanja online terpercaya dengan berbagai pilihan produk berkualitas untuk kebutuhan Anda.',
                'type' => 'textarea',
                'label' => 'Deskripsi Toko',
                'description' => 'Deskripsi singkat tentang toko',
                'is_active' => true,
                'sort' => 3,
            ],
            [
                'group' => 'general',
                'key' => 'store_email',
                'value' => 'info@tokoonline.com',
                'type' => 'email',
                'label' => 'Email Toko',
                'description' => 'Email resmi toko',
                'is_active' => true,
                'sort' => 4,
            ],
            [
                'group' => 'general',
                'key' => 'store_phone',
                'value' => '+62 123 4567 890',
                'type' => 'phone',
                'label' => 'Nomor Telepon',
                'description' => 'Nomor telepon yang dapat dihubungi',
                'is_active' => true,
                'sort' => 5,
            ],
            [
                'group' => 'general',
                'key' => 'store_whatsapp',
                'value' => '6281234567890',
                'type' => 'phone',
                'label' => 'WhatsApp',
                'description' => 'Nomor WhatsApp (dengan kode negara, contoh: 6281234567890)',
                'is_active' => true,
                'sort' => 6,
            ],

            // ==================== APPEARANCE ====================
            [
                'group' => 'appearance',
                'key' => 'logo_header',
                'value' => null,
                'type' => 'image',
                'label' => 'Logo Header',
                'description' => 'Logo yang ditampilkan di header/navbar (rekomendasi: PNG dengan transparan)',
                'is_active' => true,
                'sort' => 1,
            ],
            [
                'group' => 'appearance',
                'key' => 'logo_footer',
                'value' => null,
                'type' => 'image',
                'label' => 'Logo Footer',
                'description' => 'Logo yang ditampilkan di footer',
                'is_active' => true,
                'sort' => 2,
            ],
            [
                'group' => 'appearance',
                'key' => 'favicon',
                'value' => null,
                'type' => 'image',
                'label' => 'Favicon',
                'description' => 'Ikon kecil yang tampil di tab browser (rekomendasi: ICO/PNG 32x32 atau 64x64)',
                'is_active' => true,
                'sort' => 3,
            ],
            [
                'group' => 'appearance',
                'key' => 'og_image',
                'value' => null,
                'type' => 'image',
                'label' => 'Open Graph Image',
                'description' => 'Gambar untuk Open Graph (Facebook/WhatsApp share). Rekomendasi: 1200x630px',
                'is_active' => true,
                'sort' => 4,
            ],
            [
                'group' => 'appearance',
                'key' => 'primary_color',
                'value' => '#1A1A1A',
                'type' => 'color',
                'label' => 'Warna Utama',
                'description' => 'Warna utama situs (hex code)',
                'is_active' => true,
                'sort' => 5,
            ],

            // ==================== CONTACT & ADDRESS ====================
            [
                'group' => 'contact',
                'key' => 'store_address',
                'value' => 'Jakarta, Indonesia',
                'type' => 'textarea',
                'label' => 'Alamat Toko',
                'description' => 'Alamat lengkap toko',
                'is_active' => true,
                'sort' => 1,
            ],
            [
                'group' => 'contact',
                'key' => 'store_city',
                'value' => 'Jakarta',
                'type' => 'text',
                'label' => 'Kota',
                'description' => 'Kota lokasi toko',
                'is_active' => true,
                'sort' => 2,
            ],
            [
                'group' => 'contact',
                'key' => 'store_province',
                'value' => 'DKI Jakarta',
                'type' => 'text',
                'label' => 'Provinsi',
                'description' => 'Provinsi lokasi toko',
                'is_active' => true,
                'sort' => 3,
            ],
            [
                'group' => 'contact',
                'key' => 'store_postal_code',
                'value' => '12345',
                'type' => 'text',
                'label' => 'Kode Pos',
                'description' => 'Kode pos toko',
                'is_active' => true,
                'sort' => 4,
            ],
            [
                'group' => 'contact',
                'key' => 'store_maps_embed',
                'value' => null,
                'type' => 'textarea',
                'label' => 'Google Maps Embed',
                'description' => 'Kode embed Google Maps untuk lokasi toko',
                'is_active' => true,
                'sort' => 5,
            ],

            // ==================== SOCIAL MEDIA ====================
            [
                'group' => 'social',
                'key' => 'social_facebook',
                'value' => null,
                'type' => 'url',
                'label' => 'Facebook',
                'description' => 'URL halaman Facebook',
                'is_active' => true,
                'sort' => 1,
            ],
            [
                'group' => 'social',
                'key' => 'social_instagram',
                'value' => null,
                'type' => 'url',
                'label' => 'Instagram',
                'description' => 'URL akun Instagram',
                'is_active' => true,
                'sort' => 2,
            ],
            [
                'group' => 'social',
                'key' => 'social_twitter',
                'value' => null,
                'type' => 'url',
                'label' => 'Twitter/X',
                'description' => 'URL akun Twitter/X',
                'is_active' => true,
                'sort' => 3,
            ],
            [
                'group' => 'social',
                'key' => 'social_tiktok',
                'value' => null,
                'type' => 'url',
                'label' => 'TikTok',
                'description' => 'URL akun TikTok',
                'is_active' => true,
                'sort' => 4,
            ],
            [
                'group' => 'social',
                'key' => 'social_youtube',
                'value' => null,
                'type' => 'url',
                'label' => 'YouTube',
                'description' => 'URL channel YouTube',
                'is_active' => true,
                'sort' => 5,
            ],

            // ==================== SEO ====================
            [
                'group' => 'seo',
                'key' => 'seo_meta_title',
                'value' => 'Toko Online - Belanja Online Terpercaya',
                'type' => 'text',
                'label' => 'Meta Title',
                'description' => 'Judul untuk SEO (max 60 karakter)',
                'is_active' => true,
                'sort' => 1,
            ],
            [
                'group' => 'seo',
                'key' => 'seo_meta_description',
                'value' => 'Platform belanja online terpercaya dengan berbagai pilihan produk berkualitas untuk kebutuhan Anda.',
                'type' => 'textarea',
                'label' => 'Meta Description',
                'description' => 'Deskripsi untuk SEO (max 160 karakter)',
                'is_active' => true,
                'sort' => 2,
            ],
            [
                'group' => 'seo',
                'key' => 'seo_keywords',
                'value' => 'toko online, belanja online, ecommerce, produk berkualitas',
                'type' => 'text',
                'label' => 'Meta Keywords',
                'description' => 'Kata kunci untuk SEO (pisahkan dengan koma)',
                'is_active' => true,
                'sort' => 3,
            ],
            [
                'group' => 'seo',
                'key' => 'seo_google_analytics',
                'value' => null,
                'type' => 'textarea',
                'label' => 'Google Analytics ID',
                'description' => 'ID Google Analytics (contoh: G-XXXXXXXXXX)',
                'is_active' => true,
                'sort' => 4,
            ],
        ];

        foreach ($settings as $setting) {
            StoreSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
