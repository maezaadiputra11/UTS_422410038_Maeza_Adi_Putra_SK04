<?php

namespace App\Http\Controllers;

use App\Http\Requests\KoleksiPitaRequest;
use App\Models\FormatMedia;
use App\Models\KoleksiPita;
use App\Models\KondisiAwal;
use App\Models\TindakanRestorasi;
use App\Services\KoleksiPitaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KoleksiPitaController extends Controller
{
    public function __construct(private KoleksiPitaService $service)
    {
    }

    public function index(Request $request): View
    {
        $kerusakan = $request->input('kerusakan');

        $koleksis = KoleksiPita::query()
            ->with([
                'formatMedia:id,nama',
                'kondisiAwal:id,koleksi_pita_id,tingkat_kerusakan',
            ])
            ->withCount('tindakanRestorasis')
            ->search($request->input('q'))
            ->format($request->integer('format_media_id') ?: null)
            ->kerusakan(in_array($kerusakan, KondisiAwal::TINGKAT, true) ? $kerusakan : null)
            ->tindakan($request->integer('tindakan_id') ?: null)
            ->orderBy('kode')
            ->paginate(10)
            ->withQueryString();

        return view('koleksi.index', [
            'koleksis' => $koleksis,
            'formats' => FormatMedia::orderBy('nama')->pluck('nama', 'id'),
            'tindakans' => TindakanRestorasi::orderBy('nama')->pluck('nama', 'id'),
        ]);
    }

    public function create(): View
    {
        return view('koleksi.create', $this->dataForm(new KoleksiPita));
    }

    public function store(KoleksiPitaRequest $request): RedirectResponse
    {
        $koleksi = $this->service->simpan($request->validated());

        return redirect()
            ->route('koleksi.show', $koleksi)
            ->with('success', 'Koleksi pita berhasil ditambahkan.');
    }

    public function show(KoleksiPita $koleksiPita): View
    {
        $koleksiPita->load(['formatMedia', 'kondisiAwal', 'tindakanRestorasis']);

        return view('koleksi.show', ['koleksi' => $koleksiPita]);
    }

    public function edit(KoleksiPita $koleksiPita): View
    {
        $koleksiPita->load(['kondisiAwal', 'tindakanRestorasis']);

        return view('koleksi.edit', $this->dataForm($koleksiPita));
    }

    public function update(KoleksiPitaRequest $request, KoleksiPita $koleksiPita): RedirectResponse
    {
        $this->service->simpan($request->validated(), $koleksiPita);

        return redirect()
            ->route('koleksi.show', $koleksiPita)
            ->with('success', 'Koleksi pita berhasil diperbarui.');
    }

    public function destroy(KoleksiPita $koleksiPita): RedirectResponse
    {
        // Detail kondisi & baris pivot ikut terhapus (cascadeOnDelete di migration).
        $koleksiPita->delete();

        return redirect()
            ->route('koleksi.index')
            ->with('success', 'Koleksi pita berhasil dihapus.');
    }

    private function dataForm(KoleksiPita $koleksi): array
    {
        $pilihan = $koleksi->tindakanRestorasis
            ->mapWithKeys(fn ($t) => [$t->id => [
                'prioritas' => $t->pivot->prioritas,
                'status' => $t->pivot->status,
            ]])
            ->all();

        return [
            'koleksi' => $koleksi,
            'formats' => FormatMedia::orderBy('nama')->pluck('nama', 'id'),
            'tindakans' => TindakanRestorasi::where('aktif', true)->orderBy('nama')->get(),
            'pilihan' => $pilihan,
        ];
    }
}
