<?php
include 'config/database.php';
$game = isset($_GET['game']) ? htmlspecialchars($_GET['game']) : '';
if (!$game) { header("Location: index.php"); exit(); }

$stmt = mysqli_prepare($koneksi, "SELECT * FROM produk_game WHERE nama_game = ? ORDER BY harga ASC");
mysqli_stmt_bind_param($stmt, "s", $game);
mysqli_stmt_execute($stmt);
$produk = mysqli_stmt_get_result($stmt);

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
$meta = $games_meta[$game] ?? [
    'genre'    => 'Game',
    'currency' => 'In-Game Currency',
    'img'      => 'assets/img/default.jpg',
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Up <?= $game ?> — Ucii Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #FFC107;
            --dark-bg: #0a0c14;
            --card-bg: #111527;
            --border: rgba(255,255,255,0.08);
            --muted: rgba(232,233,239,0.4);
        }
        * { box-sizing: border-box; }
        body {
            background: var(--dark-bg);
            font-family: 'DM Sans', sans-serif;
            color: #e8e9ef;
            min-height: 100vh;
        }

        /* ── Navbar ── */
        .navbar {
            background: rgba(10,12,20,0.97) !important;
            border-bottom: 1px solid rgba(255,193,7,0.12);
            height: 62px;
            padding: 0 1rem;
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
        .btn-back {
            font-size: 12px;
            padding: 7px 16px;
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 6px;
            color: var(--muted);
            background: transparent;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: border-color 0.2s, color 0.2s;
            text-decoration: none;
        }
        .btn-back:hover {
            border-color: rgba(255,255,255,0.25);
            color: #e8e9ef;
        }

        /* ── Game Banner ── */
        .game-banner {
            position: relative;
            height: 180px;
            overflow: hidden;
        }
        .game-banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        /* gradient bawah supaya teks terbaca */
        .game-banner::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to bottom,
                rgba(10,12,20,0.1) 0%,
                rgba(10,12,20,0.85) 100%
            );
        }
        .game-banner-info {
            position: absolute;
            bottom: 18px;
            left: 20px;
            z-index: 2;
        }
        .game-banner-tag {
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 4px;
        }
        .game-banner-name {
            font-family: 'Rajdhani', sans-serif;
            font-size: 26px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 1px;
            line-height: 1;
        }
        .game-banner-currency {
            font-size: 12px;
            color: rgba(232,233,239,0.5);
            margin-top: 3px;
        }

        /* ── Wrapper ── */
        .order-wrap {
            max-width: 620px;
            margin: 0 auto;
            padding: 0 1rem 60px;
        }

        /* ── Breadcrumb ── */
        .breadcrumb-bar {
            font-size: 11px;
            color: rgba(232,233,239,0.3);
            letter-spacing: 0.5px;
            padding: 14px 0 0;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .breadcrumb-bar span { color: var(--gold); }

        /* ── Step label ── */
        .step-label {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }
        .step-num {
            width: 24px; height: 24px;
            background: var(--gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: #0a0c14;
            flex-shrink: 0;
        }
        .step-text {
            font-family: 'Rajdhani', sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: #fff;
            letter-spacing: 0.5px;
        }

        /* ── Form section ── */
        .form-section { margin-bottom: 32px; }
        .op-input {
            width: 100%;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 12px 14px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            color: #e8e9ef;
            outline: none;
            transition: border-color 0.2s;
        }
        .op-input:focus { border-color: rgba(255,193,7,0.5); }
        .op-input::placeholder { color: rgba(232,233,239,0.22); }
        .input-hint {
            font-size: 11px;
            color: rgba(232,233,239,0.28);
            margin-top: 5px;
            padding-left: 2px;
        }

        /* ── Nominal grid ── */
        .nominal-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }
        @media (max-width: 480px) {
            .nominal-grid { grid-template-columns: repeat(2, 1fr); }
        }
        .nominal-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 14px 10px;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
            user-select: none;
        }
        .nominal-card:hover { border-color: rgba(255,193,7,0.35); }
        .nominal-card.selected {
            border-color: var(--gold);
            background: rgba(255,193,7,0.07);
        }
        .nominal-amt {
            font-family: 'Rajdhani', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 5px;
        }
        .nominal-price {
            font-size: 12px;
            font-weight: 500;
            color: var(--gold);
        }

        /* ── Summary ── */
        .order-summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255,193,7,0.05);
            border: 1px solid rgba(255,193,7,0.18);
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 16px;
        }
        .summary-label { font-size: 11px; color: var(--muted); margin-bottom: 3px; }
        .summary-val {
            font-family: 'Rajdhani', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: #fff;
        }
        .summary-price {
            font-family: 'Rajdhani', sans-serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--gold);
        }

        /* ── Submit ── */
        .btn-order {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 15px;
            background: var(--gold);
            border: none;
            border-radius: 10px;
            font-family: 'Rajdhani', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: #0a0c14;
            letter-spacing: 1px;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }
        .btn-order:hover { background: #e6b000; }
        .btn-order:active { transform: scale(0.99); }
        .btn-order:disabled {
            background: rgba(255,193,7,0.25);
            color: rgba(10,12,20,0.5);
            cursor: not-allowed;
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
            <a href="index.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</nav>

<!-- Banner Game -->
<div class="game-banner">
    <img src="<?= htmlspecialchars($meta['img']) ?>"
         alt="<?= htmlspecialchars($game) ?>">
    <div class="game-banner-info">
        <div class="game-banner-tag"><?= htmlspecialchars($meta['genre']) ?></div>
        <div class="game-banner-name"><?= htmlspecialchars($game) ?></div>
        <div class="game-banner-currency"><?= htmlspecialchars($meta['currency']) ?></div>
    </div>
</div>

<div class="order-wrap">

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        Beranda
        <i class="fas fa-chevron-right" style="font-size:9px"></i>
        <span>Top Up <?= htmlspecialchars($game) ?></span>
    </div>

    <form action="proses-order.php" method="POST" id="orderForm">
        <input type="hidden" name="nama_game" value="<?= $game ?>">
        <input type="hidden" name="nominal_harga" id="nominal_harga">

        <!-- Step 1: ID Akun -->
        <div class="form-section">
            <div class="step-label">
                <div class="step-num">1</div>
                <div class="step-text">Masukkan ID Akun Game</div>
            </div>
            <div class="row g-2">
                <div class="col-7">
                    <input type="text" class="op-input" name="user_id"
                           placeholder="User ID" required autocomplete="off">
                    <div class="input-hint">Cek di profil dalam game</div>
                </div>
                <div class="col-5">
                    <input type="text" class="op-input" name="zone_id"
                           placeholder="Zone ID (opsional)" autocomplete="off">
                    <div class="input-hint">Khusus ML & sejenis</div>
                </div>
            </div>
        </div>

        <!-- Step 2: Nominal -->
        <div class="form-section">
            <div class="step-label">
                <div class="step-num">2</div>
                <div class="step-text">Pilih Nominal</div>
            </div>
            <div class="nominal-grid">
                <?php while ($item = mysqli_fetch_assoc($produk)): ?>
                <div class="nominal-card"
                     onclick="pilihNominal('<?= $item['nominal'] ?>|<?= $item['harga'] ?>', this)">
                    <div class="nominal-amt"><?= $item['nominal'] ?></div>
                    <div class="nominal-price">Rp <?= number_format($item['harga'], 0, ',', '.') ?></div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Summary -->
        <div class="order-summary" id="summary" style="display:none">
            <div>
                <div class="summary-label">Nominal dipilih</div>
                <div class="summary-val" id="summary-nominal">—</div>
            </div>
            <div style="text-align:right">
                <div class="summary-label">Total bayar</div>
                <div class="summary-price" id="summary-price">—</div>
            </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-order" id="btnOrder" disabled>
            <i class="fab fa-whatsapp" style="font-size:20px"></i>
            Pesan via WhatsApp
        </button>
    </form>

</div>

<script>
function pilihNominal(value, el) {
    document.querySelectorAll('.nominal-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('nominal_harga').value = value;

    const [nominal, harga] = value.split('|');
    document.getElementById('summary-nominal').textContent = nominal;
    document.getElementById('summary-price').textContent =
        'Rp ' + new Intl.NumberFormat('id-ID').format(harga);

    document.getElementById('summary').style.display = 'flex';
    document.getElementById('btnOrder').disabled = false;
}

document.getElementById('orderForm').addEventListener('submit', function(e) {
    if (!document.getElementById('nominal_harga').value) {
        e.preventDefault();
        alert('Pilih nominal terlebih dahulu.');
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>