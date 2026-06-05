<?php
session_start();
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit(); }
include '../config/database.php';

if (isset($_POST['update_status'])) {
    $id = intval($_POST['id']);
    $status = htmlspecialchars($_POST['status']);
    mysqli_query($koneksi, "UPDATE transaksi SET status='$status' WHERE id=$id");
    header("Location: dashboard.php"); exit();
}

if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM transaksi WHERE id=$id");
    header("Location: dashboard.php"); exit();
}

$transaksi      = mysqli_query($koneksi, "SELECT * FROM transaksi ORDER BY tanggal DESC");
$total_produk   = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM produk_game"))['total'];
$total_transaksi= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM transaksi"))['total'];
$total_pending  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM transaksi WHERE status='Pending'"))['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark px-4">
    <span class="navbar-brand fw-bold">⚙️ Admin Dashboard</span>
    <div>
        <a href="../index.php" class="btn btn-outline-warning btn-sm me-2">Lihat Toko</a>
        <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
</nav>

<div class="container my-4">
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card bg-dark text-white text-center p-3">
                <h2 class="fw-bold text-warning"><?= $total_produk ?></h2>
                <small>Total Produk</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark text-white text-center p-3">
                <h2 class="fw-bold text-warning"><?= $total_transaksi ?></h2>
                <small>Total Pesanan</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-dark text-center p-3">
                <h2 class="fw-bold"><?= $total_pending ?></h2>
                <small>Pesanan Pending</small>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white fw-bold">Daftar Transaksi</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Invoice</th><th>Game</th><th>User ID</th>
                            <th>Nominal</th><th>Total</th><th>Status</th><th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = mysqli_fetch_assoc($transaksi)): ?>
                    <tr>
                        <td><small><?= $row['invoice'] ?></small></td>
                        <td><?= $row['nama_game'] ?></td>
                        <td><?= $row['user_id'] ?><?= $row['zone_id'] ? " ({$row['zone_id']})" : '' ?></td>
                        <td><?= $row['nominal'] ?></td>
                        <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                        <td>
                            <?php
                            $b = $row['status']==='Sukses' ? 'success' : ($row['status']==='Gagal' ? 'danger' : 'warning text-dark');
                            echo "<span class='badge bg-{$b}'>{$row['status']}</span>";
                            ?>
                        </td>
                        <td>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <select name="status" class="form-select form-select-sm d-inline w-auto">
                                    <option>Pending</option>
                                    <option>Sukses</option>
                                    <option>Gagal</option>
                                </select>
                                <button name="update_status" class="btn btn-sm btn-warning">✓</button>
                            </form>
                            <a href="?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Hapus transaksi ini?')">✕</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
