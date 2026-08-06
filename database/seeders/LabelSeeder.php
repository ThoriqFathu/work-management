<?php

namespace Database\Seeders;

use App\Models\Label;
use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    public function run(): void
    {
        $labels = [
            'Laravel',
            'Java',
            'BPJS',
            'SATUSEHAT',
            'MariaDB',
            'Linux',
            'Server',
            'Dashboard',
            'SQL',
            'API',
        ];

        foreach ($labels as $label) {
            Label::updateOrCreate(
                ['nama' => $label],
                ['warna' => null]
            );
        }
    }
}