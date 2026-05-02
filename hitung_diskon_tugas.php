<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perhitungan Diskon - Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Sistem Perhitungan Diskon Bertingkat</h1>
        
        <?php
        // Data input
        $nama_pembeli = "Budi Santoso";
        $judul_buku = "Laravel Advanced";
        $harga_satuan = 150000;
        $jumlah_beli = 4;
        $is_member = true; // true = member, false = non-member
        
        // Hitung subtotal
        $subtotal = $harga_satuan * $jumlah_beli;
        
        // Tentukan persentase diskon berdasarkan jumlah buku
        if ($jumlah_beli >= 1 && $jumlah_beli <= 2) {
            $persentase_diskon = 0;
        } elseif ($jumlah_beli >= 3 && $jumlah_beli <= 5) {
            $persentase_diskon = 10;
        } elseif ($jumlah_beli >= 6 && $jumlah_beli <= 10) {
            $persentase_diskon = 15;
        } else {
            $persentase_diskon = 20;
        }
        
        // Hitung diskon pertama
        $diskon = $subtotal * $persentase_diskon / 100;
        $total_setelah_diskon1 = $subtotal - $diskon;
        
        // Hitung diskon member (5% dari total setelah diskon pertama)
        $diskon_member = 0;
        if ($is_member) {
            $diskon_member = $total_setelah_diskon1 * 0.05;
        }
        
        // Total setelah semua diskon
        $total_setelah_diskon = $total_setelah_diskon1 - $diskon_member;
        
        // Hitung PPN 11%
        $ppn = $total_setelah_diskon * 0.11;
        
        // Total akhir yang harus dibayar
        $total_akhir = $total_setelah_diskon + $ppn;
        
        // Total penghematan (jumlah diskon + diskon member)
        $total_hemat = $diskon + $diskon_member;
        
        // Format Rupiah (tanpa desimal, titik sebagai pemisah ribuan)
        function format_rupiah($angka) {
            return "Rp " . number_format($angka, 0, ',', '.');
        }
        ?>
        
        <!-- Tampilkan hasil perhitungan dengan Bootstrap -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Struk Pembelian</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Nama Pembeli:</strong> <?= htmlspecialchars($nama_pembeli) ?></p>
                        <p><strong>Judul Buku:</strong> <?= htmlspecialchars($judul_buku) ?></p>
                        <p><strong>Harga Satuan:</strong> <?= format_rupiah($harga_satuan) ?></p>
                        <p><strong>Jumlah Buku:</strong> <?= $jumlah_beli ?> buku</p>
                        <p><strong>Status Member:</strong> 
                            <span class="badge <?= $is_member ? 'bg-success' : 'bg-secondary' ?>">
                                <?= $is_member ? 'Member' : 'Non-Member' ?>
                            </span>
                        </p>
                    </div>
                </div>
                
                <hr>
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 50%">Subtotal</th>
                            <td class="text-end"><?= format_rupiah($subtotal) ?></td>
                        </tr>
                        <tr>
                            <th>Diskon (<?= $persentase_diskon ?>%)</th>
                            <td class="text-end text-danger">- <?= format_rupiah($diskon) ?></td>
                        </tr>
                        <?php if ($is_member): ?>
                        <tr>
                            <th>Diskon Member (5%)</th>
                            <td class="text-end text-danger">- <?= format_rupiah($diskon_member) ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr class="table-active">
                            <th>Total setelah diskon</th>
                            <td class="text-end"><?= format_rupiah($total_setelah_diskon) ?></td>
                        </tr>
                        <tr>
                            <th>PPN 11%</th>
                            <td class="text-end">+ <?= format_rupiah($ppn) ?></td>
                        </tr>
                        <tr class="table-primary">
                            <th>Total Akhir</th>
                            <td class="text-end fw-bold"><?= format_rupiah($total_akhir) ?></td>
                        </tr>
                        <tr>
                            <th>Total Penghematan</th>
                            <td class="text-end text-success fw-bold"><?= format_rupiah($total_hemat) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>