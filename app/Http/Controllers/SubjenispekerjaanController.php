<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveSubjenispekerjaanRequest;
use App\Models\Jenispekerjaan;
use App\Models\Subjenispekerjaan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SubjenispekerjaanController extends Controller
{
    public function index(): View
    {
        return view('subjenispekerjaans.index', [
            'subjenispekerjaans' => Subjenispekerjaan::query()
                ->with(['jenisPekerjaan:id,id_kategori,jenis_pekerjaan', 'jenisPekerjaan.kategori:id,kategori'])
                ->orderBy('subjenis_pekerjaan')
                ->orderBy('id')
                ->paginate(15),
        ]);
    }

    public function create(): View
    {
        return $this->form(null);
    }

    public function store(SaveSubjenispekerjaanRequest $request): RedirectResponse
    {
        Subjenispekerjaan::query()->create($request->validated());

        return redirect()->route('subjenispekerjaans.index')->with('status', 'Sub Jenis Pekerjaan berhasil ditambahkan.');
    }

    public function edit(Subjenispekerjaan $subjenispekerjaan): View
    {
        return $this->form($subjenispekerjaan);
    }

    public function update(SaveSubjenispekerjaanRequest $request, Subjenispekerjaan $subjenispekerjaan): RedirectResponse
    {
        $subjenispekerjaan->update($request->validated());

        return redirect()->route('subjenispekerjaans.index')->with('status', 'Sub Jenis Pekerjaan berhasil diperbarui.');
    }

    public function destroy(Subjenispekerjaan $subjenispekerjaan): RedirectResponse
    {
        $subjenispekerjaan->delete();

        return redirect()->route('subjenispekerjaans.index')->with('status', 'Sub Jenis Pekerjaan berhasil dihapus.');
    }

    private function form(?Subjenispekerjaan $subjenispekerjaan): View
    {
        return view('subjenispekerjaans.form', [
            'subjenispekerjaan' => $subjenispekerjaan,
            'jenispekerjaans' => Jenispekerjaan::query()
                ->orderBy('jenis_pekerjaan')
                ->orderBy('id')
                ->get(['id', 'jenis_pekerjaan']),
        ]);
    }
}
