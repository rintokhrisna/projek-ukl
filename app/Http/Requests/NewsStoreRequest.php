<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Ganti ini menjadi true jika Anda ingin mengizinkan siapa saja (atau tambahkan logika otorisasi di sini)
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                // Pastikan slug unik di tabel 'news'
                Rule::unique('news', 'slug'),
            ],
            'user_id' => 'required|exists:users,id', // Harus ada di tabel users
            'category_id' => 'required|exists:categories,id', // Harus ada di tabel categories
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Opsional, format gambar, maks 2MB
            'body' => 'required|string',
            'published_at' => 'nullable|date', // Opsional, tanggal harus format tanggal
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul berita wajib diisi.',
            'slug.required' => 'Slug berita wajib diisi.',
            'slug.unique' => 'Slug ini sudah digunakan, silakan pilih yang lain.',
            'user_id.required' => 'Penulis berita wajib dipilih.',
            'user_id.exists' => 'Penulis yang dipilih tidak valid.',
            'category_id.required' => 'Kategori berita wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar yang diizinkan: jpeg, png, jpg, gif, svg.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'body.required' => 'Isi berita wajib diisi.',
            'published_at.date' => 'Format tanggal publikasi tidak valid.',
        ];
    }
}