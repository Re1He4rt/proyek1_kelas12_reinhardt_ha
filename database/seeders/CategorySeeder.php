<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

/**
 * CategorySeeder
 * Seeder untuk membuat data genre/kategori buku
 */
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fiksi',
                'description' => 'Novel, cerpen, dan karya fiksi dari penulis dalam dan luar negeri.',
                'status' => 'active',
            ],
            [
                'name' => 'Non-Fiksi',
                'description' => 'Buku berdasarkan fakta nyata, biografi, dan dokumentasi.',
                'status' => 'active',
            ],
            [
                'name' => 'Pengembangan Diri',
                'description' => 'Buku motivasi, self-help, dan pengembangan potensi diri.',
                'status' => 'active',
            ],
            [
                'name' => 'Bisnis & Ekonomi',
                'description' => 'Manajemen bisnis, marketing, investasi, dan kewirausahaan.',
                'status' => 'active',
            ],
            [
                'name' => 'Teknologi',
                'description' => 'Pemrograman, AI, cybersecurity, dan perkembangan teknologi digital.',
                'status' => 'active',
            ],
            [
                'name' => 'Sejarah',
                'description' => 'Sejarah dunia, sejarah Indonesia, dan biografi tokoh sejarah.',
                'status' => 'active',
            ],
            [
                'name' => 'Sains',
                'description' => 'Fisika, biologi, kimia, astronomi, dan ilmu pengetahuan alam.',
                'status' => 'active',
            ],
            [
                'name' => 'Anak & Remaja',
                'description' => 'Buku cerita anak, komik edukasi, dan literasi remaja.',
                'status' => 'active',
            ],
            [
                'name' => 'Agama & Spiritual',
                'description' => 'Buku keagamaan, spiritualitas, dan pengembangan jiwa.',
                'status' => 'active',
            ],
            [
                'name' => 'Seni & Budaya',
                'description' => 'Seni lukis, musik, tari, fotografi, dan kebudayaan.',
                'status' => 'active',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate([
                'name' => $category['name'],
            ], $category);
        }

        $this->command->info('✓ ' . count($categories) . ' book genres/categories created successfully.');
    }
}
