<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveGiRequest;
use App\Models\Gi;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GiController extends Controller
{
    public function index(): View
    {
        return view('gis.index', [
            'gis' => Gi::query()
                ->with(['unit:id,id_unit_induk,kode_unit,nama_unit', 'unit.unitInduk:id,kode_unit_induk,nama_unit_induk'])
                ->orderBy('nama_gi')
                ->orderBy('id')
                ->paginate(15),
        ]);
    }

    public function create(): View
    {
        return $this->form(null);
    }

    public function store(SaveGiRequest $request): RedirectResponse
    {
        Gi::query()->create($request->validated());

        return redirect()->route('gis.index')->with('status', 'GI berhasil ditambahkan.');
    }

    public function edit(Gi $gi): View
    {
        return $this->form($gi);
    }

    public function update(SaveGiRequest $request, Gi $gi): RedirectResponse
    {
        $gi->update($request->validated());

        return redirect()->route('gis.index')->with('status', 'GI berhasil diperbarui.');
    }

    public function destroy(Gi $gi): RedirectResponse
    {
        $gi->delete();

        return redirect()->route('gis.index')->with('status', 'GI berhasil dihapus.');
    }

    private function form(?Gi $gi): View
    {
        return view('gis.form', [
            'gi' => $gi,
            'units' => Unit::query()
                ->with('unitInduk:id,kode_unit_induk,nama_unit_induk')
                ->orderBy('nama_unit')
                ->orderBy('id')
                ->get(['id', 'id_unit_induk', 'kode_unit', 'nama_unit']),
        ]);
    }
}
