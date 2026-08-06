<?php

namespace Database\Seeders;

use App\Models\RequesterUnit;
use App\Models\UnitKerja;
use Illuminate\Database\Seeder;

class RequesterUnitSeeder extends Seeder
{
    public function run(): void
    {
        $rsud = UnitKerja::where('nama', 'RSUD Ketapang')->first();

        if (! $rsud) {
            return;
        }

        $units = [
            'Direktur',
            'Mutu',
            'Rawat Jalan',
            'Rawat Inap',
            'Farmasi',
            'Laboratorium',
            'Radiologi',
            'Rekam Medis',
            'Keuangan',
            'IT',
        ];

        foreach ($units as $unit) {
            RequesterUnit::updateOrCreate(
                [
                    'unit_kerja_id' => $rsud->id,
                    'nama' => $unit,
                ],
                [
                    'aktif' => true,
                ]
            );
        }
    }
}