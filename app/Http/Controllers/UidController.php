<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveUidRequest;
use App\Models\Uid;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UidController extends Controller
{
    public function index(): View
    {
        return view('uids.index', [
            'uids' => Uid::query()->orderBy('nama_unit_induk')->orderBy('id')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('uids.form', ['uid' => null]);
    }

    public function store(SaveUidRequest $request): RedirectResponse
    {
        Uid::query()->create($request->validated());

        return redirect()->route('uids.index')->with('status', 'UID berhasil ditambahkan.');
    }

    public function edit(Uid $uid): View
    {
        return view('uids.form', ['uid' => $uid]);
    }

    public function update(SaveUidRequest $request, Uid $uid): RedirectResponse
    {
        $uid->update($request->validated());

        return redirect()->route('uids.index')->with('status', 'UID berhasil diperbarui.');
    }

    public function destroy(Uid $uid): RedirectResponse
    {
        $uid->delete();

        return redirect()->route('uids.index')->with('status', 'UID berhasil dihapus.');
    }
}
