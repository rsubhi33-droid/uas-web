<?php
session_start();
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit(); }
include '../config/database.php';

if (isset($_POST['update_status'])) {
    $id     = intval($_POST['id']);
    $status = htmlspecialchars($_POST['status']);
    mysqli_query($koneksi, "UPDATE transaksi SET status='$status' WHERE id=$id");
    header("Location: dashboard.php"); exit();
}

if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM transaksi WHERE id=$id");
    header("Location: dashboard.php"); exit();
}

$transaksi       = mysqli_query($koneksi, "SELECT * FROM transaksi ORDER BY tanggal DESC");
$total_produk    = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM produk_game"))['total'];
$total_transaksi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM transaksi"))['total'];
$total_pending   = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM transaksi WHERE status='Pending'"))['total'];
$total_sukses    = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM transaksi WHERE status='Sukses'"))['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — Ucii Store</title>
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
        .nav-admin-label {
            font-size: 11px;
            color: var(--muted);
            letter-spacing: 1px;
            margin-left: 4px;
        }
        .btn-nav-outline {
            font-size: 12px;
            padding: 6px 14px;
            border-radius: 6px;
            background: transparent;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-nav-store {
            border: 1px solid rgba(255,193,7,0.3);
            color: var(--gold);
        }
        .btn-nav-store:hover {
            background: rgba(255,193,7,0.1);
            color: var(--gold);
        }
        .btn-nav-logout {
            border: 1px solid rgba(220,53,69,0.3);
            color: #f87171;
        }
        .btn-nav-logout:hover {
            background: rgba(220,53,69,0.1);
            color: #f87171;
        }

        /* ── Page ── */
        .page-wrap { padding: 28px 1rem 60px; }

        /* ── Section head ── */
        .section-head {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
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

        /* ── Stat cards ── */
        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px 22px;
        }
        .stat-label {
            font-size: 11px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 8px;
        }
        .stat-num {
            font-family: 'Rajdhani', sans-serif;
            font-size: 32px;
            font-weight: 700;
            color: var(--gold);
            line-height: 1;
        }
        .stat-card.pending .stat-num { color: #fb923c; }
        .stat-card.sukses .stat-num  { color: #4ade80; }

        /* ── Table card ── */
        .table-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }
        .table-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            font-family: 'Rajdhani', sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: #fff;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .table-count {
            font-size: 11px;
            color: var(--muted);
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
        }
        .table-responsive { border-radius: 0; }
        table { margin: 0; }
        thead tr th {
            background: rgba(255,255,255,0.03) !important;
            border-bottom: 1px solid var(--border) !important;
            color: var(--muted) !important;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            padding: 12px 16px !important;
            white-space: nowrap;
        }
        tbody tr td {
            background: transparent !important;
            border-bottom: 1px solid rgba(255,255,255,0.04) !important;
            color: #ffffff !important;
            font-size: 13px;
            padding: 12px 16px !important;
            vertical-align: middle;
        }
        tbody tr td:nth-child(2),
        tbody tr td:nth-child(4) {
            color: #ffffff !important;
            opacity: 1 !important;
        }
        tbody tr:last-child td { border-bottom: none !important; }
        tbody tr:hover td { background: rgba(255,255,255,0.02) !important; }

        /* ── Status badge ── */
        .status-badge {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 4px 10px;
            border-radius: 20px;
            text-transform: uppercase;
        }
        .status-pending { background: rgba(251,146,60,0.15); color: #fb923c; border: 1px solid rgba(251,146,60,0.3); }
        .status-sukses  { background: rgba(74,222,128,0.12); color: #4ade80; border: 1px solid rgba(74,222,128,0.25); }
        .status-gagal   { background: rgba(248,113,113,0.12); color: #f87171; border: 1px solid rgba(248,113,113,0.25); }

        /* ── Action select & button ── */
        .status-select {
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 5px 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 12px;
            color: #e8e9ef;
            outline: none;
            cursor: pointer;
        }
        .status-select:focus { border-color: rgba(255,193,7,0.4); }
        .status-select option { background: #111527; }
        .btn-update {
            padding: 5px 10px;
            background: var(--gold);
            border: none;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            color: #0a0c14;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-update:hover { background: #e6b000; }
        .btn-hapus {
            padding: 5px 10px;
            background: transparent;
            border: 1px solid rgba(248,113,113,0.3);
            border-radius: 6px;
            font-size: 11px;
            color: #f87171;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-hapus:hover {
            background: rgba(248,113,113,0.1);
            color: #f87171;
        }
        .invoice-text {
            font-size: 11px;
            color: var(--muted);
            font-family: monospace;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container-fluid px-3">
        <a class="navbar-brand" href="dashboard.php">
            <div class="brand-dot"></div>
            UCII STORE
            <span class="nav-admin-label">/ Admin</span>
        </a>
        <div class="ms-auto d-flex gap-2">
            <a href="../index.php" class="btn-nav-outline btn-nav-store">
                <i class="fas fa-store" style="font-size:11px"></i> Lihat Toko
            </a>
            <a href="logout.php" class="btn-nav-outline btn-nav-logout">
                <i class="fas fa-sign-out-alt" style="font-size:11px"></i> Logout
            </a>
        </div>
    </div>
</nav>

<div class="container-fluid page-wrap">

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-label">Total Produk</div>
                <div class="stat-num"><?= $total_produk ?></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-label">Total Pesanan</div>
                <div class="stat-num"><?= $total_transaksi ?></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card pending">
                <div class="stat-label">Pending</div>
                <div class="stat-num"><?= $total_pending ?></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card sukses">
                <div class="stat-label">Sukses</div>
                <div class="stat-num"><?= $total_sukses ?></div>
            </div>
        </div>
    </div>

    <!-- Transaksi Table -->
    <div class="table-card">
        <div class="table-card-header">
            Daftar Transaksi
            <span class="table-count"><?= $total_transaksi ?> pesanan</span>
        </div>
        <div class="table-responsive">
            <table class="table table-borderless mb-0">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Game</th>
                        <th>User ID</th>
                        <th>Nominal</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($transaksi)): ?>
                <tr>
                    <td><span class="invoice-text"><?= htmlspecialchars($row['invoice']) ?></span></td>
                    <td><?= htmlspecialchars($row['nama_game']) ?></td>
                    <td>
                        <?= htmlspecialchars($row['user_id']) ?>
                        <?php if ($row['zone_id']): ?>
                            <span style="color:var(--muted);font-size:11px">(<?= htmlspecialchars($row['zone_id']) ?>)</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['nominal']) ?></td>
                    <td style="color:var(--gold);font-weight:500">
                        Rp <?= number_format($row['total_harga'], 0, ',', '.') ?>
                    </td>
                    <td style="font-size:12px;color:var(--muted)">
                        <?= date('d M Y H:i', strtotime($row['tanggal'])) ?>
                    </td>
                    <td>
                        <?php
                        $cls = 'status-pending';
                        if ($row['status'] === 'Sukses') $cls = 'status-sukses';
                        if ($row['status'] === 'Gagal')  $cls = 'status-gagal';
                        ?>
                        <span class="status-badge <?= $cls ?>"><?= $row['status'] ?></span>
                    </td>
                    <td>
                        <form method="POST" class="d-inline-flex align-items-center gap-1">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <select name="status" class="status-select">
                                <option <?= $row['status']==='Pending' ? 'selected' : '' ?>>Pending</option>
                                <option <?= $row['status']==='Sukses'  ? 'selected' : '' ?>>Sukses</option>
                                <option <?= $row['status']==='Gagal'   ? 'selected' : '' ?>>Gagal</option>
                            </select>
                            <button type="submit" name="update_status" class="btn-update">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        <a href="?hapus=<?= $row['id'] ?>" class="btn-hapus ms-1"
                           onclick="return confirm('Hapus transaksi ini?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>