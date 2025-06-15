<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource for admin (with full CRUD options).
     */
    public function index()
    {
        $news = News::latest()->paginate(10);
        return view('news.index', compact('news'));
    }

    /**
     * Display a public, read-only listing of the resource.
     */
    public function publicIndex()
    {
        // Mengambil semua berita terbaru, dengan paginasi
        $news = News::latest()->paginate(9); // Contoh: tampilkan 9 berita per halaman
        return view('news.public_index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Maks 2MB
            'body' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        // Handle upload gambar jika ada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images/news');
            $validatedData['image'] = Storage::url($imagePath);
        }

        // Buat berita baru
        News::create($validatedData);

        return redirect()->route('news.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        // Eager load hanya komentar tingkat atas (parent_id is null) dan balasannya secara rekursif.
        // Ini memastikan semua komentar terkait dengan berita dimuat untuk ditampilkan.
        $news->load(['comments' => function ($query) {
            $query->whereNull('parent_id') // Filter untuk hanya mengambil komentar utama
                  ->with('replies') // Load balasannya secara rekursif
                  ->orderBy('created_at', 'asc'); // Urutkan komentar (dan balasannya) berdasarkan waktu pembuatan
        }]);

        // Increment jumlah tampilan setiap kali berita diakses
        $news->increment('views');
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        // Validasi input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'body' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        // Handle update gambar jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($news->image) {
                Storage::delete(str_replace('/storage', 'public', $news->image));
            }
            $imagePath = $request->file('image')->store('public/images/news');
            $validatedData['image'] = Storage::url($imagePath);
        } else {
            // Jika tidak ada gambar baru, pertahankan gambar lama
            $validatedData['image'] = $news->image;
        }

        // Update berita
        $news->update($validatedData);

        return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        // Hapus gambar terkait jika ada
        if ($news->image) {
            Storage::delete(str_replace('/storage', 'public', $news->image));
        }

        // Hapus berita (ini juga akan menghapus komentar terkait karena onDelete('cascade') di migrasi)
        $news->delete();

        return redirect()->route('news.index')->with('success', 'Berita berhasil dihapus!');
    }
}
