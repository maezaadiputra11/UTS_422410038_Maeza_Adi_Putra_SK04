<?php

namespace App\Http\Controllers;

use App\Models\FormatMedia;
use App\Models\KoleksiPita;
use App\Models\KondisiAwal;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard.index', [
            'totalKoleksi' => KoleksiPita::count(),
            'kerusakanBerat' => KondisiAwal::where('tingkat_kerusakan', 'berat')->count(),
            'tindakanBerjalan' => DB::table('koleksi_tindakan')->where('status', 'berjalan')->count(),
            'formats' => FormatMedia::withCount('koleksiPitas')->orderBy('nama')->get(),
            'terbaru' => KoleksiPita::with('formatMedia:id,nama')->latest()->take(5)->get(),
        ]);
    }
}
