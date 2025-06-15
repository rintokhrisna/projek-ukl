<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the comments for administrative purposes.
     * Comments here can be moderated (approved/unapproved), edited, or deleted.
     */
    public function index()
    {
        // Mengambil semua komentar terbaru dengan paginasi, eager load relasi news dan parent
        $comments = Comment::latest()->with(['news', 'parent'])->paginate(10);
        return view('comments.index', compact('comments'));
    }

    /**
     * Store a newly created comment in storage.
     * This method is typically called from the news show page.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validatedData = $request->validate([
            'news_id' => 'required|exists:news,id',
            'parent_id' => 'nullable|exists:comments,id', // Optional for replies
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'nullable|email|max:255', // Email is optional for guests
            'body' => 'required|string',
        ]);

        // Default to approved = true, as per your migration default
        $validatedData['approved'] = true;

        // Buat komentar baru
        Comment::create($validatedData);

        // Redirect kembali ke halaman berita dengan pesan sukses
        return redirect()->route('news.show', $validatedData['news_id'])->with('success', 'Komentar berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified comment.
     */
    public function edit(Comment $comment)
    {
        // Eager load news relation for context in edit view
        $comment->load('news');
        return view('comments.edit', compact('comment'));
    }

    /**
     * Update the specified comment in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        // Validasi input
        $validatedData = $request->validate([
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'nullable|email|max:255',
            'body' => 'required|string',
            'approved' => 'boolean', // Allow changing approval status
        ]);

        // Update komentar
        $comment->update($validatedData);

        return redirect()->route('comments.index')->with('success', 'Komentar berhasil diperbarui!');
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete(); // Ini juga akan menghapus balasan jika onDelete('cascade') di migrasi

        return redirect()->route('comments.index')->with('success', 'Komentar berhasil dihapus!');
    }
}
