<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveDayaRequest;
use App\Models\Daya;
use App\Models\Tarif;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DayaController extends Controller
{
    public function index(): View
    {
        return view('dayas.index', [
            'dayas' => Daya::query()->with('tarif')->orderBy('daya')->orderBy('id')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return $this->form(null);
    }

    public function store(SaveDayaRequest $request): RedirectResponse
    {
        Daya::query()->create($request->validated());

        return redirect()->route('dayas.index')->with('status', 'Daya berhasil ditambahkan.');
    }

    public function edit(Daya $daya): View
    {
        return $this->form($daya);
    }

    public function update(SaveDayaRequest $request, Daya $daya): RedirectResponse
    {
        $daya->update($request->validated());

        return redirect()->route('dayas.index')->with('status', 'Daya berhasil diperbarui.');
    }

    public function destroy(Daya $daya): RedirectResponse
    {
        $daya->delete();

        return redirect()->route('dayas.index')->with('status', 'Daya berhasil dihapus.');
    }

    private function form(?Daya $daya): View
    {
        return view('dayas.form', [
            'daya' => $daya,
            'tarifs' => Tarif::query()->orderBy('nama_tarif')->orderBy('id')->get(['id', 'nama_tarif']),
        ]);
    }
}
