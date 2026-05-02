<?php
// Statistik Dashboard dengan error handling
$total_buku = 0;
$buku_tersedia = 0;
$buku_habis = 0;
$total_anggota = 0;

if ($conn) {
    $result = $conn->query("SELECT COUNT(*) as total FROM buku");
    if ($result) {
        $row = $result->fetch_assoc();
        $total_buku = $row ? $row['total'] : 0;
    }

    $result = $conn->query("SELECT COUNT(*) as total FROM buku WHERE stok > 0");
    if ($result) {
        $row = $result->fetch_assoc();
        $buku_tersedia = $row ? $row['total'] : 0;
    }

    $result = $conn->query("SELECT COUNT(*) as total FROM buku WHERE stok = 0");
    if ($result) {
        $row = $result->fetch_assoc();
        $buku_habis = $row ? $row['total'] : 0;
    }

    $result = $conn->query("SELECT COUNT(*) as total FROM anggota");
    if ($result) {
        $row = $result->fetch_assoc();
        $total_anggota = $row ? $row['total'] : 0;
    }
}
?>

<?php
// Tentukan base path konsisten
$script_name = isset($_SERVER['SCRIPT_NAME']) ? str_replace('\\', '/', $_SERVER['SCRIPT_NAME']) : '';
$script_dir = dirname($script_name);
$base_path = '';
if (strpos($script_dir, '/perpustakaan') !== false) {
    $base_path = '/perpustakaan';
}
?>

<div class="container-fluid py-4">
	<div class="dashboard-header">
		<div class="row align-items-center">
			<div class="col-md-8">
				<h1><i class="bi bi-house-door"></i> Dashboard Perpustakaan</h1>
			</div>
			<div class="col-md-4 text-end">
				<p class="text-white mb-0" style="font-size: 1.1rem; opacity: 0.9;">
					<i class="bi bi-calendar"></i> <?php echo strftime('%A, %d %B %Y', time()); ?>
				</p>
			</div>
		</div>
	</div>

	<div class="row mb-4">
		<div class="col-md-3 mb-3">
			<div class="card stat-card bg-primary text-white">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-start">
						<div>
							<h6 class="card-title opacity-75">Total Buku</h6>
							<h2 class="mb-0" style="font-size: 2.5rem; font-weight: 700;"><?php echo number_format($total_buku); ?></h2>
						</div>
						<i class="bi bi-book fs-1 opacity-50"></i>
					</div>
				</div>
				<div class="card-footer bg-primary border-top border-white border-opacity-25">
					<a href="<?php echo $base_path; ?>/modules/buku/index.php" class="text-white text-decoration-none">
						Lihat Detail <i class="bi bi-arrow-right"></i>
					</a>
				</div>
			</div>
		</div>

		<div class="col-md-3 mb-3">
			<div class="card stat-card bg-success text-white">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-start">
						<div>
							<h6 class="card-title opacity-75">Buku Tersedia</h6>
							<h2 class="mb-0" style="font-size: 2.5rem; font-weight: 700;"><?php echo number_format($buku_tersedia); ?></h2>
						</div>
						<i class="bi bi-stack fs-1 opacity-50"></i>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-3 mb-3">
			<div class="card stat-card bg-danger text-white">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-start">
						<div>
							<h6 class="card-title opacity-75">Buku Habis Stok</h6>
							<h2 class="mb-0" style="font-size: 2.5rem; font-weight: 700;"><?php echo number_format($buku_habis); ?></h2>
						</div>
						<i class="bi bi-exclamation-circle fs-1 opacity-50"></i>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-3 mb-3">
			<div class="card stat-card bg-info text-white">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-start">
						<div>
							<h6 class="card-title opacity-75">Total Anggota</h6>
							<h2 class="mb-0" style="font-size: 2.5rem; font-weight: 700;"><?php echo number_format($total_anggota); ?></h2>
						</div>
						<i class="bi bi-people fs-1 opacity-50"></i>
					</div>
				</div>
				<div class="card-footer bg-info border-top border-white border-opacity-25">
					<a href="<?php echo $base_path; ?>/sistem_anggota.php" class="text-white text-decoration-none">
						Lihat Detail <i class="bi bi-arrow-right"></i>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header bg-primary text-white">
					<h5 class="mb-0"><i class="bi bi-grid-3x3-gap"></i> Menu Utama</h5>
				</div>
				<div class="card-body">
					<div class="row g-3">
						<div class="col-md-4">
						<a href="<?php echo $base_path; ?>/modules/buku/index.php" class="btn btn-light menu-btn w-100 p-4 text-start text-decoration-none">
								<div class="d-flex align-items-center">
									<i class="bi bi-book fs-3 text-primary me-3"></i>
									<div>
										<h6 class="mb-1">Data Buku</h6>
										<small class="text-muted">Kelola data buku perpustakaan</small>
									</div>
								</div>
							</a>
						</div>

						<div class="col-md-4">
							<button class="btn btn-light menu-btn w-100 p-4 text-start" disabled style="cursor: not-allowed; opacity: 0.6;">
								<div class="d-flex align-items-center">
									<i class="bi bi-tag fs-3 text-warning me-3"></i>
									<div>
										<h6 class="mb-1">Kategori Buku</h6>
										<small class="text-muted">Kelola kategori buku (Segera)</small>
									</div>
								</div>
							</button>
						</div>

						<div class="col-md-4">
							<a href="<?php echo $base_path; ?>/sistem_anggota.php" class="btn btn-light menu-btn w-100 p-4 text-start text-decoration-none">
								<div class="d-flex align-items-center">
									<i class="bi bi-people fs-3 text-info me-3"></i>
									<div>
										<h6 class="mb-1">Data Anggota</h6>
										<small class="text-muted">Kelola data anggota perpustakaan</small>
									</div>
								</div>
							</a>
						</div>

						<div class="col-md-4">
							<button class="btn btn-light menu-btn w-100 p-4 text-start" disabled style="cursor: not-allowed; opacity: 0.6;">
								<div class="d-flex align-items-center">
									<i class="bi bi-arrow-left-right fs-3 text-success me-3"></i>
									<div>
										<h6 class="mb-1">Peminjaman</h6>
										<small class="text-muted">Kelola peminjaman buku (Segera)</small>
									</div>
								</div>
							</button>
						</div>

						<div class="col-md-4">
							<button class="btn btn-light menu-btn w-100 p-4 text-start" disabled style="cursor: not-allowed; opacity: 0.6;">
								<div class="d-flex align-items-center">
									<i class="bi bi-reply fs-3 text-danger me-3"></i>
									<div>
										<h6 class="mb-1">Pengembalian</h6>
										<small class="text-muted">Kelola pengembalian buku (Segera)</small>
									</div>
								</div>
							</button>
						</div>

						<div class="col-md-4">
							<button class="btn btn-light menu-btn w-100 p-4 text-start" disabled style="cursor: not-allowed; opacity: 0.6;">
								<div class="d-flex align-items-center">
									<i class="bi bi-file-earmark-pdf fs-3 text-secondary me-3"></i>
									<div>
										<h6 class="mb-1">Laporan</h6>
										<small class="text-muted">Lihat laporan sistem (Segera)</small>
									</div>
								</div>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row mt-4">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header bg-secondary text-white">
					<h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Sistem</h5>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<p><strong>Versi PHP:</strong> <?php echo phpversion(); ?></p>
							<p><strong>Database:</strong> <?php echo isset($conn) ? 'Terhubung' : 'Tidak Terhubung'; ?></p>
						</div>
						<div class="col-md-6">
							<p><strong>Server:</strong> <?php echo $_SERVER['SERVER_SOFTWARE']; ?></p>
							<p><strong>Waktu Server:</strong> <?php echo date('d-m-Y H:i:s'); ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
