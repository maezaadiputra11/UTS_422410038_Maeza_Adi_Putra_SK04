<?php

namespace App\Http\Requests;

use App\Models\KondisiAwal;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Dipakai untuk store DAN update koleksi.
 * Saat update, route parameter {koleksiPita} sudah berupa model, sehingga
 * rule unique bisa mengabaikan baris miliknya sendiri.
 */
class KoleksiPitaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('koleksiPita')?->id;

        return [
            'format_media_id' => ['required', 'integer', 'exists:format_media,id'],
            'kode' => ['required', 'string', 'max:20', Rule::unique('koleksi_pitas', 'kode')->ignore($id)],
            'nama' => ['required', 'string', 'max:150'],
            'tahun_rekaman' => ['nullable', 'integer', 'between:1920,'.date('Y')],
            'deskripsi' => ['nullable', 'string', 'max:2000'],

            // Detail one-to-one
            'kondisi.tingkat_kerusakan' => ['required', Rule::in(KondisiAwal::TINGKAT)],
            'kondisi.ada_jamur' => ['nullable', 'boolean'],
            'kondisi.sticky_shed' => ['nullable', 'boolean'],
            'kondisi.tanggal_periksa' => ['nullable', 'date'],
            'kondisi.catatan' => ['nullable', 'string', 'max:2000'],

            // Pilihan jamak (many-to-many + atribut pivot)
            'tindakan' => ['nullable', 'array'],
            'tindakan.*.aktif' => ['nullable', 'boolean'],
            'tindakan.*.prioritas' => ['nullable', 'integer', 'between:1,5'],
            'tindakan.*.status' => ['nullable', Rule::in(['rencana', 'berjalan', 'selesai'])],
        ];
    }

    public function attributes(): array
    {
        return [
            'format_media_id' => 'format media',
            'kode' => 'kode koleksi',
            'nama' => 'nama koleksi',
            'tahun_rekaman' => 'tahun rekaman',
            'kondisi.tingkat_kerusakan' => 'tingkat kerusakan',
            'kondisi.tanggal_periksa' => 'tanggal pemeriksaan',
            'kondisi.catatan' => 'catatan kondisi',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'unique' => ':attribute sudah dipakai.',
            'exists' => ':attribute tidak valid.',
            'max' => ':attribute maksimal :max karakter.',
            'integer' => ':attribute harus berupa angka.',
            'between' => ':attribute harus di antara :min dan :max.',
            'date' => ':attribute bukan tanggal yang valid.',
            'in' => ':attribute tidak valid.',
        ];
    }
}
