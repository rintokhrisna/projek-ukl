<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\News; // Digunakan untuk relasi dalam metode index jika mengambil komentar berdasarkan berita
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource; // Import CommentResource yang akan kita buat selanjutnya

class CommentApiController extends Controller
{
    /**
     * Mengambil daftar komentar untuk suatu berita tertentu.
     * Endpoint: GET /api/news/{news}/comments
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(News $news)
    {
        // Mengambil komentar utama (parent_id is null) dan memuat balasannya secara rekursif
        // Urutkan berdasarkan waktu pembuatan dari yang terlama ke yang terbaru
        $comments = $news->comments()
                         ->whereNull('parent_id')
                         ->with('replies')
                         ->orderBy('created_at', 'asc')
                         ->get();

        // Mengembalikan koleksi komentar dalam format JSON menggunakan CommentResource
        return CommentResource::collection($comments);
    }

    /**
     * Menyimpan komentar baru.
     * Endpoint: POST /api/comments
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\CommentResource
     */
    public function store(Request $request)
    {
        // Validasi input dari permintaan API
        $validatedData = $request->validate([
            'news_id' => 'required|exists:news,id',
            'parent_id' => 'nullable|exists:comments,id', // Untuk balasan komentar (opsional)
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'nullable|email|max:255', // Email tamu (opsional)
            'body' => 'required|string',
        ]);

        // Secara default, komentar disetujui (sesuai migrasi database Anda)
        $validatedData['approved'] = true;

        // Buat komentar baru di database
        $comment = Comment::create($validatedData);

        // Mengembalikan komentar yang baru dibuat dalam format JSON dengan status 201 Created
        return new CommentResource($comment);
    }

    // Anda bisa menambahkan metode update dan destroy di sini jika diperlukan
    // Misalnya:
    // public function update(Request $request, Comment $comment)
    // {
    //     // Validasi dan update komentar
    //     $validatedData = $request->validate([
    //         'guest_name' => 'required|string|max:255',
    //         'guest_email' => 'nullable|email|max:255',
    //         'body' => 'required|string',
    //         'approved' => 'boolean',
    //     ]);
    //     $comment->update($validatedData);
    //     return new CommentResource($comment);
    // }

    // public function destroy(Comment $comment)
    // {
    //     $comment->delete();
    //     return response()->json(null, 204); // 204 No Content
    // }
}
