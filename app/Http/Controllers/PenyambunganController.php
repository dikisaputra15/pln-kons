<?php

namespace App\Http\Controllers;

use App\Http\Requests\SavePenyambunganRequest;
use App\Models\Penyambungan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PenyambunganController extends Controller
{
    public function index(): View
    {
        return view('penyambungans.index', [
            'penyambungans' => Penyambungan::query()
                ->orderBy('daya_awal')
                ->orderBy('id')
                ->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('penyambungans.form', ['penyambungan' => null]);
    }

    public function store(SavePenyambunganRequest $request): RedirectResponse
    {
        Penyambungan::query()->create($request->validated());

        return redirect()->route('penyambungans.index')->with('status', 'Penyambungan berhasil ditambahkan.');
    }

    public function edit(Penyambungan $penyambungan): View
    {
        return view('penyambungans.form', ['penyambungan' => $penyambungan]);
    }

    public function update(SavePenyambunganRequest $request, Penyambungan $penyambungan): RedirectResponse
    {
        $penyambungan->update($request->validated());

        return redirect()->route('penyambungans.index')->with('status', 'Penyambungan berhasil diperbarui.');
    }

    public function destroy(Penyambungan $penyambungan): RedirectResponse
    {
        $penyambungan->delete();

        return redirect()->route('penyambungans.index')->with('status', 'Penyambungan berhasil dihapus.');
    }
}
