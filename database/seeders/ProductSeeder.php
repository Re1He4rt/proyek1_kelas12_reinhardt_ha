<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * ProductSeeder
 * Seeder untuk membuat data produk buku sample
 */
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Fiksi (category_id = 1)
            [
                'category_id' => 1,
                'name' => 'Laut Bercerita',
                'author' => 'Leila S. Chudori',
                'publisher' => 'Kepustakaan Populer Gramedia',
                'year' => 2017,
                'isbn' => '9786024245571',
                'price' => 89000,
                'stock' => 50,
                'description' => 'Novel tentang perjuangan mahasiswa era reformasi dan pengorbanan sahabat.',
                'image' => null,
            ],
            [
                'category_id' => 1,
                'name' => 'Pulang',
                'author' => 'Tere Liye',
                'publisher' => 'Republika',
                'year' => 2015,
                'isbn' => '9786028519898',
                'price' => 95000,
                'stock' => 45,
                'description' => 'Perjalanan seorang anak meraih mimpi dan kembali ke akarnya.',
                'image' => null,
            ],
            [
                'category_id' => 1,
                'name' => 'Dilan 1990',
                'author' => 'Pidi Baiq',
                'publisher' => 'Pastel Books',
                'year' => 2014,
                'isbn' => '9786027870402',
                'price' => 75000,
                'stock' => 60,
                'description' => 'Kisah cinta khas anak Bandung di era 90-an.',
                'image' => null,
            ],

            // Non-Fiksi (category_id = 2)
            [
                'category_id' => 2,
                'name' => 'Sapiens: Riwayat Singkat Umat Manusia',
                'author' => 'Yuval Noah Harari',
                'publisher' => 'Pustaka Alvabet',
                'year' => 2017,
                'isbn' => '9786029193523',
                'price' => 125000,
                'stock' => 35,
                'description' => 'Perjalanan sejarah umat manusia dari zaman purba hingga modern.',
                'image' => null,
            ],
            [
                'category_id' => 2,
                'name' => 'Orang-Orang Biasa',
                'author' => 'Andrea Hirata',
                'publisher' => 'Bentang Pustaka',
                'year' => 2019,
                'isbn' => '9786022916817',
                'price' => 85000,
                'stock' => 40,
                'description' => 'Kisah inspiratif tentang perjuangan orang biasa meraih mimpi.',
                'image' => null,
            ],

            // Pengembangan Diri (category_id = 3)
            [
                'category_id' => 3,
                'name' => 'Atomic Habits',
                'author' => 'James Clear',
                'publisher' => 'Gramedia Pustaka Utama',
                'year' => 2019,
                'isbn' => '9786020641380',
                'price' => 105000,
                'stock' => 100,
                'description' => 'Perubahan kecil yang memberikan hasil luar biasa dalam hidup.',
                'image' => null,
            ],
            [
                'category_id' => 3,
                'name' => 'Filosofi Teras',
                'author' => 'Henry Manampiring',
                'publisher' => 'Buku Kompas',
                'year' => 2018,
                'isbn' => '9786024124586',
                'price' => 89000,
                'stock' => 80,
                'description' => 'Filosofi Stoikisme untuk kehidupan modern yang lebih tenang.',
                'image' => null,
            ],

            // Bisnis & Ekonomi (category_id = 4)
            [
                'category_id' => 4,
                'name' => 'Startup Mindset',
                'author' => 'Rhenald Kasali',
                'publisher' => 'Gramedia Pustaka Utama',
                'year' => 2020,
                'isbn' => '9786020632302',
                'price' => 115000,
                'stock' => 30,
                'description' => 'Pola pikir dan strategi membangun startup sukses.',
                'image' => null,
            ],
            [
                'category_id' => 4,
                'name' => 'Rich Dad Poor Dad',
                'author' => 'Robert T. Kiyosaki',
                'publisher' => 'Gramedia',
                'year' => 2016,
                'isbn' => '9786020332813',
                'price' => 85000,
                'stock' => 95,
                'description' => 'Pelajaran tentang kekayaan dari dua sosok ayah yang berbeda.',
                'image' => null,
            ],

            // Teknologi (category_id = 5)
            [
                'category_id' => 5,
                'name' => 'Laravel: The Complete Guide',
                'author' => 'John Doe',
                'publisher' => 'TechPress',
                'year' => 2024,
                'isbn' => '9781234567890',
                'price' => 150000,
                'stock' => 25,
                'description' => 'Panduan lengkap framework Laravel dari dasar hingga mahir.',
                'image' => null,
            ],
            [
                'category_id' => 5,
                'name' => 'Artificial Intelligence for Everyone',
                'author' => 'Christian Rudder',
                'publisher' => 'Andi Publisher',
                'year' => 2023,
                'isbn' => '9786230101254',
                'price' => 135000,
                'stock' => 40,
                'description' => 'Pengenalan AI untuk pemula tanpa latar belakang teknis.',
                'image' => null,
            ],

            // Sejarah (category_id = 6)
            [
                'category_id' => 6,
                'name' => 'Indonesia: Sejarah yang Tak Terbongkar',
                'author' => 'John Roosa',
                'publisher' => 'Kepustakaan Populer Gramedia',
                'year' => 2020,
                'isbn' => '9786024815910',
                'price' => 98000,
                'stock' => 28,
                'description' => 'Mengungkap fakta-fakta sejarah Indonesia yang selama ini tertutup.',
                'image' => null,
            ],
            [
                'category_id' => 6,
                'name' => 'Sejarah Dunia yang Disembunyikan',
                'author' => 'J.M. Roberts',
                'publisher' => 'Pustaka Alvabet',
                'year' => 2018,
                'isbn' => '9786029193844',
                'price' => 175000,
                'stock' => 20,
                'description' => 'Perspektif baru tentang sejarah peradaban dunia.',
                'image' => null,
            ],

            // Sains (category_id = 7)
            [
                'category_id' => 7,
                'name' => 'Brief Answers to the Big Questions',
                'author' => 'Stephen Hawking',
                'publisher' => 'Baca',
                'year' => 2019,
                'isbn' => '9786025559356',
                'price' => 110000,
                'stock' => 35,
                'description' => 'Jawaban singkat untuk pertanyaan besar tentang alam semesta.',
                'image' => null,
            ],
            [
                'category_id' => 7,
                'name' => 'The Gene: Sejarah yang Menggelitik',
                'author' => 'Siddhartha Mukherjee',
                'publisher' => 'KPG',
                'year' => 2017,
                'isbn' => '9786024242020',
                'price' => 155000,
                'stock' => 22,
                'description' => 'Perjalanan penemuan gen dan pengaruhnya pada kehidupan.',
                'image' => null,
            ],

            // Anak & Remaja (category_id = 8)
            [
                'category_id' => 8,
                'name' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'publisher' => 'Bentang Pustaka',
                'year' => 2005,
                'isbn' => '9789793062792',
                'price' => 79000,
                'stock' => 65,
                'description' => 'Kisah perjuangan 10 anak Belitong mengejar pendidikan.',
                'image' => null,
            ],
            [
                'category_id' => 8,
                'name' => 'Bumi',
                'author' => 'Tere Liye',
                'publisher' => 'Republika',
                'year' => 2014,
                'isbn' => '9786028997412',
                'price' => 89000,
                'stock' => 55,
                'description' => 'Petualangan fantasi seri pertama dari Dunia Paralel.',
                'image' => null,
            ],

            // Agama & Spiritual (category_id = 9)
            [
                'category_id' => 9,
                'name' => 'The Power of Heart',
                'author' => 'Aidh Al-Qarni',
                'publisher' => 'QultumMedia',
                'year' => 2020,
                'isbn' => '9789795925194',
                'price' => 75000,
                'stock' => 45,
                'description' => 'Ketenangan hati dalam menghadapi ujian kehidupan.',
                'image' => null,
            ],
            [
                'category_id' => 9,
                'name' => 'Membongkar Gurita Cinta',
                'author' => 'Salim A. Fillah',
                'publisher' => 'Pro-U Media',
                'year' => 2017,
                'isbn' => '9786021711080',
                'price' => 68000,
                'stock' => 50,
                'description' => 'Cinta dalam perspektif Islam yang mencerahkan.',
                'image' => null,
            ],

            // Seni & Budaya (category_id = 10)
            [
                'category_id' => 10,
                'name' => 'Seni Mencintai Diri Sendiri',
                'author' => 'Fiersa Besari',
                'publisher' => 'Media Kita',
                'year' => 2021,
                'isbn' => '9786239187730',
                'price' => 95000,
                'stock' => 38,
                'description' => 'Perjalanan menemukan cinta sejati pada diri sendiri.',
                'image' => null,
            ],
            [
                'category_id' => 10,
                'name' => 'Kumpulan Puisi Cinta',
                'author' => 'Sapardi Djoko Damono',
                'publisher' => 'Gramedia Pustaka Utama',
                'year' => 2019,
                'isbn' => '9786020329165',
                'price' => 65000,
                'stock' => 42,
                'description' => 'Kumpulan puisi cinta dari maestro sastra Indonesia.',
                'image' => null,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate([
                'name' => $product['name'],
            ], $product);
        }

        $this->command->info('✓ ' . count($products) . ' book products created successfully.');
    }
}
