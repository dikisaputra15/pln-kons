<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveKategoriRequest;
use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KategoriController extends Controller
{
    public function index(): View
    {
        return view('kategoris.index', [
            'kategoris' => Kategori::query()
                ->orderBy('kategori')
                ->orderBy('id')
                ->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('kategoris.form', ['kategori' => null]);
    }

    public function store(SaveKategoriRequest $request): RedirectResponse
    {
        Kategori::query()->create($request->validated());

        return redirect()->route('kategoris.index')->with('status', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori): View
    {
        return view('kategoris.form', ['kategori' => $kategori]);
    }

    public function update(SaveKategoriRequest $request, Kategori $kategori): RedirectResponse
    {
        $kategori->update($request->validated());

        return redirect()->route('kategoris.index')->with('status', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori): RedirectResponse
    {
        $kategori->delete();

        return redirect()->route('kategoris.index')->with('status', 'Kategori berhasil dihapus.');
    }
}
