<?php

namespace App\Services;

use App\Models\UnitKerja;

class UnitKerjaService
{
    public function paginate(string $search = null)
    {
        return UnitKerja::query()
            ->when($search, function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }

    public function store(array $data): UnitKerja
    {
        return UnitKerja::create($data);
    }

    public function update(UnitKerja $unitKerja, array $data): UnitKerja
    {
        $unitKerja->update($data);

        return $unitKerja;
    }

    public function destroy(UnitKerja $unitKerja): void
    {
        $unitKerja->delete();
    }
}