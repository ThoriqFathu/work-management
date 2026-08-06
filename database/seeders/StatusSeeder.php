<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['nama' => 'Request',   'warna' => '#6B7280'],
            ['nama' => 'Analisa',   'warna' => '#3B82F6'],
            ['nama' => 'Todo',      'warna' => '#6366F1'],
            ['nama' => 'Progress',  'warna' => '#F59E0B'],
            ['nama' => 'Waiting',   'warna' => '#F97316'],
            ['nama' => 'Testing',   'warna' => '#8B5CF6'],
            ['nama' => 'Done',      'warna' => '#22C55E'],
            ['nama' => 'Cancelled', 'warna' => '#EF4444'],
        ];

        foreach ($items as $item) {
            Status::updateOrCreate(
                ['nama' => $item['nama']],
                $item
            );
        }
    }
}