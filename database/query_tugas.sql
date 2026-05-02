-- =====================================================
-- TUGAS MANIPULASI DATA (DML) - PERPUSTAKAAN
-- Nama file: query_tugas.sql
-- Deskripsi: Berisi query agregasi, filter, grouping, 
--            dan update data dengan kenaikan harga 5%
-- =====================================================

-- Asumsi struktur tabel:
-- 1. tabel `buku` 
--    kolom: id_buku (INT), judul_buku (VARCHAR), id_kategori (INT),
--           harga (DECIMAL), stok (INT)
-- 2. tabel `kategori_buku`
--    kolom: id_kategori (INT), nama_kategori (VARCHAR)

-- =====================================================
-- 1. FUNGSI AGREGASI
-- =====================================================

-- 1a. Menghitung total buku (jumlah baris di tabel buku)
-- Menampilkan jumlah seluruh buku yang ada di perpustakaan
SELECT 
    COUNT(*) AS total_buku 
FROM buku;

-- 1b. Total nilai inventaris = jumlah dari (harga * stok)
-- Rumus: menjumlahkan seluruh perkalian harga dan stok per buku
SELECT 
    SUM(harga * stok) AS total_nilai_inventaris 
FROM buku;

-- 1c. Rata-rata harga buku (tanpa memperhitungkan stok)
-- Menghitung nilai rata-rata dari kolom harga
SELECT 
    AVG(harga) AS rata_rata_harga 
FROM buku;

-- 1d. Buku termahal (nilai harga tertinggi)
-- Mencari harga maksimum, lalu bisa ditampilkan detail bukunya
SELECT 
    MAX(harga) AS harga_tertinggi 
FROM buku;

-- Alternatif: menampilkan judul buku dan harganya untuk buku termahal
-- (opsional, jika ingin lebih informatif)
SELECT 
    judul_buku, 
    harga 
FROM buku 
WHERE harga = (SELECT MAX(harga) FROM buku);

-- 1e. Stok terbanyak (nilai stok terbesar)
SELECT 
    MAX(stok) AS stok_terbanyak 
FROM buku;

-- Alternatif: menampilkan buku dengan stok tertinggi
SELECT 
    judul_buku, 
    stok 
FROM buku 
WHERE stok = (SELECT MAX(stok) FROM buku);

-- =====================================================
-- 2. FILTER & PENCARIAN (WHERE, LIKE, BETWEEN)
-- =====================================================

-- 2a. Mencari buku yang judulnya mengandung kata "pemrograman"
-- Menggunakan operator LIKE dengan wildcard % di awal dan akhir
SELECT 
    judul_buku, 
    harga, 
    stok 
FROM buku 
WHERE judul_buku LIKE '%pemrograman%';

-- 2b. Mencari buku yang memiliki stok antara 5 dan 10 (inklusif)
-- Menggunakan BETWEEN untuk rentang stok
SELECT 
    judul_buku, 
    stok 
FROM buku 
WHERE stok BETWEEN 5 AND 10;

-- Atau bisa juga dengan operator >= dan <=
-- WHERE stok >= 5 AND stok <= 10;

-- 2c. Filter buku dengan harga di atas Rp 100.000 dan stok kurang dari 3
-- Kombinasi beberapa kondisi dengan AND
SELECT 
    judul_buku, 
    harga, 
    stok 
FROM buku 
WHERE harga > 100000 AND stok < 3;

-- =====================================================
-- 3. GROUPING (GROUP BY) - Statistik per kategori
-- =====================================================

-- Menampilkan per kategori: jumlah buku, rata-rata harga, total stok
-- Melibatkan JOIN dengan tabel kategori_buku
SELECT 
    k.nama_kategori,
    COUNT(b.id_buku) AS jumlah_buku,
    AVG(b.harga) AS rata_rata_harga_per_kategori,
    SUM(b.stok) AS total_stok_per_kategori
FROM kategori_buku k
LEFT JOIN buku b ON k.id_kategori = b.id_kategori
GROUP BY k.id_kategori, k.nama_kategori
ORDER BY jumlah_buku DESC;

-- =====================================================
-- 4. UPDATE DATA - Kenaikan harga sebesar 5%
-- =====================================================

/*
   PENJELASAN RUMUS KENAIKAN HARGA 5% DALAM SQL:
   
   Untuk menaikkan harga sebesar 5%, kita melakukan operasi:
   harga_baru = harga_lama + (5/100) * harga_lama
   atau sederhananya: harga_baru = harga_lama * 1.05
   
   Dalam SQL, perintah UPDATE dengan kalkulasi matematik:
   UPDATE nama_tabel SET kolom_harga = kolom_harga * 1.05 WHERE kondisi;
   
   Angka 1.05 berasal dari 1 + (5/100) = 1 + 0.05 = 1.05.
   Jika ingin kenaikan 10%, kalikan dengan 1.10, dan seterusnya.
*/

-- 4a. Menaikkan harga semua buku sebesar 5%
-- Perintah ini akan mengubah data permanen. Hati-hati!
-- Disarankan untuk melakukan backup atau menggunakan BEGIN/ROLLBACK jika perlu.

-- Untuk keamanan, bisa dimulai dengan transaksi (jika engine mendukung):
START TRANSACTION;

-- Lakukan update:
UPDATE buku 
SET harga = harga * 1.05;

-- Jika ingin melihat perubahan sebelum commit:
-- SELECT judul_buku, harga FROM buku;

-- Jika yakin, commit:
-- COMMIT;

-- Jika tidak jadi, rollback:
-- ROLLBACK;

-- 4b. (Opsional) Menaikkan harga hanya untuk kategori tertentu, misal "Fiksi"
-- Contoh update bersyarat:
-- UPDATE buku 
-- SET harga = harga * 1.05
-- WHERE id_kategori = (SELECT id_kategori FROM kategori_buku WHERE nama_kategori = 'Fiksi');

-- 4c. Untuk demonstrasi tanpa mengubah data, bisa disimulasikan dengan SELECT
-- Tampilkan harga lama dan harga setelah kenaikan 5% (namun hanya sebagai tampilan)
SELECT 
    judul_buku,
    harga AS harga_sekarang,
    ROUND(harga * 1.05, 2) AS harga_setelah_naik_5_persen
FROM buku
LIMIT 10;

-- =====================================================
-- AKHIR DARI FILE query_tugas.sql
-- =====================================================