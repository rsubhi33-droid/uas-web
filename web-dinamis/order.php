<?php
include 'config/database.php';
$game = isset($_GET['game']) ? htmlspecialchars($_GET['game']) : '';
if (!$game) { header("Location: index.php"); exit(); }

$stmt = mysqli_prepare($koneksi, "SELECT * FROM produk_game WHERE nama_game = ? ORDER BY harga ASC");
mysqli_stmt_bind_param($stmt, "s", $game);
mysqli_stmt_execute($stmt);
$produk = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Up <?= $game ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .nominal-card { cursor: pointer; border: 2px solid #dee2e6; transition: all 0.2s; }
        .nominal-card.selected { border-color: #FFC107; background-color: #fff9e6; }
        .nominal-card:hover { border-color: #FFC107; }
    </style>
</head>
<body>
<div class="container my-5" style="max-width: 650px;">
    <a href="index.php" class="btn btn-sm btn-secondary mb-3">← Kembali</a>
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0 fw-bold">🎮 Top Up: <?= $game ?></h5>
        </div>
        <div class="card-body">
            <form action="proses-order.php" method="POST">
                <input type="hidden" name="nama_game" value="<?= $game ?>">

                <div class="mb-4">
                    <label class="fw-bold mb-2">1. Masukkan ID Akun Game</label>
                    <div class="row g-2">
                        <div class="col-7">
                            <input type="text" class="form-control" name="user_id" placeholder="User ID" required>
                        </div>
                        <div class="col-5">
                            <input type="text" class="form-control" name="zone_id" placeholder="Zone ID (jika ada)">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="fw-bold mb-2">2. Pilih Nominal</label>
                    <input type="hidden" name="nominal_harga" id="nominal_harga" required>
                    <div class="row g-2" id="nominal-list">
                        <?php while ($item = mysqli_fetch_assoc($produk)): ?>
                        <div class="col-6">
                            <div class="nominal-card rounded p-3 text-center"
                                 onclick="pilihNominal('<?= $item['nominal'] ?>|<?= $item['harga'] ?>', this)">
                                <div class="fw-bold"><?= $item['nominal'] ?></div>
                                <div class="text-warning fw-bold">Rp <?= number_format($item['harga'], 0, ',', '.') ?></div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>

                <div class="alert alert-warning d-none" id="summary">
                    <strong>Ringkasan:</strong> <span id="summary-text"></span>
                </div>

                <button type="submit" class="btn btn-warning w-100 fw-bold py-2">
                    🟢 Pesan via WhatsApp
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function pilihNominal(value, el) {
    document.querySelectorAll('.nominal-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('nominal_harga').value = value;

    const [nominal, harga] = value.split('|');
    const formatted = new Intl.NumberFormat('id-ID').format(harga);
    document.getElementById('summary-text').textContent = nominal + ' — Rp ' + formatted;
    document.getElementById('summary').classList.remove('d-none');
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
