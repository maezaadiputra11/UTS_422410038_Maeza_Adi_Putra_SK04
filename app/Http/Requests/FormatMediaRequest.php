<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FormatMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('formatMedia')?->id;

        return [
            'kode' => ['required', 'string', 'max:10', Rule::unique('format_media', 'kode')->ignore($id)],
            'nama' => ['required', 'string', 'max:100', Rule::unique('format_media', 'nama')->ignore($id)],
            'keterangan' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'unique' => ':attribute sudah dipakai.',
            'max' => ':attribute maksimal :max karakter.',
        ];
    }
}
