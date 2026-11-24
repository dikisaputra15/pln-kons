<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveSatuanRequest;
use App\Models\Satuan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SatuanController extends Controller
{
    public function index(): View
    {
        return view('satuans.index', [
            'satuans' => Satuan::query()
                ->orderBy('nama_satuan')
                ->orderBy('id')
                ->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('satuans.form', ['satuan' => null]);
    }

    public function store(SaveSatuanRequest $request): RedirectResponse
    {
        Satuan::query()->create($request->validated());

        return redirect()->route('satuans.index')->with('status', 'Satuan berhasil ditambahkan.');
    }

    public function edit(Satuan $satuan): View
    {
        return view('satuans.form', ['satuan' => $satuan]);
    }

    public function update(SaveSatuanRequest $request, Satuan $satuan): RedirectResponse
    {
        $satuan->update($request->validated());

        return redirect()->route('satuans.index')->with('status', 'Satuan berhasil diperbarui.');
    }

    public function destroy(Satuan $satuan): RedirectResponse
    {
        $satuan->delete();

        return redirect()->route('satuans.index')->with('status', 'Satuan berhasil dihapus.');
    }
}
