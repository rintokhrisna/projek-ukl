<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Resources\NewsResource; // Import NewsResource yang akan kita buat selanjutnya
use Illuminate\Support\Facades\Storage; // Digunakan jika ingin mengelola gambar via API juga

class NewsApiController extends Controller
{
    /**
     * Mengambil daftar semua berita terbaru.
     * Mengembalikan koleksi berita dalam format JSON.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return News::latest()->paginate(10);
    }

    public function show($id)
    {
        $news = News::with(['comments' => function ($query) {
            $query->whereNull('parent_id')->with('replies')->orderBy('created_at', 'asc');
        }])->find($id);

        if (!$news) {
            return response()->json(['message' => 'News not found'], 404);
        }

        // Tambahkan jumlah view
        $news->increment('views');

        return response()->json($news);
    }

    /**
     * Menyimpan berita baru.
     * Endpoint ini akan memerlukan autentikasi API (misalnya dengan Laravel Sanctum).
     * Mengembalikan berita yang baru dibuat dalam format JSON.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\NewsResource
     */
    public function store(Request $request)
    {
        // Validasi data input dari permintaan API
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            // Jika Anda mengunggah gambar via API, logika akan lebih kompleks (base64, dll.)
            // Untuk kesederhanaan, kita asumsikan 'image' adalah URL langsung dari gambar.
            'image' => 'nullable|url|max:255', // Field name 'image' sesuai model News
            'body' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        // Buat instance News baru
        $news = News::create($validatedData); // Slug akan otomatis dibuat oleh mutator di model News

        // Mengembalikan berita yang baru dibuat dalam format JSON dengan status 201 Created
        return new NewsResource($news);
    }

    /**
     * Memperbarui berita yang ada.
     * Endpoint ini akan memerlukan autentikasi API.
     * Mengembalikan berita yang diperbarui dalam format JSON.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \App\Http\Resources\NewsResource
     */
    public function update(Request $request, News $news)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|url|max:255', // Field name 'image' sesuai model News
            'body' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        // Perbarui atribut berita
        $news->update($validatedData); // Slug akan diperbarui otomatis oleh mutator di model News

        return new NewsResource($news);
    }

    /**
     * Menghapus berita.
     * Endpoint ini akan memerlukan autentikasi API.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(News $news)
    {
        // Logika penghapusan gambar terkait jika diperlukan.
        // Asumsi saat ini gambar dikelola secara terpisah atau hanya URL yang disimpan di DB.
        // Jika Anda ingin menghapus file fisik, Anda perlu menambahkan logika Storage::delete di sini.

        $news->delete();

        // Mengembalikan respons 204 No Content untuk indikasi sukses penghapusan tanpa body
        return response()->json(null, 204);
    }
}
