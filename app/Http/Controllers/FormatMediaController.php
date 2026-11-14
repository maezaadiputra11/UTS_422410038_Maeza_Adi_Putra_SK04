<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormatMediaRequest;
use App\Models\FormatMedia;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FormatMediaController extends Controller
{
    public function index(): View
    {
        return view('format-media.index', [
            'formats' => FormatMedia::withCount('koleksiPitas')->orderBy('nama')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('format-media.form', ['item' => new FormatMedia]);
    }

    public function store(FormatMediaRequest $request): RedirectResponse
    {
        FormatMedia::create($request->validated());

        return redirect()->route('format-media.index')->with('success', 'Format media berhasil ditambahkan.');
    }

    public function edit(FormatMedia $formatMedia): View
    {
        return view('format-media.form', ['item' => $formatMedia]);
    }

    public function update(FormatMediaRequest $request, FormatMedia $formatMedia): RedirectResponse
    {
        $formatMedia->update($request->validated());

        return redirect()->route('format-media.index')->with('success', 'Format media berhasil diperbarui.');
    }

    public function destroy(FormatMedia $formatMedia): RedirectResponse
    {
        // FK memakai restrictOnDelete: tolak dengan pesan jelas jika masih dipakai koleksi.
        if ($formatMedia->koleksiPitas()->exists()) {
            return redirect()
                ->route('format-media.index')
                ->with('error', 'Format media masih dipakai koleksi, tidak dapat dihapus.');
        }

        $formatMedia->delete();

        return redirect()->route('format-media.index')->with('success', 'Format media berhasil dihapus.');
    }
}
