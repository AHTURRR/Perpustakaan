<?php
// ==========================================
// Data Anggota Perpustakaan (Array Multidimensi)
// ==========================================
$anggota_list = [
    [
        "id" => "AGT-001",
        "nama" => "Budi Santoso",
        "email" => "budi.santoso@mail.com",
        "telepon" => "08123456789",
        "alamat" => "Jl. Merdeka No. 1, Jakarta",
        "tanggal_daftar" => "2023-01-15",
        "status" => "Aktif",
        "total_pinjaman" => 10
    ],
    [
        "id" => "AGT-002",
        "nama" => "Siti Aminah",
        "email" => "siti.aminah@mail.com",
        "telepon" => "08129876543",
        "alamat" => "Jl. Sudirman No. 2, Bandung",
        "tanggal_daftar" => "2023-02-20",
        "status" => "Aktif",
        "total_pinjaman" => 25
    ],
    [
        "id" => "AGT-003",
        "nama" => "Agus Salim",
        "email" => "agus.salim@mail.com",
        "telepon" => "08125551234",
        "alamat" => "Jl. Thamrin No. 3, Surabaya",
        "tanggal_daftar" => "2023-03-10",
        "status" => "Non-Aktif",
        "total_pinjaman" => 5
    ],
    [
        "id" => "AGT-004",
        "nama" => "Dewi Kartika",
        "email" => "dewi.kartika@mail.com",
        "telepon" => "08137778888",
        "alamat" => "Jl. Diponegoro No. 4, Yogyakarta",
        "tanggal_daftar" => "2023-04-05",
        "status" => "Aktif",
        "total_pinjaman" => 30
    ],
    [
        "id" => "AGT-005",
        "nama" => "Eko Prasetyo",
        "email" => "eko.prasetyo@mail.com",
        "telepon" => "08134445555",
        "alamat" => "Jl. Hasanuddin No. 5, Semarang",
        "tanggal_daftar" => "2023-05-12",
        "status" => "Non-Aktif",
        "total_pinjaman" => 2
    ]
];

// ==========================================
// Hitung Statistik (berdasarkan seluruh data)
// ==========================================
$total_anggota = count($anggota_list);
$total_aktif = 0;
$total_nonaktif = 0;
$total_pinjaman_semua = 0;
$max_pinjaman = -1;
$anggota_teraktif = "";

foreach ($anggota_list as $anggota) {
    // Hitung status
    if ($anggota['status'] == "Aktif") {
        $total_aktif++;
    } else {
        $total_nonaktif++;
    }
    
    // Akumulasi total pinjaman
    $total_pinjaman_semua += $anggota['total_pinjaman'];
    
    // Cari anggota dengan total pinjaman tertinggi
    if ($anggota['total_pinjaman'] > $max_pinjaman) {
        $max_pinjaman = $anggota['total_pinjaman'];
        $anggota_teraktif = $anggota['nama'];
    }
}

$persen_aktif = ($total_anggota > 0) ? ($total_aktif / $total_anggota) * 100 : 0;
$persen_nonaktif = ($total_anggota > 0) ? ($total_nonaktif / $total_anggota) * 100 : 0;
$rata_pinjaman = ($total_anggota > 0) ? $total_pinjaman_semua / $total_anggota : 0;

// Format persentase dan rata-rata
$persen_aktif_formatted = number_format($persen_aktif, 1);
$persen_nonaktif_formatted = number_format($persen_nonaktif, 1);
$rata_pinjaman_formatted = number_format($rata_pinjaman, 2);

// ==========================================
// Filter Berdasarkan Status (GET)
// ==========================================
$status_filter = isset($_GET['status']) ? $_GET['status'] : 'Semua';
$filtered_anggota = [];

if ($status_filter == 'Semua') {
    $filtered_anggota = $anggota_list;
} else {
    foreach ($anggota_list as $anggota) {
        if ($anggota['status'] == $status_filter) {
            $filtered_anggota[] = $anggota;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Anggota Perpustakaan</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .badge-aktif {
            background-color: #198754;
        }
        .badge-nonaktif {
            background-color: #6c757d;
        }
        .card-stats {
            transition: transform 0.2s;
        }
        .card-stats:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-4">
    <h1 class="text-center mb-4">📚 Manajemen Anggota Perpustakaan</h1>
    
    <!-- ========================================== -->
    <!-- Cards Statistik (Grid System Bootstrap)    -->
    <!-- ========================================== -->
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-lg-3">
            <div class="card card-stats h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">Total Anggota</h5>
                    <p class="display-4 fw-bold text-primary"><?php echo $total_anggota; ?></p>
                    <span class="text-muted">keseluruhan</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card card-stats h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">Anggota Aktif</h5>
                    <p class="display-4 fw-bold text-success"><?php echo $persen_aktif_formatted; ?>%</p>
                    <span class="text-muted">(<?php echo $total_aktif; ?> orang)</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card card-stats h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">Anggota Non-Aktif</h5>
                    <p class="display-4 fw-bold text-secondary"><?php echo $persen_nonaktif_formatted; ?>%</p>
                    <span class="text-muted">(<?php echo $total_nonaktif; ?> orang)</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card card-stats h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">Rata-rata Pinjaman</h5>
                    <p class="display-4 fw-bold text-info"><?php echo $rata_pinjaman_formatted; ?></p>
                    <span class="text-muted">buku per anggota</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card khusus untuk Anggota Teraktif (full width) -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm border-0 bg-warning bg-opacity-10">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">🏆 Anggota Teraktif</h5>
                        <p class="card-text fs-5 fw-semibold"><?php echo htmlspecialchars($anggota_teraktif); ?></p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-warning text-dark fs-6">Total Pinjaman: <?php echo $max_pinjaman; ?> buku</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ========================================== -->
    <!-- Form Filter Status (Metode GET)            -->
    <!-- ========================================== -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="status" class="form-label fw-bold">Filter Berdasarkan Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="Semua" <?php echo ($status_filter == 'Semua') ? 'selected' : ''; ?>>Semua Status</option>
                        <option value="Aktif" <?php echo ($status_filter == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                        <option value="Non-Aktif" <?php echo ($status_filter == 'Non-Aktif') ? 'selected' : ''; ?>>Non-Aktif</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="?status=Semua" class="btn btn-outline-secondary">Reset Filter</a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- ========================================== -->
    <!-- Tabel Daftar Anggota (Hasil Filter)        -->
    <!-- ========================================== -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">📋 Daftar Anggota 
                <?php if ($status_filter != 'Semua'): ?>
                    <span class="badge bg-secondary ms-2">Status: <?php echo $status_filter; ?></span>
                <?php endif; ?>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Tanggal Daftar</th>
                            <th>Status</th>
                            <th>Total Pinjaman</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($filtered_anggota) > 0): ?>
                            <?php foreach ($filtered_anggota as $anggota): ?>
                                <tr>
                                    <td class="fw-semibold"><?php echo htmlspecialchars($anggota['id']); ?></td>
                                    <td><?php echo htmlspecialchars($anggota['nama']); ?></td>
                                    <td><?php echo htmlspecialchars($anggota['email']); ?></td>
                                    <td><?php echo htmlspecialchars($anggota['telepon']); ?></td>
                                    <td><?php echo htmlspecialchars($anggota['alamat']); ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($anggota['tanggal_daftar'])); ?></td>
                                    <td>
                                        <?php if ($anggota['status'] == 'Aktif'): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Non-Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center"><?php echo number_format($anggota['total_pinjaman'], 0); ?> buku</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    Tidak ada anggota dengan status "<?php echo htmlspecialchars($status_filter); ?>".
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white text-muted">
            <small>Menampilkan <?php echo count($filtered_anggota); ?> dari <?php echo $total_anggota; ?> anggota</small>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle (optional, untuk interaktivitas) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>