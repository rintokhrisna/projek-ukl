<?php

namespace App\Http\Controllers;

use App\Models\User; // Import model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Untuk hash password
use App\Http\Requests\UserStoreRequest; // Kita akan buat ini nanti
use App\Http\Requests\UserUpdateRequest; // Kita akan buat ini nanti

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data user dari database
        $users = User::latest()->paginate(10); // Ambil 10 user per halaman, diurutkan terbaru

        // Kirim data user ke view
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tampilkan form untuk menambah user baru
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request) // Gunakan UserStoreRequest untuk validasi
    {
        // Data yang sudah divalidasi dari UserStoreRequest
        $validatedData = $request->validated();

        // Hash password sebelum disimpan
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Buat user baru
        User::create($validatedData);

        // Redirect ke halaman daftar user dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Tampilkan detail user
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Tampilkan form untuk mengedit user
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user) // Gunakan UserUpdateRequest
    {
        // Data yang sudah divalidasi dari UserUpdateRequest
        $validatedData = $request->validated();

        // Jika ada password baru, hash password tersebut
        if ($request->filled('password')) { // Memastikan field password diisi
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            // Jika password tidak diisi, hapus dari data validasi agar tidak mengubah password lama
            unset($validatedData['password']);
        }

        // Update data user
        $user->update($validatedData);

        // Redirect ke halaman daftar user dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Hapus user
        $user->delete();

        // Redirect ke halaman daftar user dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}