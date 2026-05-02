<?php
// Include file functions
require_once 'functions_anggota.php';

// ==========================================
// Data Anggota (minimal 5 data)
// ==========================================
$anggota_list = [
    [
        'id' => 'AGT-001',
        'nama' => 'Budi Santoso',
        'email' => 'budi@mail.com',
        'telepon' => '08123456789',
        'alamat' => 'Jl. Merdeka No. 1, Jakarta',
        'tanggal_daftar' => '2023-01-15',
        'status' => 'Aktif',
        'total_pinjaman' => 10
    ],
    [
        'id' => 'AGT-002',
        'nama' => 'Siti Aminah',
        'email' => 'siti@mail.com',
        'telepon' => '08129876543',
        'alamat' => 'Jl. Sudirman No. 2, Bandung',
        'tanggal_daftar' => '2023-02-20',
        'status' => 'Aktif',
        'total_pinjaman' => 25
    ],
    [
        'id' => 'AGT-003',
        'nama' => 'Agus Salim',
        'email' => 'agus@mail.com',
        'telepon' => '08125551234',
        'alamat' => 'Jl. Thamrin No. 3, Surabaya',
        'tanggal_daftar' => '2023-03-10',
        'status' => 'Non-Aktif',
        'total_pinjaman' => 5
    ],
    [
        'id' => 'AGT-004',
        'nama' => 'Dewi Kartika',
        'email' => 'dewi@mail.com',
        'telepon' => '08137778888',
        'alamat' => 'Jl. Diponegoro No. 4, Yogyakarta',
        'tanggal_daftar' => '2023-04-05',
        'status' => 'Aktif',
        'total_pinjaman' => 30
    ],
    [
        'id' => 'AGT-005',
        'nama' => 'Eko Prasetyo',
        'email' => 'eko@mail.com',
        'telepon' => '08134445555',
        'alamat' => 'Jl. Hasanuddin No. 5, Semarang',
        'tanggal_daftar' => '2023-05-12',
        'status' => 'Non-Aktif',
        'total_pinjaman' => 2
    ],
    [
        'id' => 'AGT-006',
        'nama' => 'Rina Wulandari',
        'email' => 'rina@mail.com',
        'telepon' => '08136667777',
        'alamat' => 'Jl. Pahlawan No. 6, Malang',
        'tanggal_daftar' => '2023-06-18',
        'status' => 'Aktif',
        'total_pinjaman' => 18
    ]
];

// ==========================================
// Proses Pencarian & Pengurutan (via $_GET)
// ==========================================
$keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
$sort_order = isset($_GET['sort']) ? $_GET['sort'] : 'asc'; // asc atau desc, default asc

// Terapkan pencarian
$filtered_data = search_by_nama($anggota_list, $keyword);

// Terapkan pengurutan berdasarkan nama
$filtered_data = sort_by_nama($filtered_data, $sort_order);

// Statistik dari data asli (seluruh anggota)
$total_anggota = hitung_total_anggota($anggota_list);
$total_aktif = hitung_anggota_aktif($anggota_list);
$total_nonaktif = hitung_anggota_nonaktif($anggota_list);
$rata_pinjaman = hitung_rata_rata_pinjaman($anggota_list);

// Anggota teraktif (dari seluruh data)
$teraktif = cari_anggota_teraktif($anggota_list);

// Untuk daftar terpisah (aktif vs non-aktif) berdasarkan hasil pencarian (tanpa sorting)
$data_for_lists = search_by_nama($anggota_list, $keyword);
$aktif_list = filter_by_status($data_for_lists, 'Aktif');
$nonaktif_list = filter_by_status($data_for_lists, 'Non-Aktif');
// Urutkan masing-masing berdasarkan nama agar rapi
$aktif_list = sort_by_nama($aktif_list, 'asc');
$nonaktif_list = sort_by_nama($nonaktif_list, 'asc');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1 class="mb-4"><i class="bi bi-people"></i> Sistem Anggota Perpustakaan</h1>
    
    <!-- Dashboard Statistik (3 Cards) -->
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="card text-white bg-primary h-100 shadow">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-person-badge"></i> Total Anggota</h5>
                    <p class="display-4 fw-bold"><?php echo $total_anggota; ?></p>
                    <p class="card-text">seluruh anggota terdaftar</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success h-100 shadow">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-check-circle"></i> Anggota Aktif</h5>
                    <p class="display-4 fw-bold"><?php echo $total_aktif; ?></p>
                    <p class="card-text">dari total <?php echo $total_anggota; ?> anggota</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-secondary h-100 shadow">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-x-circle"></i> Anggota Non-Aktif</h5>
                    <p class="display-4 fw-bold"><?php echo $total_nonaktif; ?></p>
                    <p class="card-text">dari total <?php echo $total_anggota; ?> anggota</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Form Pencarian & Sortir -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="search" class="form-label fw-bold"><i class="bi bi-search"></i> Cari Nama</label>
                    <input type="text" name="search" id="search" class="form-control" 
                           placeholder="Ketik nama anggota..." value="<?php echo htmlspecialchars($keyword); ?>">
                </div>
                <div class="col-md-3">
                    <label for="sort" class="form-label fw-bold"><i class="bi bi-arrow-up-down"></i> Urutkan Nama</label>
                    <select name="sort" id="sort" class="form-select">
                        <option value="asc" <?php echo $sort_order == 'asc' ? 'selected' : ''; ?>>A-Z (Ascending)</option>
                        <option value="desc" <?php echo $sort_order == 'desc' ? 'selected' : ''; ?>>Z-A (Descending)</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Terapkan</button>
                </div>
                <div class="col-md-2">
                    <a href="?" class="btn btn-outline-secondary w-100"><i class="bi bi-arrow-repeat"></i> Reset</a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Tabel Anggota (Hasil Pencarian & Sortir) -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-table"></i> Daftar Anggota</h5>
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
                        <?php if (count($filtered_data) > 0): ?>
                            <?php foreach ($filtered_data as $anggota): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($anggota['id']); ?></td>
                                    <td><?php echo htmlspecialchars($anggota['nama']); ?></td>
                                    <td><?php echo htmlspecialchars($anggota['email']); ?></td>
                                    <td><?php echo htmlspecialchars($anggota['telepon']); ?></td>
                                    <td><?php echo htmlspecialchars($anggota['alamat']); ?></td>
                                    <td><?php echo format_tanggal_indo($anggota['tanggal_daftar']); ?></td>
                                    <td>
                                        <?php if ($anggota['status'] == 'Aktif'): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Non-Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center"><?php echo $anggota['total_pinjaman']; ?> buku</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="bi bi-info-circle"></i> Tidak ada anggota yang cocok dengan pencarian "<?php echo htmlspecialchars($keyword); ?>"
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white text-muted">
            <small>Menampilkan <?php echo count($filtered_data); ?> dari <?php echo $total_anggota; ?> anggota</small>
        </div>
    </div>
    
    <!-- Daftar Terpisah: Aktif vs Non-Aktif (Accordion / Dua List) -->
    <div class="row mb-4 g-3">
        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-person-check"></i> Anggota Aktif</h5>
                </div>
                <div class="card-body">
                    <?php if (count($aktif_list) > 0): ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($aktif_list as $a): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo htmlspecialchars($a['nama']); ?>
                                    <span class="badge bg-primary rounded-pill"><?php echo $a['total_pinjaman']; ?> pinjaman</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">Tidak ada anggota aktif dengan kata kunci "<?php echo htmlspecialchars($keyword); ?>"</p>
                    <?php endif; ?>
                </div>
                <div class="card-footer bg-white">
                    <small>Total: <?php echo count($aktif_list); ?> anggota</small>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-secondary">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="bi bi-person-x"></i> Anggota Non-Aktif</h5>
                </div>
                <div class="card-body">
                    <?php if (count($nonaktif_list) > 0): ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($nonaktif_list as $a): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo htmlspecialchars($a['nama']); ?>
                                    <span class="badge bg-secondary rounded-pill"><?php echo $a['total_pinjaman']; ?> pinjaman</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">Tidak ada anggota non-aktif dengan kata kunci "<?php echo htmlspecialchars($keyword); ?>"</p>
                    <?php endif; ?>
                </div>
                <div class="card-footer bg-white">
                    <small>Total: <?php echo count($nonaktif_list); ?> anggota</small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Anggota Teraktif (Card Hijau) -->
    <?php if ($teraktif): ?>
        <div class="card shadow-sm bg-success text-white mb-5">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title"><i class="bi bi-trophy-fill"></i> Anggota Teraktif</h5>
                        <p class="card-text fs-4 fw-bold"><?php echo htmlspecialchars($teraktif['nama']); ?></p>
                        <p class="card-text mb-0">Total pinjaman: <strong><?php echo $teraktif['total_pinjaman']; ?> buku</strong></p>
                    </div>
                    <div>
                        <span class="badge bg-light text-dark fs-6">ID: <?php echo $teraktif['id']; ?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>