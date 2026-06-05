<?php include 'config/database.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
<div class="container my-5" style="max-width: 520px;">
    <a href="index.php" class="btn btn-sm btn-secondary mb-3">← Kembali</a>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3"><i class="fas fa-search me-2"></i>Lacak Pesanan</h5>
            <form action="cek-invoice.php" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="invoice"
                           placeholder="Contoh: INV-A1B2C3D4"
                           value="<?= htmlspecialchars($_GET['invoice'] ?? '') ?>" required>
                    <button class="btn btn-warning fw-bold" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <?php if (isset($_GET['invoice'])): ?>
    <?php
        $inv = mysqli_real_escape_string($koneksi, $_GET['invoice']);
        $result = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE invoice = '$inv'");
        if (mysqli_num_rows($result) > 0):
            $d = mysqli_fetch_assoc($result);
            $badge = $d['status'] === 'Sukses' ? 'success' : ($d['status'] === 'Gagal' ? 'danger' : 'warning text-dark');
    ?>
    <div class="card border-0 shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0 text-muted">Status Pesanan</h6>
                <span class="badge bg-<?= $badge ?> fs-6"><?= $d['status'] ?></span>
            </div>
            <hr>
            <table class="table table-borderless mb-0">
                <tr><td class="text-muted">Invoice</td><td class="fw-bold"><?= $d['invoice'] ?></td></tr>
                <tr><td class="text-muted">Game</td><td><?= $d['nama_game'] ?></td></tr>
                <tr><td class="text-muted">Nominal</td><td><?= $d['nominal'] ?></td></tr>
                <tr><td class="text-muted">Total</td><td class="text-warning fw-bold">Rp <?= number_format($d['total_harga'], 0, ',', '.') ?></td></tr>
                <tr><td class="text-muted">Tanggal</td><td><?= $d['tanggal'] ?></td></tr>
            </table>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-danger text-center">Invoice tidak ditemukan.</div>
    <?php endif; ?>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
