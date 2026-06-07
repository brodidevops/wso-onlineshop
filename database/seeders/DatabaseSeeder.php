<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\City;
use App\Models\Province;
use App\Models\Product;
use App\Models\PaymentSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::updateOrCreate(
            ['email' => 'adminwebsite@websiaponline.com'],
            [
                'name' => 'Admin Website',
                'email' => 'adminwebsite@websiaponline.com',
                'password' => Hash::make('Passw@rdku'),
                'email_verified_at' => now(),
            ]
        );

        // Create Payment Settings
        PaymentSetting::updateOrCreate(
            ['id' => 1],
            [
                'midtrans_enabled' => true,
                'manual_transfer_enabled' => true,
                'bank_name' => 'Bank BCA',
                'bank_account_number' => '1234567890',
                'bank_account_holder' => 'Toko Online',
                'payment_instructions' => 'Silakan transfer ke rekening di atas dan upload bukti transfer setelah pembayaran.',
            ]
        );

        // Create Categories
        $categories = [
            ['name' => 'Fashion Pria', 'slug' => 'fashion-pria', 'icon' => '👔', 'description' => 'Pakaian dan aksesoris untuk pria'],
            ['name' => 'Fashion Wanita', 'slug' => 'fashion-wanita', 'icon' => '👗', 'description' => 'Pakaian dan aksesoris untuk wanita'],
            ['name' => 'Elektronik', 'slug' => 'elektronik', 'icon' => '📱', 'description' => 'Gadget dan perangkat elektronik'],
            ['name' => 'Rumah Tangga', 'slug' => 'rumah-tangga', 'icon' => '🏠', 'description' => 'Perlengkapan rumah tangga'],
            ['name' => 'Olahraga', 'slug' => 'olahraga', 'icon' => '⚽', 'description' => 'Peralatan dan apparel olahraga'],
            ['name' => 'Kecantikan', 'slug' => 'kecantikan', 'icon' => '💄', 'description' => 'Produk perawatan dan kecantikan'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // Create Provinces
        $provinces = [
            ['id' => 1, 'name' => 'DKI Jakarta'],
            ['id' => 2, 'name' => 'Jawa Barat'],
            ['id' => 3, 'name' => 'Jawa Tengah'],
            ['id' => 4, 'name' => 'Jawa Timur'],
            ['id' => 5, 'name' => 'Sumatera Utara'],
            ['id' => 6, 'name' => 'Bali'],
            ['id' => 7, 'name' => 'Sulawesi Selatan'],
            ['id' => 8, 'name' => 'Kalimantan Timur'],
        ];

        foreach ($provinces as $prov) {
            Province::updateOrCreate(['id' => $prov['id']], $prov);
        }

        // Create Cities
        $cities = [
            ['province_id' => 1, 'type' => 'Kota', 'name' => 'Jakarta Pusat', 'postal_code' => '10110'],
            ['province_id' => 1, 'type' => 'Kota', 'name' => 'Jakarta Selatan', 'postal_code' => '12190'],
            ['province_id' => 1, 'type' => 'Kota', 'name' => 'Jakarta Barat', 'postal_code' => '11460'],
            ['province_id' => 1, 'type' => 'Kota', 'name' => 'Jakarta Timur', 'postal_code' => '13910'],
            ['province_id' => 1, 'type' => 'Kota', 'name' => 'Jakarta Utara', 'postal_code' => '14140'],
            ['province_id' => 2, 'type' => 'Kota', 'name' => 'Bandung', 'postal_code' => '40111'],
            ['province_id' => 2, 'type' => 'Kabupaten', 'name' => 'Bekasi', 'postal_code' => '17111'],
            ['province_id' => 3, 'type' => 'Kota', 'name' => 'Semarang', 'postal_code' => '50111'],
            ['province_id' => 3, 'type' => 'Kota', 'name' => 'Solo', 'postal_code' => '57111'],
            ['province_id' => 4, 'type' => 'Kota', 'name' => 'Surabaya', 'postal_code' => '60111'],
            ['province_id' => 4, 'type' => 'Kota', 'name' => 'Malang', 'postal_code' => '65111'],
            ['province_id' => 5, 'type' => 'Kota', 'name' => 'Medan', 'postal_code' => '20111'],
            ['province_id' => 6, 'type' => 'Kota', 'name' => 'Denpasar', 'postal_code' => '80111'],
            ['province_id' => 7, 'type' => 'Kota', 'name' => 'Makassar', 'postal_code' => '90111'],
            ['province_id' => 8, 'type' => 'Kota', 'name' => 'Samarinda', 'postal_code' => '75111'],
        ];

        foreach ($cities as $city) {
            City::updateOrCreate([
                'province_id' => $city['province_id'],
                'name' => $city['name'],
            ], $city);
        }

        // Create Sample Products
        $fashionPria = Category::where('slug', 'fashion-pria')->first();
        $fashionWanita = Category::where('slug', 'fashion-wanita')->first();
        $elektronik = Category::where('slug', 'elektronik')->first();
        $rumahTangga = Category::where('slug', 'rumah-tangga')->first();
        $olahraga = Category::where('slug', 'olahraga')->first();
        $kecantikan = Category::where('slug', 'kecantikan')->first();

        $products = [
            [
                'category_id' => $fashionPria->id,
                'name' => 'Kemeja Lengan Panjang Premium Cotton',
                'slug' => Str::slug('Kemeja Lengan Panjang Premium Cotton'),
                'description' => 'Kemeja formal casual dengan bahan premium cotton 100%. Nyaman dipakai sehari-hari.',
                'price' => 289000,
                'original_price' => 350000,
                'weight' => 300,
                'stock' => 50,
                'is_active' => true,
                'is_featured' => true,
                'sku' => 'KME001',
            ],
            [
                'category_id' => $fashionPria->id,
                'name' => 'Jaket Kulit Sintetis Premium',
                'slug' => Str::slug('Jaket Kulit Sintetis Premium'),
                'description' => 'Jaket kulit sintetis dengan desain modern dan elegan.',
                'price' => 450000,
                'original_price' => 550000,
                'weight' => 800,
                'stock' => 25,
                'is_active' => true,
                'is_featured' => true,
                'sku' => 'JKT001',
            ],
            [
                'category_id' => $fashionPria->id,
                'name' => 'Celana Chino Slim Fit',
                'slug' => Str::slug('Celana Chino Slim Fit'),
                'description' => 'Celana chino dengan potongan slim fit yang stylish dan nyaman.',
                'price' => 199000,
                'original_price' => 250000,
                'weight' => 400,
                'stock' => 40,
                'is_active' => true,
                'sku' => 'CLN001',
            ],
            [
                'category_id' => $fashionWanita->id,
                'name' => 'Dress Wanita Motif Floral Elegant',
                'slug' => Str::slug('Dress Wanita Motif Floral Elegant'),
                'description' => 'Dress dengan motif floral yang elegan untuk acara casual maupun semi-formal.',
                'price' => 385000,
                'original_price' => 450000,
                'weight' => 350,
                'stock' => 30,
                'is_active' => true,
                'is_featured' => true,
                'sku' => 'DRS001',
            ],
            [
                'category_id' => $fashionWanita->id,
                'name' => 'Blouse Katun Premium Korea',
                'slug' => Str::slug('Blouse Katun Premium Korea'),
                'description' => 'Blouse katun import Korea dengan desain simple dan elegan.',
                'price' => 175000,
                'original_price' => 220000,
                'weight' => 200,
                'stock' => 60,
                'is_active' => true,
                'sku' => 'BLS001',
            ],
            [
                'category_id' => $fashionWanita->id,
                'name' => 'Rok Mini A-Line Korean Style',
                'slug' => Str::slug('Rok Mini A-Line Korean Style'),
                'description' => 'Rok mini dengan potongan A-line tren fashion Korea.',
                'price' => 155000,
                'original_price' => 190000,
                'weight' => 180,
                'stock' => 45,
                'is_active' => true,
                'sku' => 'RKK001',
            ],
            [
                'category_id' => $elektronik->id,
                'name' => 'TWS Earbuds Bluetooth 5.3',
                'slug' => Str::slug('TWS Earbuds Bluetooth 5.3'),
                'description' => 'True wireless earbuds dengan Bluetooth 5.3, suara jernih, dan baterai tahan lama.',
                'price' => 299000,
                'original_price' => 400000,
                'weight' => 100,
                'stock' => 100,
                'is_active' => true,
                'is_featured' => true,
                'sku' => 'EAR001',
            ],
            [
                'category_id' => $elektronik->id,
                'name' => 'Smart Watch Sport Edition',
                'slug' => Str::slug('Smart Watch Sport Edition'),
                'description' => 'Smartwatch dengan fitur kesehatan lengkap: heart rate, SpO2, sleep tracking.',
                'price' => 599000,
                'original_price' => 750000,
                'weight' => 150,
                'stock' => 40,
                'is_active' => true,
                'sku' => 'SWT001',
            ],
            [
                'category_id' => $elektronik->id,
                'name' => 'Powerbank 10000mAh Fast Charging',
                'slug' => Str::slug('Powerbank 10000mAh Fast Charging'),
                'description' => 'Powerbank kapasitas 10000mAh dengan fast charging 22.5W.',
                'price' => 189000,
                'original_price' => 250000,
                'weight' => 300,
                'stock' => 80,
                'is_active' => true,
                'sku' => 'PWB001',
            ],
            [
                'category_id' => $rumahTangga->id,
                'name' => 'Set Perlengkapan Masak 7 in 1',
                'slug' => Str::slug('Set Perlengkapan Masak 7 in 1'),
                'description' => 'Set panci dan wajan anti lengket 7 piece untuk dapur modern.',
                'price' => 450000,
                'original_price' => 600000,
                'weight' => 2000,
                'stock' => 20,
                'is_active' => true,
                'is_featured' => true,
                'sku' => 'DPR001',
            ],
            [
                'category_id' => $rumahTangga->id,
                'name' => 'Lampu LED Strip RGB Remote Control',
                'slug' => Str::slug('Lampu LED Strip RGB Remote Control'),
                'description' => 'Lampu LED strip dengan 16 warna dan remote control.',
                'price' => 125000,
                'original_price' => 175000,
                'weight' => 200,
                'stock' => 70,
                'is_active' => true,
                'sku' => 'LED001',
            ],
            [
                'category_id' => $olahraga->id,
                'name' => 'Sepeda Lipat United 20 inch',
                'slug' => Str::slug('Sepeda Lipat United 20 inch'),
                'description' => 'Sepeda lipat praktis untuk mobilitas sehari-hari.',
                'price' => 1850000,
                'original_price' => 2200000,
                'weight' => 12000,
                'stock' => 10,
                'is_active' => true,
                'is_featured' => true,
                'sku' => 'SPD001',
            ],
            [
                'category_id' => $olahraga->id,
                'name' => 'Matras Yoga Premium 6mm',
                'slug' => Str::slug('Matras Yoga Premium 6mm'),
                'description' => 'Matras yoga anti slip dengan ketebalan 6mm.',
                'price' => 185000,
                'original_price' => 250000,
                'weight' => 1200,
                'stock' => 55,
                'is_active' => true,
                'sku' => 'MAT001',
            ],
            [
                'category_id' => $kecantikan->id,
                'name' => 'Skincare Set Brightening 5 Step',
                'slug' => Str::slug('Skincare Set Brightening 5 Step'),
                'description' => 'Set skincare lengkap 5 langkah untuk kulit cerah berseri.',
                'price' => 350000,
                'original_price' => 450000,
                'weight' => 400,
                'stock' => 35,
                'is_active' => true,
                'is_featured' => true,
                'sku' => 'SKN001',
            ],
            [
                'category_id' => $kecantikan->id,
                'name' => 'Parfum Wanita EDP 50ml Premium',
                'slug' => Str::slug('Parfum Wanita EDP 50ml Premium'),
                'description' => 'Parfum wanita dengan aroma floral fruity tahan 8+ jam.',
                'price' => 275000,
                'original_price' => 350000,
                'weight' => 150,
                'stock' => 50,
                'is_active' => true,
                'sku' => 'PRF001',
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['sku' => $product['sku']], $product);
        }

        $this->command->info('Database seeded! Categories: ' . Category::count() . ', Products: ' . Product::count());
    }
}