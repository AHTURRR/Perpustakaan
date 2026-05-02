<?php
$page_title = "Data Anggota";
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/header.php';

$limit = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$offset = ($page - 1) * $limit;

// Count total with search
if ($search !== '') {
    $search_param = '%' . $search . '%';
    $count_stmt = $conn->prepare("SELECT COUNT(*) AS total FROM anggota WHERE kode_anggota LIKE ? OR nama LIKE ? OR email LIKE ? OR telepon LIKE ?");
    $count_stmt->bind_param('ssss', $search_param, $search_param, $search_param, $search_param);
    $count_stmt->execute();
    $total_rows = (int) $count_stmt->get_result()->fetch_assoc()['total'];
    $count_stmt->close();
} else {
    $total_rows = (int) $conn->query("SELECT COUNT(*) AS total FROM anggota")->fetch_assoc()['total'];
}

$total_pages = max(1, (int) ceil($total_rows / $limit));

// Fetch rows with search
if ($search !== '') {
    $search_param = '%' . $search . '%';
    $stmt = $conn->prepare("SELECT * FROM anggota WHERE kode_anggota LIKE ? OR nama LIKE ? OR email LIKE ? OR telepon LIKE ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->bind_param('ssssii', $search_param, $search_param, $search_param, $search_param, $limit, $offset);
} else {
    $stmt = $conn->prepare("SELECT * FROM anggota ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->bind_param('ii', $limit, $offset);
}
$stmt->execute();
$result = $stmt->get_result();

?>

<div class="container mt-4 mb-5">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2><i class="bi bi-people"></i> Data Anggota Perpustakaan</h2>
        </div>
        <div class="col-md-6 text-end">
            <div class="d-flex gap-2">
                <a href="create.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Anggota
                </a>
                <a href="dashboard.php" class="btn btn-secondary">
                    <i class="bi bi-graph-up"></i> Dashboard
                </a>
                <a href="export.php?search=<?php echo urlencode($search) ?>" class="btn btn-success">
                    <i class="bi bi-download"></i> Export Excel
                </a>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i> <?php echo htmlspecialchars($_GET['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-x-circle"></i> <?php echo htmlspecialchars($_GET['error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="GET" action="">
                <div class="input-group input-group-lg">
                    <input type="text" class="form-control" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Cari kode anggota, nama, email, atau telepon...">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <?php if ($search !== ''): ?>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-list-ul"></i> Daftar Anggota
                <?php if ($search !== ''): ?>
                    <span class="badge bg-light text-dark ms-2">
                        Hasil pencarian: "<?php echo htmlspecialchars($search); ?>"
                    </span>
                <?php endif; ?>
            </h5>
        </div>
        <div class="card-body">
            <?php if ($result && $result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th width="80">Foto</th>
                            <th>Kode Anggota</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th width="120">Tgl Daftar</th>
                            <th width="80">Status</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = $offset + 1; ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td>
                                <?php if (!empty($row['foto']) && file_exists(__DIR__ . '/uploads/' . $row['foto'])): ?>
                                    <img src="uploads/<?php echo htmlspecialchars($row['foto']) ?>" 
                                         class="rounded-circle" 
                                         width="40" 
                                         height="40" 
                                         style="object-fit: cover; border: 2px solid #dee2e6;"
                                         alt="Foto <?php echo htmlspecialchars($row['nama']); ?>">
                                <?php else: ?>
                                    <div class="bg-light d-inline-flex align-items-center justify-content-center rounded-circle" 
                                         style="width:40px;height:40px;border: 2px solid #dee2e6;">
                                        <i class="bi bi-person text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    <?php echo htmlspecialchars($row['kode_anggota']); ?>
                                </span>
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($row['nama']); ?></strong>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <i class="bi bi-envelope"></i> 
                                    <?php echo htmlspecialchars($row['email']); ?>
                                </small>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <i class="bi bi-telephone"></i> 
                                    <?php echo htmlspecialchars($row['telepon'] ?: '-'); ?>
                                </small>
                            </td>
                            <td>
                                <?php echo htmlspecialchars(date('d/m/Y', strtotime($row['tanggal_daftar']))); ?>
                            </td>
                            <td>
                                <?php if ($row['status'] === 'Aktif'): ?>
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle"></i> Nonaktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="edit.php?id=<?php echo (int) $row['id_anggota']; ?>" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="delete.php?id=<?php echo (int) $row['id_anggota']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus anggota ini?')" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($total_pages > 1): ?>
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo max(1, $page - 1); ?><?php echo $search !== '' ? '&search=' . urlencode($search) : ''; ?>">
                            <i class="bi bi-chevron-left"></i> Previous
                        </a>
                    </li>

                    <?php 
                    $start_page = max(1, $page - 2);
                    $end_page = min($total_pages, $page + 2);
                    if ($start_page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=1<?php echo $search !== '' ? '&search=' . urlencode($search) : ''; ?>">1</a>
                        </li>
                        <?php if ($start_page > 2): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                    <li class="page-item <?php echo ($page === $i) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?><?php echo $search !== '' ? '&search=' . urlencode($search) : ''; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>

                    <?php if ($end_page < $total_pages): ?>
                        <?php if ($end_page < $total_pages - 1): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $total_pages; ?><?php echo $search !== '' ? '&search=' . urlencode($search) : ''; ?>"><?php echo $total_pages; ?></a>
                        </li>
                    <?php endif; ?>

                    <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo min($total_pages, $page + 1); ?><?php echo $search !== '' ? '&search=' . urlencode($search) : ''; ?>">
                            Next <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <?php endif; ?>

            <div class="alert alert-info mt-4 mb-0">
                <i class="bi bi-info-circle"></i>
                <strong>Total:</strong> <?php echo $total_rows; ?> anggota terdaftar
                <?php if ($search !== ''): ?>
                    | <strong>Ditemukan:</strong> <?php echo $result->num_rows; ?> hasil
                <?php endif; ?>
            </div>

            <?php else: ?>
            <div class="alert alert-warning text-center mb-0">
                <i class="bi bi-exclamation-triangle"></i> Tidak ada data anggota ditemukan
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
if (isset($stmt) && $stmt instanceof mysqli_stmt) {
    $stmt->close();
}
if (isset($stmt_count) && $stmt_count instanceof mysqli_stmt) {
    $stmt_count->close();
}
closeConnection();
require_once '../../includes/footer.php';
?>