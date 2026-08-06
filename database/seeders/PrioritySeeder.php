<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['nama' => 'Critical', 'urutan' => 1, 'warna' => '#DC2626'],
            ['nama' => 'High',     'urutan' => 2, 'warna' => '#F97316'],
            ['nama' => 'Medium',   'urutan' => 3, 'warna' => '#EAB308'],
            ['nama' => 'Low',      'urutan' => 4, 'warna' => '#22C55E'],
        ];

        foreach ($items as $item) {
            Priority::updateOrCreate(
                ['nama' => $item['nama']],
                $item
            );
        }
    }
}