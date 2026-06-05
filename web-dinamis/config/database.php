<?php
$host     = getenv('DB_HOST') ?: 'db';
$user     = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD') ?: 'rahasia_db_uas';
$database = getenv('DB_NAME') ?: 'uas_topup';

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die(json_encode(['error' => 'Koneksi database gagal: ' . mysqli_connect_error()]));
}
mysqli_set_charset($koneksi, 'utf8');
?>
