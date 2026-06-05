CREATE TABLE IF NOT EXISTS produk_game (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_game VARCHAR(100) NOT NULL,
    nominal VARCHAR(50) NOT NULL,
    harga INT NOT NULL
);

CREATE TABLE IF NOT EXISTS transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice VARCHAR(50) NOT NULL,
    user_id VARCHAR(50) NOT NULL,
    zone_id VARCHAR(50) NULL,
    nama_game VARCHAR(100) NOT NULL,
    nominal VARCHAR(50) NOT NULL,
    total_harga INT NOT NULL,
    status VARCHAR(20) DEFAULT 'Pending',
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Seed produk awal
INSERT INTO produk_game (nama_game, nominal, harga) VALUES
('Mobile Legends', '86 Diamonds', 20000),
('Mobile Legends', '172 Diamonds', 39000),
('Mobile Legends', '257 Diamonds', 58000),
('Mobile Legends', '514 Diamonds', 115000),
('Free Fire', '70 Diamonds', 18000),
('Free Fire', '140 Diamonds', 35000),
('Free Fire', '355 Diamonds', 88000),
('Genshin Impact', '60 Primogems', 15000),
('Genshin Impact', '300 Primogems', 75000);

-- Seed akun admin (password: admin123)
INSERT INTO admin (username, password) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
