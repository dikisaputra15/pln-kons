<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveUnitRequest;
use App\Models\Uid;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UnitController extends Controller
{
    public function index(): View
    {
        return view('units.index', [
            'units' => Unit::query()->with('unitInduk:id,kode_unit_induk,nama_unit_induk')->orderBy('nama_unit')->orderBy('id')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return $this->form(null);
    }

    public function store(SaveUnitRequest $request): RedirectResponse
    {
        Unit::query()->create($request->validated());

        return redirect()->route('units.index')->with('status', 'Unit berhasil ditambahkan.');
    }

    public function edit(Unit $unit): View
    {
        return $this->form($unit);
    }

    public function update(SaveUnitRequest $request, Unit $unit): RedirectResponse
    {
        $unit->update($request->validated());

        return redirect()->route('units.index')->with('status', 'Unit berhasil diperbarui.');
    }

    public function destroy(Unit $unit): RedirectResponse
    {
        $unit->delete();

        return redirect()->route('units.index')->with('status', 'Unit berhasil dihapus.');
    }

    private function form(?Unit $unit): View
    {
        return view('units.form', [
            'unit' => $unit,
            'uids' => Uid::query()
                ->orderBy('nama_unit_induk')
                ->orderBy('id')
                ->get(['id', 'kode_unit_induk', 'nama_unit_induk']),
        ]);
    }
}
