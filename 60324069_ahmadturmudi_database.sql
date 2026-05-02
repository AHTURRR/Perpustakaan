-- Nama Database: perpustakaan_digital
-- Deskripsi: Tugas Perancangan Database Lengkap (Pertemuan 6)

CREATE DATABASE IF NOT EXISTS perpustakaan;
USE perpustakaan;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS transaksi, buku, kategori_buku, penerbit, rak, anggota;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. Tabel Kategori
CREATE TABLE kategori_buku (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL UNIQUE,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Tabel Penerbit
CREATE TABLE penerbit (
    id_penerbit INT AUTO_INCREMENT PRIMARY KEY,
    nama_penerbit VARCHAR(100) NOT NULL,
    alamat TEXT,
    telepon VARCHAR(15),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Tabel Rak
CREATE TABLE rak (
    id_rak INT AUTO_INCREMENT PRIMARY KEY,
    nama_rak VARCHAR(50) NOT NULL,
    lokasi VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Tabel Anggota
CREATE TABLE anggota (
    id_anggota INT AUTO_INCREMENT PRIMARY KEY,
    kode_anggota VARCHAR(20) UNIQUE,
    nama VARCHAR(100),
    email VARCHAR(100),
    telepon VARCHAR(15),
    alamat TEXT,
    status ENUM('Aktif', 'Nonaktif') DEFAULT 'Aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. Tabel Buku
CREATE TABLE buku (
    id_buku INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    pengarang VARCHAR(100),
    id_kategori INT,
    id_penerbit INT,
    id_rak INT,
    harga DECIMAL(10, 2),
    stok INT DEFAULT 0,
    tahun_terbit YEAR,
    is_deleted TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_buku_kategori FOREIGN KEY (id_kategori) REFERENCES kategori_buku(id_kategori),
    CONSTRAINT fk_buku_penerbit FOREIGN KEY (id_penerbit) REFERENCES penerbit(id_penerbit),
    CONSTRAINT fk_buku_rak FOREIGN KEY (id_rak) REFERENCES rak(id_rak)
);

-- 6. Tabel Transaksi
CREATE TABLE transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    id_buku INT,
    id_anggota INT,
    tanggal_pinjam DATE,
    tanggal_kembali DATE,
    status ENUM('Dipinjam', 'Dikembalikan', 'Terlambat'),
    CONSTRAINT fk_trans_buku FOREIGN KEY (id_buku) REFERENCES buku(id_buku),
    CONSTRAINT fk_trans_anggota FOREIGN KEY (id_anggota) REFERENCES anggota(id_anggota)
);

-- INSERT DATA SAMPLE (Disederhanakan)
INSERT INTO kategori_buku (nama_kategori) VALUES ('Programming'), ('Networking'), ('Design');
INSERT INTO penerbit (nama_penerbit) VALUES ('Elex Media'), ('Informatika'), ('Andi Offset');
INSERT INTO rak (nama_rak, lokasi) VALUES ('Rak-01', 'Lantai 1'), ('Rak-02', 'Lantai 2');
INSERT INTO anggota (kode_anggota, nama) VALUES ('A001', 'Budi Santoso'), ('A002', 'Siti Aminah');
INSERT INTO buku (judul, pengarang, id_kategori, id_penerbit, id_rak, harga, stok, tahun_terbit) 
VALUES ('Laravel Expert', 'Budi Raharjo', 1, 2, 1, 150000, 10, 2023);

-- QUERY JOIN LAPORAN
SELECT b.judul, k.nama_kategori, p.nama_penerbit FROM buku b 
JOIN kategori_buku k ON b.id_kategori = k.id_kategori 
JOIN penerbit p ON b.id_penerbit = p.id_penerbit;