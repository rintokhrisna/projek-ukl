<!-- resources/views/comments/edit.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Komentar</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="p-4 sm:p-6 md:p-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Komentar</h1>

        <div class="bg-gray-100 p-4 rounded-lg mb-6">
            <p class="text-gray-700 text-sm">
                Komentar untuk artikel: <span class="font-semibold">{{ $comment->news->title ?? 'Tidak Ditemukan' }}</span>
                @if($comment->parent)
                    <br>Membalas komentar dari: <span class="font-semibold">{{ $comment->parent->guest_name }}</span>
                @endif
            </p>
        </div>

        <form action="{{ route('comments.update', $comment->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="guest_name" class="block text-gray-700 text-sm font-semibold mb-2">Nama Pengguna:</label>
                <input type="text" name="guest_name" id="guest_name" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('guest_name', $comment->guest_name) }}" required>
                @error('guest_name')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="guest_email" class="block text-gray-700 text-sm font-semibold mb-2">Email Pengguna (Opsional):</label>
                <input type="email" name="guest_email" id="guest_email" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('guest_email', $comment->guest_email) }}">
                @error('guest_email')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="body" class="block text-gray-700 text-sm font-semibold mb-2">Isi Komentar:</label>
                <textarea name="body" id="body" rows="5" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('body', $comment->body) }}</textarea>
                @error('body')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="approved" class="flex items-center text-gray-700 text-sm font-semibold">
                    <input type="checkbox" name="approved" id="approved" class="mr-2 rounded text-blue-600 focus:ring-blue-500" {{ old('approved', $comment->approved) ? 'checked' : '' }}>
                    Disetujui
                </label>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
                    Perbarui Komentar
                </button>
                <a href="{{ route('comments.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">
                    Batal
                </a>
            </div>
        </form>
    </div>
</body>
</html>
