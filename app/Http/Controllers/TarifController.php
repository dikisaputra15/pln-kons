<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveTarifRequest;
use App\Models\Tarif;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TarifController extends Controller
{
    public function index(): View
    {
        return view('tarifs.index', [
            'tarifs' => Tarif::query()->orderBy('nama_tarif')->orderBy('id')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('tarifs.form', ['tarif' => null]);
    }

    public function store(SaveTarifRequest $request): RedirectResponse
    {
        Tarif::query()->create($request->validated());

        return redirect()->route('tarifs.index')->with('status', 'Tarif berhasil ditambahkan.');
    }

    public function edit(Tarif $tarif): View
    {
        return view('tarifs.form', ['tarif' => $tarif]);
    }

    public function update(SaveTarifRequest $request, Tarif $tarif): RedirectResponse
    {
        $tarif->update($request->validated());

        return redirect()->route('tarifs.index')->with('status', 'Tarif berhasil diperbarui.');
    }

    public function destroy(Tarif $tarif): RedirectResponse
    {
        $tarif->delete();

        return redirect()->route('tarifs.index')->with('status', 'Tarif berhasil dihapus.');
    }
}
