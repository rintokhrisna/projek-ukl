<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail User: {{ $user->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="mb-4">Detail User</h1>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3"><strong>ID:</strong></div>
                    <div class="col-md-9">{{ $user->id }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Nama:</strong></div>
                    <div class="col-md-9">{{ $user->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Email:</strong></div>
                    <div class="col-md-9">{{ $user->email }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Email Terverifikasi Pada:</strong></div>
                    <div class="col-md-9">{{ $user->email_verified_at ? $user->email_verified_at->format('d M Y H:i') : '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Dibuat Pada:</strong></div>
                    <div class="col-md-9">{{ $user->created_at->format('d M Y H:i') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Diperbarui Pada:</strong></div>
                    <div class="col-md-9">{{ $user->updated_at->format('d M Y H:i') }}</div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning me-2">Edit</a>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>