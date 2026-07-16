<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f1f5f9; min-height: 100vh; display: flex; align-items: center; }
        .error-container { text-align: center; }
        .error-code { font-size: 8rem; font-weight: 900; background: linear-gradient(135deg, #2563eb, #60a5fa); -webkit-background-clip: text; background-clip: text; color: transparent; }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-container">
            <div class="error-code">404</div>
            <h2 class="fw-bold mb-3">Halaman Tidak Ditemukan</h2>
            <p class="text-muted mb-4">Halaman yang Anda cari tidak tersedia atau sudah dipindahkan.</p>
            <a href="{{ url('/') }}" class="btn btn-primary rounded-pill px-5 py-2">
                <i class="bi bi-house me-1"></i> Kembali ke Home
            </a>
        </div>
    </div>
</body>
</html>
