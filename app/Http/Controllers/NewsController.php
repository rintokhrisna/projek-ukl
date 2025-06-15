<?php

namespace App\Http\Controllers;

use App\Models\News; // Import model News
use App\Models\User; // Import model User untuk dropdown penulis
use App\Models\Category; // Import model Category untuk dropdown kategori
use Illuminate\Http\Request;
use App\Http\Requests\NewsStoreRequest; // Import Form Request kita
use Illuminate\Support\Str; // Untuk membuat slug
use Illuminate\Support\Facades\Storage; // Untuk upload gambar

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Nanti akan menampilkan daftar berita
        $news = News::with(['user', 'category'])->latest()->paginate(10);
        return view('news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua user (untuk dropdown penulis)
        $users = User::all();
        // Ambil semua kategori (untuk dropdown kategori)
        $categories = Category::all();

        // Tampilkan form penambahan berita baru, kirim data users dan categories
        return view('news.create', compact('users', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsStoreRequest $request)
    {
        // Validasi data menggunakan NewsStoreRequest
        $validatedData = $request->validated();

        // Tangani upload gambar jika ada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news_images', 'public'); // Simpan di storage/app/public/news_images
            $validatedData['image'] = $imagePath;
        }

        // Pastikan slug dibuat jika tidak ada dari input (atau jika perlu di-generate ulang)
        if (!isset($validatedData['slug']) || empty($validatedData['slug'])) {
            $validatedData['slug'] = Str::slug($validatedData['title']);
        }
        
        // Buat berita baru di database
        News::create($validatedData);

        // Redirect ke halaman daftar berita dengan pesan sukses
        return redirect()->route('news.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        // Nanti akan menampilkan detail berita
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        // Nanti akan menampilkan form edit berita
        $users = User::all();
        $categories = Category::all();
        return view('news.edit', compact('news', 'users', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        // Nanti akan mengupdate berita
        // Anda juga bisa buat NewsUpdateRequest seperti UserUpdateRequest
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('news', 'slug')->ignore($news->id)],
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'body' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        $validatedData = $request->all();

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $imagePath = $request->file('image')->store('news_images', 'public');
            $validatedData['image'] = $imagePath;
        } else {
            // Pertahankan gambar lama jika tidak ada gambar baru yang diunggah
            $validatedData['image'] = $news->image;
        }
        
        // Regenerate slug if title changes and slug is not manually set
        if (!isset($validatedData['slug']) || empty($validatedData['slug']) || $validatedData['slug'] == Str::slug($news->title)) {
             $validatedData['slug'] = Str::slug($validatedData['title']);
        }


        $news->update($validatedData);

        return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        // Nanti akan menghapus berita
        // Hapus juga gambar terkait jika ada
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }
        $news->delete();
        return redirect()->route('news.index')->with('success', 'Berita berhasil dihapus!');
    }
}