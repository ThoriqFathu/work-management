<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['nama' => 'Pengembangan', 'warna' => '#2563EB', 'aktif' => true],
            ['nama' => 'Bug',          'warna' => '#DC2626', 'aktif' => true],
            ['nama' => 'Support',      'warna' => '#16A34A', 'aktif' => true],
            ['nama' => 'Laporan',      'warna' => '#9333EA', 'aktif' => true],
            ['nama' => 'Maintenance',  'warna' => '#EA580C', 'aktif' => true],
            ['nama' => 'Bridging',     'warna' => '#0891B2', 'aktif' => true],
            ['nama' => 'Meeting',      'warna' => '#6B7280', 'aktif' => true],
        ];

        foreach ($items as $item) {
            Category::updateOrCreate(
                ['nama' => $item['nama']],
                $item
            );
        }
    }
}