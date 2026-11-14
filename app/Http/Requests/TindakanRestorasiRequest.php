<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TindakanRestorasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('tindakanRestorasi')?->id;

        return [
            'nama' => ['required', 'string', 'max:120', Rule::unique('tindakan_restorasis', 'nama')->ignore($id)],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'estimasi_jam' => ['required', 'integer', 'between:1,200'],
            'aktif' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'unique' => ':attribute sudah dipakai.',
            'max' => ':attribute maksimal :max karakter.',
            'integer' => ':attribute harus berupa angka.',
            'between' => ':attribute harus di antara :min dan :max.',
        ];
    }
}
