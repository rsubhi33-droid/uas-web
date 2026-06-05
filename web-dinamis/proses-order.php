<?php
include 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php"); exit();
}

$nama_game     = htmlspecialchars($_POST['nama_game']);
$user_id       = htmlspecialchars($_POST['user_id']);
$zone_id       = htmlspecialchars($_POST['zone_id'] ?? '');
$nominal_harga = explode('|', $_POST['nominal_harga']);
$nominal       = htmlspecialchars($nominal_harga[0]);
$total_harga   = intval($nominal_harga[1]);

$invoice = "INV-" . strtoupper(substr(md5(uniqid()), 0, 8));

$stmt = mysqli_prepare($koneksi,
    "INSERT INTO transaksi (invoice, user_id, zone_id, nama_game, nominal, total_harga, status)
     VALUES (?, ?, ?, ?, ?, ?, 'Pending')"
);
mysqli_stmt_bind_param($stmt, "sssssi", $invoice, $user_id, $zone_id, $nama_game, $nominal, $total_harga);

if (mysqli_stmt_execute($stmt)) {
    // GANTI dengan nomor WhatsApp kamu (kode negara 62, tanpa +)
    $no_wa = "6281234567890";
    $harga_format = "Rp " . number_format($total_harga, 0, ',', '.');
    $pesan = "Halo Admin, saya mau bayar pesanan top-up.\n\n"
           . "📋 *Invoice:* {$invoice}\n"
           . "🎮 *Game:* {$nama_game}\n"
           . "🆔 *User ID:* {$user_id}" . ($zone_id ? " | Zone: {$zone_id}" : "") . "\n"
           . "💎 *Nominal:* {$nominal}\n"
           . "💵 *Total:* {$harga_format}\n\n"
           . "Mohon info rekening/QRIS-nya min, terima kasih!";

    $url = "https://api.whatsapp.com/send?phone={$no_wa}&text=" . urlencode($pesan);
    header("Location: " . $url);
    exit();
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>
