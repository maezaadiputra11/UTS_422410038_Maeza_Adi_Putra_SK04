<?php

namespace App\Http\Controllers;

use App\Http\Requests\TindakanRestorasiRequest;
use App\Models\TindakanRestorasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TindakanRestorasiController extends Controller
{
    public function index(): View
    {
        return view('tindakan-restorasi.index', [
            'tindakans' => TindakanRestorasi::withCount('koleksiPitas')->orderBy('nama')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('tindakan-restorasi.form', ['item' => new TindakanRestorasi(['aktif' => true, 'estimasi_jam' => 1])]);
    }

    public function store(TindakanRestorasiRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['aktif'] = $request->boolean('aktif');

        TindakanRestorasi::create($data);

        return redirect()->route('tindakan-restorasi.index')->with('success', 'Tindakan restorasi berhasil ditambahkan.');
    }

    public function edit(TindakanRestorasi $tindakanRestorasi): View
    {
        return view('tindakan-restorasi.form', ['item' => $tindakanRestorasi]);
    }

    public function update(TindakanRestorasiRequest $request, TindakanRestorasi $tindakanRestorasi): RedirectResponse
    {
        $data = $request->validated();
        $data['aktif'] = $request->boolean('aktif');

        $tindakanRestorasi->update($data);

        return redirect()->route('tindakan-restorasi.index')->with('success', 'Tindakan restorasi berhasil diperbarui.');
    }

    public function destroy(TindakanRestorasi $tindakanRestorasi): RedirectResponse
    {
        if ($tindakanRestorasi->koleksiPitas()->exists()) {
            return redirect()
                ->route('tindakan-restorasi.index')
                ->with('error', 'Tindakan masih dipakai koleksi, tidak dapat dihapus. Nonaktifkan saja bila perlu.');
        }

        $tindakanRestorasi->delete();

        return redirect()->route('tindakan-restorasi.index')->with('success', 'Tindakan restorasi berhasil dihapus.');
    }
}
