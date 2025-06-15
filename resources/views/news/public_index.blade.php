<!-- news/public_index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Berita</title>
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
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Artikel Berita</h1>
            <a href="{{ url('/') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">Kembali ke Beranda</a>
        </div>

        @if ($news->isEmpty())
            <p class="text-gray-600 text-lg text-center mt-8">Tidak ada artikel berita ditemukan saat ini.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($news as $item)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                        @if ($item->image)
                            <img src="{{ $item->image }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500 text-base">Tidak Ada Gambar</div>
                        @endif
                        <div class="p-4">
                            <h2 class="text-xl font-bold text-gray-800 mb-2 truncate">{{ $item->title }}</h2>
                            <p class="text-gray-600 text-sm mb-3">
                                <span class="font-semibold">Dipublikasikan:</span> {{ $item->published_at ? \Carbon\Carbon::parse($item->published_at)->format('d M Y') : 'N/A' }}
                            </p>
                            <p class="text-gray-700 text-base line-clamp-3 mb-4">{{ $item->body }}</p>
                            <a href="{{ route('news.show', $item->id) }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg text-sm transition duration-300">Baca Selengkapnya</a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $news->links('pagination::tailwind') }} <!-- Laravel's default Tailwind pagination -->
            </div>
        @endif
    </div>
</body>
</html>
