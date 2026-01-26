<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'city_id' => ['required', 'exists:cities,id'],
            'ktp_number' => ['nullable', 'string', 'size:16', 'regex:/^[0-9]{16}$/', Rule::unique('users')->ignore($this->user()->id)],
            'ktp_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }

    /**
     * Get custom error messages
     */
    public function messages(): array
    {
        return [
            'ktp_number.size' => 'Nomor KTP harus 16 digit',
            'ktp_number.regex' => 'Nomor KTP hanya boleh berisi angka',
            'ktp_number.unique' => 'Nomor KTP sudah terdaftar di akun lain',
            'ktp_photo.image' => 'File harus berupa gambar',
            'ktp_photo.mimes' => 'Format gambar harus JPG atau PNG',
            'ktp_photo.max' => 'Ukuran file maksimal 2MB',
        ];
    }
}
