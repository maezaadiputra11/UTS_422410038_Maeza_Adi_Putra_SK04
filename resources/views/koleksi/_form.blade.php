@php
    $kondisi = $koleksi->kondisiAwal;
    $adaOld = session()->hasOldInput();
    $jamur = $adaOld ? old('kondisi.ada_jamur') : ($kondisi->ada_jamur ?? false);
    $sticky = $adaOld ? old('kondisi.sticky_shed') : ($kondisi->sticky_shed ?? false);
    $tanggal = $kondisi?->tanggal_periksa?->format('Y-m-d');
@endphp

<form action="{{ $koleksi->exists ? route('koleksi.update', $koleksi) : route('koleksi.store') }}" method="POST">
    @csrf
    @if ($koleksi->exists)
        @method('PUT')
    @endif

    <x-card title="1. Data Koleksi">
        <div class="form-grid">
            <x-form.input label="Kode Koleksi" name="kode" :value="$koleksi->kode" placeholder="mis. PTA-0001" />
            <x-form.input label="Nama Koleksi" name="nama" :value="$koleksi->nama" />
            <x-form.select label="Format Media" name="format_media_id" :options="$formats"
                           :selected="$koleksi->format_media_id" placeholder="-- pilih format --" />
            <x-form.input label="Tahun Rekaman" name="tahun_rekaman" type="number" :value="$koleksi->tahun_rekaman" />
        </div>
        <x-form.textarea label="Deskripsi" name="deskripsi" :value="$koleksi->deskripsi" />
    </x-card>

    <x-card title="2. Kondisi Awal (satu detail per koleksi)">
        <div class="form-grid">
            <x-form.select label="Tingkat Kerusakan" name="kondisi.tingkat_kerusakan"
                           :options="['ringan' => 'Ringan', 'sedang' => 'Sedang', 'berat' => 'Berat']"
                           :selected="$kondisi->tingkat_kerusakan ?? 'ringan'" />
            <x-form.input label="Tanggal Pemeriksaan" name="kondisi.tanggal_periksa" type="date" :value="$tanggal" />
        </div>

        <label class="check">
            <input type="checkbox" name="kondisi[ada_jamur]" value="1" @checked($jamur)> Ada jamur
        </label>
        <label class="check">
            <input type="checkbox" name="kondisi[sticky_shed]" value="1" @checked($sticky)> Sticky-shed (lapisan magnetik lengket)
        </label>

        <x-form.textarea label="Catatan Kondisi" name="kondisi.catatan" :value="$kondisi->catatan ?? null" />
    </x-card>

    <x-card title="3. Rencana Tindakan Restorasi (pilihan jamak)">
        @error('tindakan')
            <small class="error">{{ $message }}</small>
        @enderror

        <div class="tindakan-row" style="font-weight:700;">
            <span>Tindakan</span><span>Prioritas</span><span>Status</span>
        </div>

        @forelse ($tindakans as $t)
            @php
                $aktif = $adaOld ? (bool) old("tindakan.{$t->id}.aktif") : isset($pilihan[$t->id]);
                $prioritas = old("tindakan.{$t->id}.prioritas", $pilihan[$t->id]['prioritas'] ?? 3);
                $status = old("tindakan.{$t->id}.status", $pilihan[$t->id]['status'] ?? 'rencana');
            @endphp
            <div class="tindakan-row">
                <label class="check" style="margin:0;">
                    <input type="checkbox" name="tindakan[{{ $t->id }}][aktif]" value="1" @checked($aktif)>
                    <span>{{ $t->nama }} <small style="color:var(--muted)">(~{{ $t->estimasi_jam }} jam)</small></span>
                </label>
                <input type="number" name="tindakan[{{ $t->id }}][prioritas]" min="1" max="5" value="{{ $prioritas }}">
                <select name="tindakan[{{ $t->id }}][status]">
                    @foreach (['rencana' => 'Rencana', 'berjalan' => 'Berjalan', 'selesai' => 'Selesai'] as $val => $label)
                        <option value="{{ $val }}" @selected($status === $val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        @empty
            <x-empty-state title="Belum ada master tindakan" description="Tambahkan dulu di menu Tindakan Restorasi." />
        @endforelse
    </x-card>

    <div class="actions">
        <x-button type="submit" variant="success">{{ $koleksi->exists ? 'Perbarui' : 'Simpan' }}</x-button>
        <x-button :href="route('koleksi.index')" variant="secondary">Batal</x-button>
    </div>
</form>
