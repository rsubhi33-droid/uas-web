<?php include 'config/database.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gaming Store - Top Up Murah & Cepat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary: #FFC107; --dark: #1a1a2e; }
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .navbar { background-color: var(--dark) !important; }
        .hero { background: linear-gradient(135deg, var(--dark), #16213e); color: white; padding: 60px 0; }
        .game-card { transition: transform 0.2s, box-shadow 0.2s; cursor: pointer; border: none; }
        .game-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important; }
        .game-icon { font-size: 3rem; margin-bottom: 15px; }
        .btn-topup { background-color: var(--primary); border: none; font-weight: bold; color: #000; }
        .btn-topup:hover { background-color: #e0a800; color: #000; }
        footer { background-color: var(--dark); color: #aaa; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="index.php">
            <i class="fas fa-gamepad text-warning me-2"></i>GAMING STORE
        </a>
        <div class="ms-auto">
            <a href="cek-invoice.php" class="btn btn-outline-warning btn-sm me-2">
                <i class="fas fa-search me-1"></i>Cek Pesanan
            </a>
        </div>
    </div>
</nav>

<section class="hero">
    <div class="container text-center">
        <h1 class="fw-bold display-5">Top Up Game <span class="text-warning">Murah & Cepat</span></h1>
        <p class="lead text-white-50 mt-2">Proses otomatis via WhatsApp. Aman, terpercaya, 24 jam.</p>
    </div>
</section>

<div class="container my-5">
    <h4 class="fw-bold mb-4">Pilih Game Favoritmu</h4>
    <div class="row g-4">
        <?php
        $result = mysqli_query($koneksi, "SELECT DISTINCT nama_game FROM produk_game ORDER BY nama_game");
        $games = [
            'Mobile Legends' => ['emoji' => '⚔️'],
            'Free Fire'      => ['emoji' => '🔥'],
            'Genshin Impact' => ['emoji' => '✨'],
        ];

        while ($row = mysqli_fetch_assoc($result)):
            $nama = $row['nama_game'];
            $info = $games[$nama] ?? ['emoji' => '🎮'];
        ?>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card game-card shadow-sm h-100 text-center p-3">
                <div class="game-icon"><?= $info['emoji'] ?></div>
                <h5 class="fw-bold"><?= htmlspecialchars($nama) ?></h5>
                <p class="text-muted small mb-3">Diamonds & Item In-Game</p>
                <a href="order.php?game=<?= urlencode($nama) ?>" class="btn btn-topup">
                    Top Up Sekarang
                </a>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<footer class="py-4 mt-5">
    <div class="container text-center">
        <small>© 2024 Gaming Store — Moch Subchi Ramadhani (2388010043)</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
