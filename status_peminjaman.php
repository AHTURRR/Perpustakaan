<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Peminjaman Perpustakaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 500px;
            margin: 0 auto;
        }
        h2 {
            text-align: center;
            color: #2c3e50;
        }
        .warning {
            color: #e74c3c;
            background-color: #fadbd8;
            padding: 10px;
            border-left: 4px solid #e74c3c;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table th, .info-table td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .status-danger {
            color: #e74c3c;
            font-weight: bold;
        }
        .status-success {
            color: #27ae60;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Sistem Peminjaman Buku</h2>

    <?php
    // 1. Variabel Awal
    $nama_anggota = "Budi Santoso";
    $total_pinjaman = 2; 
    $buku_terlambat = 1;
    $hari_keterlambatan = 5;
    $total_riwayat_pinjam = 12;

    // 2. Logika Bisnis: Cek Kelayakan Pinjam (IF-ELSEIF-ELSE)
    if ($total_pinjaman >= 3 || $buku_terlambat > 0) {
        $status_pinjam = "Tidak Boleh Pinjam";
        $kelas_status = "status-danger";
    } else {
        $status_pinjam = "Boleh Pinjam";
        $kelas_status = "status-success";
    }

    // 2. Logika Bisnis: Perhitungan Denda & Peringatan
    $total_denda = 0;
    $pesan_peringatan = "";

    if ($buku_terlambat > 0) {
        $hitung_denda = $buku_terlambat * $hari_keterlambatan * 1000;
        
        // Cek jika denda melebihi batas maksimal 50.000
        if ($hitung_denda > 50000) {
            $total_denda = 50000;
        } else {
            $total_denda = $hitung_denda;
        }
        
        $pesan_peringatan = "Peringatan: Anda memiliki buku yang terlambat dikembalikan. Harap segera melunasi denda Anda!";
    }

    // 3. Klasifikasi Member (SWITCH dengan kondisi range)
    // Menggunakan switch(true) untuk mengevaluasi kondisi boolean di dalam case
    switch (true) {
        case ($total_riwayat_pinjam >= 0 && $total_riwayat_pinjam <= 5):
            $level_member = "Bronze";
            break;
        case ($total_riwayat_pinjam >= 6 && $total_riwayat_pinjam <= 15):
            $level_member = "Silver";
            break;
        case ($total_riwayat_pinjam > 15):
            $level_member = "Gold";
            break;
        default:
            $level_member = "Tidak Diketahui";
            break;
    }

    // 4. Output Data
    // Menampilkan pesan peringatan jika ada
    if (!empty($pesan_peringatan)) {
        echo "<div class='warning'><strong>" . $pesan_peringatan . "</strong></div>";
    }
    ?>

    <table class="info-table">
        <tr>
            <th>Nama Anggota</th>
            <td><?php echo $nama_anggota; ?></td>
        </tr>
        <tr>
            <th>Level Member</th>
            <td><strong><?php echo $level_member; ?></strong> (<?php echo $total_riwayat_pinjam; ?> riwayat pinjam)</td>
        </tr>
        <tr>
            <th>Buku Sedang Dipinjam</th>
            <td><?php echo $total_pinjaman; ?> buku</td>
        </tr>
        <tr>
            <th>Status Peminjaman</th>
            <td class="<?php echo $kelas_status; ?>"><?php echo $status_pinjam; ?></td>
        </tr>
        <tr>
            <th>Total Denda</th>
            <td>Rp <?php echo number_format($total_denda, 0, ',', '.'); ?></td>
        </tr>
    </table>
</div>

</body>
</html>