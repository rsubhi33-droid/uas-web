# Web Dinamis - Top Up Game Store

Project UAS - PHP + MariaDB + Docker + GitHub Actions CI/CD

## Stack
- PHP 8.1 + Apache
- MariaDB 10.6
- Docker & Docker Compose
- GitHub Actions (CI/CD ke AWS EC2)

## Fitur
- Halaman utama dinamis (baca game dari DB)
- Form order Top Up
- Redirect ke WhatsApp setelah order
- Cek status invoice
- Panel Admin (login, lihat/update/hapus transaksi)

## Cara Jalankan Lokal

1. Buat file `.env` dari template:
   ```
   cp .env.example .env
   ```

2. Jalankan dengan Docker Compose:
   ```
   docker-compose up -d
   ```

3. Akses di browser: `http://localhost:3000`
4. Admin panel: `http://localhost:3000/admin/login.php`
   - Username: `admin`
   - Password: `admin123`

## Hal yang Perlu Diganti Sebelum Deploy
- Nomor WhatsApp di `proses-order.php` (cari `6281234567890`)

## GitHub Secrets yang Diperlukan
| Secret | Keterangan |
|--------|-----------|
| DOCKERHUB_USERNAME | Username Docker Hub |
| DOCKERHUB_TOKEN | Token Docker Hub |
| AWS_HOST | IP EC2 |
| AWS_USERNAME | Username EC2 (biasanya ubuntu) |
| AWS_PRIVATE_KEY | Private key SSH (.pem) |
| DB_PASSWORD | Password database MariaDB |

## Catatan Workflow
File `.github/workflows/deploy-dinamis.yml` di dalam zip ini perlu dipindahkan
ke ROOT repository monorepo kamu (bukan di dalam folder web-dinamis/).
