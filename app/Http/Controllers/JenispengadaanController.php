<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveJenispengadaanRequest;
use App\Models\Jenispengadaan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JenispengadaanController extends Controller
{
    public function index(): View
    {
        return view('jenispengadaans.index', [
            'jenispengadaans' => Jenispengadaan::query()
                ->orderBy('jenis_pengadaan')
                ->orderBy('id')
                ->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('jenispengadaans.form', ['jenispengadaan' => null]);
    }

    public function store(SaveJenispengadaanRequest $request): RedirectResponse
    {
        Jenispengadaan::query()->create($request->validated());

        return redirect()->route('jenispengadaans.index')->with('status', 'Jenis pengadaan berhasil ditambahkan.');
    }

    public function edit(Jenispengadaan $jenispengadaan): View
    {
        return view('jenispengadaans.form', ['jenispengadaan' => $jenispengadaan]);
    }

    public function update(SaveJenispengadaanRequest $request, Jenispengadaan $jenispengadaan): RedirectResponse
    {
        $jenispengadaan->update($request->validated());

        return redirect()->route('jenispengadaans.index')->with('status', 'Jenis pengadaan berhasil diperbarui.');
    }

    public function destroy(Jenispengadaan $jenispengadaan): RedirectResponse
    {
        $jenispengadaan->delete();

        return redirect()->route('jenispengadaans.index')->with('status', 'Jenis pengadaan berhasil dihapus.');
    }
}
