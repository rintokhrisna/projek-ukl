<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Berita Anda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing') }}">Portal Berita Anda</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('landing') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-success text-white px-3" href="{{ route('news.create') }}">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Berita Baru
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">Manajemen User</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid bg-light text-dark text-center py-5">
        <div class="container">
            <h1 class="display-4">Selamat Datang di Portal Berita Anda</h1>
            <p class="lead">Temukan berita terbaru, terpercaya, dan terkini dari berbagai penjuru dunia.</p>
            <hr class="my-4">
            <p>Kami hadir untuk memberikan informasi yang Anda butuhkan.</p>
            <a class="btn btn-primary btn-lg" href="#latest-news" role="button">Lihat Berita Terbaru</a>
        </div>
    </div>

    <main class="container my-5 flex-grow-1">
        <h2 class="text-center mb-4" id="latest-news">Berita Terbaru</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="https://via.placeholder.com/400x250?text=Gambar+Berita+1" class="card-img-top" alt="Gambar Berita">
                    <div class="card-body">
                        <h5 class="card-title">Judul Berita Pertama</h5>
                        <p class="card-text text-muted small">Kategori | Penulis | 1 Jam Lalu</p>
                        <p class="card-text">Ini adalah ringkasan singkat dari berita pertama. Klik untuk membaca lebih lanjut.</p>
                        <a href="#" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="https://via.placeholder.com/400x250?text=Gambar+Berita+2" class="card-img-top" alt="Gambar Berita">
                    <div class="card-body">
                        <h5 class="card-title">Judul Berita Kedua yang Lebih Panjang</h5>
                        <p class="card-text text-muted small">Kategori | Penulis | 2 Jam Lalu</p>
                        <p class="card-text">Ringkasan berita kedua yang memberikan sedikit gambaran tentang isinya.</p>
                        <a href="#" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="https://via.placeholder.com/400x250?text=Gambar+Berita+3" class="card-img-top" alt="Gambar Berita">
                    <div class="card-body">
                        <h5 class="card-title">Berita Ketiga</h5>
                        <p class="card-text text-muted small">Kategori | Penulis | 1 Hari Lalu</p>
                        <p class="card-text">Ini adalah ringkasan singkat dari berita ketiga.</p>
                        <a href="#" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="#" class="btn btn-outline-primary btn-lg">Lihat Semua Berita</a>
        </div>
    </main>

    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container text-center">
            <p>&copy; {{ date('Y') }} Portal Berita Anda. Semua Hak Cipta Dilindungi.</p>
            <p>Dibuat dengan ❤️ Laravel & Bootstrap.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>