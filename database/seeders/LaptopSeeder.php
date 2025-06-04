<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Laptop;

class LaptopSeeder extends Seeder
{
    public function run()
    {
        $laptops = [
            [
                'name' => 'Acer Aspire 5 A515',
                'processor' => 'Intel Core i5-1240P',
                'ram' => '16 GB',
                'storage' => 'SSD 512 GB',
                'gpu' => 'GTX 1650',
                'screen_size' => '15.6" FHD',
                'price' => 10500000,
                'description' => 'Laptop gaming entry level dengan performa solid untuk gaming dan produktivitas.',
                'is_active' => true
            ],
            [
                'name' => 'Asus Vivobook Pro 14X',
                'processor' => 'AMD Ryzen 7 5800H',
                'ram' => '16 GB',
                'storage' => 'SSD 1 TB',
                'gpu' => 'RTX 3050',
                'screen_size' => '14" FHD OLED',
                'price' => 14500000,
                'description' => 'Laptop premium dengan layar OLED dan performa gaming menengah.',
                'is_active' => true
            ],
            [
                'name' => 'Lenovo IdeaPad Gaming 3',
                'processor' => 'AMD Ryzen 5 5600H',
                'ram' => '8 GB',
                'storage' => 'SSD 512 GB',
                'gpu' => 'RTX 3050',
                'screen_size' => '15.6" FHD',
                'price' => 13000000,
                'description' => 'Laptop gaming terjangkau dengan performa baik untuk gaming dan content creation.',
                'is_active' => true
            ],
            [
                'name' => 'HP Pavilion 14',
                'processor' => 'Intel Core i7-1165G7',
                'ram' => '16 GB',
                'storage' => 'SSD 512 GB',
                'gpu' => 'Intel Iris Xe',
                'screen_size' => '14" FHD',
                'price' => 11000000,
                'description' => 'Laptop tipis dan ringan cocok untuk profesional dan mahasiswa.',
                'is_active' => true
            ],
            [
                'name' => 'MSI Modern 14',
                'processor' => 'AMD Ryzen 5 7530U',
                'ram' => '8 GB',
                'storage' => 'SSD 512 GB',
                'gpu' => 'Radeon Graphics',
                'screen_size' => '14" FHD',
                'price' => 9800000,
                'description' => 'Laptop modern dengan desain minimalis untuk produktivitas sehari-hari.',
                'is_active' => true
            ],
            [
                'name' => 'Asus TUF Gaming F15',
                'processor' => 'Intel Core i5-11400H',
                'ram' => '16 GB',
                'storage' => 'SSD 512 GB',
                'gpu' => 'RTX 3050',
                'screen_size' => '15.6" FHD',
                'price' => 14000000,
                'description' => 'Laptop gaming tangguh dengan sertifikasi military-grade.',
                'is_active' => true
            ],
            [
                'name' => 'Lenovo ThinkBook 14 G3',
                'processor' => 'AMD Ryzen 5 5625U',
                'ram' => '8 GB',
                'storage' => 'SSD 512 GB',
                'gpu' => 'Radeon Graphics',
                'screen_size' => '14" FHD',
                'price' => 9900000,
                'description' => 'Laptop bisnis dengan fitur keamanan tinggi dan performa stabil.',
                'is_active' => true
            ]
        ];

        foreach ($laptops as $laptopData) {
            Laptop::create($laptopData);
        }
    }
}