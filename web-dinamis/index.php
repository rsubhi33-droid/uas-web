<?php include 'config/database.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ucii Store-2388010043 - Top Up Murah & Cepat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #FFC107;
            --dark-bg: #0a0c14;
            --card-bg: #111527;
            --text-muted: rgba(232,233,239,0.45);
        }

        * { box-sizing: border-box; }

        body {
            background-color: var(--dark-bg);
            font-family: 'DM Sans', sans-serif;
            color: #e8e9ef;
            min-height: 100vh;
        }

        /* ── Navbar ── */
        .navbar {
            background: rgba(10,12,20,0.97) !important;
            border-bottom: 1px solid rgba(255,193,7,0.12);
            padding: 0 1rem;
            height: 62px;
        }
        .navbar-brand {
            font-family: 'Rajdhani', sans-serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--gold) !important;
            letter-spacing: 2px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .brand-dot {
            width: 8px; height: 8px;
            background: var(--gold);
            border-radius: 50%;
            box-shadow: 0 0 8px var(--gold);
        }
        .btn-cek {
            font-size: 12px;
            font-weight: 500;
            padding: 7px 18px;
            border: 1px solid rgba(255,193,7,0.35);
            border-radius: 6px;
            color: var(--gold);
            background: transparent;
            letter-spacing: 0.5px;
            transition: background 0.2s, border-color 0.2s;
        }
        .btn-cek:hover {
            background: rgba(255,193,7,0.1);
            border-color: var(--gold);
            color: var(--gold);
        }

        /* ── Hero ── */
        .hero {
            background: linear-gradient(135deg, #0a0c14 0%, #111527 55%, #0d1020 100%);
            padding: 56px 0 48px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: -80px; left: 50%; transform: translateX(-50%);
            width: 600px; height: 240px;
            background: radial-gradient(ellipse, rgba(255,193,7,0.07) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-label {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 3.5px;
            color: var(--gold);
            text-transform: uppercase;
            margin-bottom: 14px;
        }
        .hero h1 {
            font-family: 'Rajdhani', sans-serif;
            font-size: clamp(32px, 5vw, 48px);
            font-weight: 700;
            color: #fff;
            line-height: 1.1;
            letter-spacing: 1px;
        }
        .hero h1 span { color: var(--gold); }
        .hero-sub {
            font-size: 14px;
            color: var(--text-muted);
            margin-top: 10px;
            font-weight: 300;
        }
        .hero-badges {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 22px;
            flex-wrap: wrap;
        }
        .hero-badge {
            font-size: 11px;
            padding: 5px 14px;
            border-radius: 20px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.09);
            color: var(--text-muted);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .badge-dot {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: #4ade80;
        }

        /* ── Section ── */
        .section-head {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
        }
        .section-line {
            width: 3px; height: 20px;
            background: var(--gold);
            border-radius: 2px;
        }
        .section-title {
            font-family: 'Rajdhani', sans-serif;
            font-size: 18px;
            font-weight: 600;
            color: #fff;
            letter-spacing: 1px;
            margin: 0;
        }

        /* ── Game Card ── */
        .game-card {
            background: var(--card-bg);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 12px;
            overflow: hidden;
            transition: border-color 0.25s, transform 0.25s;
            cursor: pointer;
            text-decoration: none;
            display: block;
            color: inherit;
        }
        .game-card:hover {
            border-color: rgba(255,193,7,0.45);
            transform: translateY(-4px);
            color: inherit;
        }
        .game-card-img-wrap {
            position: relative;
            height: 140px;
            overflow: hidden;
        }
        .game-card-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .game-card-img-wrap::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 60%;
            background: linear-gradient(to bottom, transparent, var(--card-bg));
        }
        .game-card-body {
            padding: 12px 16px 16px;
        }
        .game-card-tag {
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 3px;
        }
        .game-card-name {
            font-family: 'Rajdhani', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .game-card-currency {
            font-size: 11px;
            color: var(--text-muted);
            margin-bottom: 14px;
        }
        .btn-topup {
            display: block;
            width: 100%;
            padding: 10px;
            background: var(--gold);
            border: none;
            border-radius: 7px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 700;
            color: #0a0c14;
            text-align: center;
            letter-spacing: 0.5px;
            transition: background 0.2s, transform 0.1s;
        }
        .btn-topup:hover {
            background: #e6b000;
            color: #0a0c14;
            transform: scale(1.02);
        }

        /* ── Footer ── */
        footer {
            border-top: 1px solid rgba(255,255,255,0.07);
            padding: 24px 0;
            color: rgba(232,233,239,0.25);
            font-size: 12px;
            text-align: center;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <div class="brand-dot"></div>
            UCII STORE
        </a>
        <div class="ms-auto">
            <a href="cek-invoice.php" class="btn-cek">
                <i class="fas fa-search me-1"></i>Cek Pesanan
            </a>
        </div>
    </div>
</nav>

<!-- Hero -->
<section class="hero">
    <div class="container">
        <div class="hero-label">Top Up Terpercaya</div>
        <h1>Top Up Game<br><span>Murah & Cepat</span></h1>
        <p class="hero-sub">Proses otomatis via WhatsApp — aman, terpercaya, 24 jam.</p>
        <div class="hero-badges">
            <span class="hero-badge"><span class="badge-dot"></span> Proses Instan</span>
            <span class="hero-badge"><span class="badge-dot"></span> Harga Terjangkau</span>
            <span class="hero-badge"><span class="badge-dot"></span> 24 Jam Online</span>
        </div>
    </div>
</section>

<!-- Game List -->
<div class="container my-5">
    <div class="section-head">
        <div class="section-line"></div>
        <h4 class="section-title">Pilih Game</h4>
    </div>

    <?php
    // Data game: nama_game => [genre, currency, gambar]
    $games_meta = [
        'Mobile Legends' => [
            'genre'    => 'MOBA',
            'currency' => 'Diamonds',
            'img'      => 'assets/img/Mobile legends.jpg',
        ],
        'Free Fire' => [
            'genre'    => 'Battle Royale',
            'currency' => 'Diamonds',
            'img'      => 'assets/img/Free Fire.jpg',
        ],
        'Genshin Impact' => [
            'genre'    => 'RPG',
            'currency' => 'Primogems',
            'img'      => 'assets/img/Genshin Impact.jpg',
        ],
    ];
    ?>

    <div class="row g-4">
        <?php
        $result = mysqli_query($koneksi, "SELECT DISTINCT nama_game FROM produk_game ORDER BY nama_game");
        while ($row = mysqli_fetch_assoc($result)):
            $nama = $row['nama_game'];
            $meta = $games_meta[$nama] ?? [
                'genre'    => 'Game',
                'currency' => 'In-Game Currency',
                'img'      => 'https://images.unsplash.com/photo-1493711662062-fa541adb3fc8?w=600&q=80',
            ];
        ?>
        <div class="col-6 col-md-4 col-lg-4">
            <a href="order.php?game=<?= urlencode($nama) ?>" class="game-card">
                <div class="game-card-img-wrap">
                    <img src="<?= htmlspecialchars($meta['img']) ?>"
                         alt="<?= htmlspecialchars($nama) ?>"
                         loading="lazy">
                </div>
                <div class="game-card-body">
                    <div class="game-card-tag"><?= htmlspecialchars($meta['genre']) ?></div>
                    <div class="game-card-name"><?= htmlspecialchars($nama) ?></div>
                    <div class="game-card-currency"><?= htmlspecialchars($meta['currency']) ?></div>
                    <div class="btn-topup">Top Up Sekarang</div>
                </div>
            </a>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Footer -->
<footer>
    <div class="container">
        <small>© 2024 Ucii Store — Moch Subchi Ramadhani (2388010043)</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>