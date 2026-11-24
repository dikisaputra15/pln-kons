<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveJenispekerjaanRequest;
use App\Models\Jenispekerjaan;
use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JenispekerjaanController extends Controller
{
    public function index(): View
    {
        return view('jenispekerjaans.index', [
            'jenispekerjaans' => Jenispekerjaan::query()
                ->with('kategori:id,kategori')
                ->orderBy('jenis_pekerjaan')
                ->orderBy('id')
                ->paginate(15),
        ]);
    }

    public function create(): View
    {
        return $this->form(null);
    }

    public function store(SaveJenispekerjaanRequest $request): RedirectResponse
    {
        Jenispekerjaan::query()->create($request->validated());

        return redirect()->route('jenispekerjaans.index')->with('status', 'Jenis Pekerjaan berhasil ditambahkan.');
    }

    public function edit(Jenispekerjaan $jenispekerjaan): View
    {
        return $this->form($jenispekerjaan);
    }

    public function update(SaveJenispekerjaanRequest $request, Jenispekerjaan $jenispekerjaan): RedirectResponse
    {
        $jenispekerjaan->update($request->validated());

        return redirect()->route('jenispekerjaans.index')->with('status', 'Jenis Pekerjaan berhasil diperbarui.');
    }

    public function destroy(Jenispekerjaan $jenispekerjaan): RedirectResponse
    {
        $jenispekerjaan->delete();

        return redirect()->route('jenispekerjaans.index')->with('status', 'Jenis Pekerjaan berhasil dihapus.');
    }

    private function form(?Jenispekerjaan $jenispekerjaan): View
    {
        return view('jenispekerjaans.form', [
            'jenispekerjaan' => $jenispekerjaan,
            'kategoris' => Kategori::query()
                ->orderBy('kategori')
                ->orderBy('id')
                ->get(['id', 'kategori']),
        ]);
    }
}
