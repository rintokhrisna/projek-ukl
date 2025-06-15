<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Portal Berita Kami</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* Light gray background color */
        }
        .hero-section {
            /* Using a placeholder image for demonstration */
            background-image: url('https://placehold.co/1200x600/1e40af/ffffff?text=Berita+Terbaru');
            background-size: cover;
            background-position: center;
            height: 60vh; /* Viewport height */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
            z-index: 1;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5); /* Dark overlay */
            z-index: -1;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="bg-gray-800 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-white text-2xl font-bold rounded-lg hover:text-gray-300 transition duration-300">Portal Berita</a>
            <div class="flex space-x-4">
                <a href="{{ route('news.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 transform hover:scale-105">Tambahkan Berita</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section">
        <div class="p-4 sm:p-6 md:p-8">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold mb-4 drop-shadow-lg">
                Temukan Berita Terbaru
            </h1>
            <p class="text-lg sm:text-xl md:text-2xl mb-8 font-light drop-shadow-md">
                Baca artikel menarik dan tetap terinformasi.
            </p>
            {{-- Tombol ini sekarang mengarah ke halaman berita publik --}}
            <a href="{{ route('news.public_index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full text-lg shadow-xl transition duration-300 transform hover:scale-105">
                Lihat Berita
            </a>
        </div>
    </header>

    <!-- Content Section - Example -->
    <main class="container mx-auto p-4 sm:p-6 md:p-8 mt-8">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Tentang Kami</h2>
            <p class="text-gray-700 leading-relaxed max-w-2xl mx-auto">
                Kami adalah sumber terpercaya Anda untuk berita terkini dan artikel mendalam dari berbagai kategori.
                Tetap terhubung dengan dunia melalui informasi yang akurat dan relevan.
            </p>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white p-6 text-center mt-12">
        <p>&copy; {{ date('Y') }} Portal Berita. All rights reserved.</p>
    </footer>
</body>
</html>
