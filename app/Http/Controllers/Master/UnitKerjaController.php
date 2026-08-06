<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreUnitKerjaRequest;
use App\Http\Requests\Master\UpdateUnitKerjaRequest;
use App\Models\UnitKerja;
use App\Services\UnitKerjaService;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
{
    public function __construct(
        protected UnitKerjaService $service
    ) {
    }

    public function index(Request $request)
    {
        return view('master.unit-kerja.index', [
            'items' => $this->service->paginate(
                $request->search
            ),
        ]);
    }

    public function create()
    {
        return view('master.unit-kerja.create');
    }

    public function store(StoreUnitKerjaRequest $request)
    {
        $this->service->store(
            $request->validated()
        );

        return redirect()
            ->route('master.unit-kerja.index')
            ->with('success', 'Unit kerja berhasil ditambahkan.');
    }

    public function edit(UnitKerja $unitKerja)
    {
        return view('master.unit-kerja.edit', compact('unitKerja'));
    }

    public function update(
        UpdateUnitKerjaRequest $request,
        UnitKerja $unitKerja
    ) {
        $this->service->update(
            $unitKerja,
            $request->validated()
        );

        return redirect()
            ->route('master.unit-kerja.index')
            ->with('success', 'Unit kerja berhasil diperbarui.');
    }

    public function destroy(UnitKerja $unitKerja)
    {
        $this->service->destroy($unitKerja);

        return back()->with(
            'success',
            'Unit kerja berhasil dihapus.'
        );
    }
}