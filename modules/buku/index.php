<?php
$page_title = 'Data Buku';
require_once '../../config/database.php';
require_once '../../includes/header.php';

$limit = 10;
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$result = null;
$stmt = null;
$stmt_count = null;

if ($search !== '') {
    $query = "SELECT b.id_buku, b.judul, b.pengarang, k.nama_kategori AS kategori, p.nama_penerbit AS penerbit, b.tahun_terbit, b.harga, b.stok
              FROM buku b
              LEFT JOIN kategori_buku k ON b.id_kategori = k.id_kategori
              LEFT JOIN penerbit p ON b.id_penerbit = p.id_penerbit
              WHERE b.is_deleted = 0
                AND (
                    b.judul LIKE ?
                    OR b.pengarang LIKE ?
                    OR k.nama_kategori LIKE ?
                    OR p.nama_penerbit LIKE ?
                )
              ORDER BY b.created_at DESC
              LIMIT ? OFFSET ?";
    $search_param = '%' . $search . '%';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssii', $search_param, $search_param, $search_param, $search_param, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    $count_query = "SELECT COUNT(*) AS total
                    FROM buku b
                    LEFT JOIN kategori_buku k ON b.id_kategori = k.id_kategori
                    LEFT JOIN penerbit p ON b.id_penerbit = p.id_penerbit
                    WHERE b.is_deleted = 0
                      AND (
                          b.judul LIKE ?
                          OR b.pengarang LIKE ?
                          OR k.nama_kategori LIKE ?
                          OR p.nama_penerbit LIKE ?
                      )";
    $stmt_count = $conn->prepare($count_query);
    $stmt_count->bind_param('ssss', $search_param, $search_param, $search_param, $search_param);
    $stmt_count->execute();
    $total_rows = (int) $stmt_count->get_result()->fetch_assoc()['total'];
} else {
    $query = "SELECT b.id_buku, b.judul, b.pengarang, k.nama_kategori AS kategori, p.nama_penerbit AS penerbit, b.tahun_terbit, b.harga, b.stok
              FROM buku b
              LEFT JOIN kategori_buku k ON b.id_kategori = k.id_kategori
              LEFT JOIN penerbit p ON b.id_penerbit = p.id_penerbit
              WHERE b.is_deleted = 0
              ORDER BY b.created_at DESC
              LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    $total_rows = (int) $conn->query("SELECT COUNT(*) AS total FROM buku WHERE is_deleted = 0")->fetch_assoc()['total'];
}

$total_pages = max(1, (int) ceil($total_rows / $limit));
?>

<div class="container">
    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
            <h2><i class="bi bi-book"></i> Data Buku Perpustakaan</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="create.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Buku Baru
            </a>
        </div>
    </div>

    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle"></i> <?php echo htmlspecialchars($_GET['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-x-circle"></i> <?php echo htmlspecialchars($_GET['error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Cari judul, pengarang, kategori, atau penerbit...">
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

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                Daftar Buku
                <?php if ($search !== ''): ?>
                    <span class="badge bg-light text-dark">
                        Hasil pencarian: "<?php echo htmlspecialchars($search); ?>"
                    </span>
                <?php endif; ?>
            </h5>
        </div>
        <div class="card-body">
            <?php if ($result && $result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Judul Buku</th>
                            <th>Kategori</th>
                            <th>Pengarang</th>
                            <th>Penerbit</th>
                            <th width="80">Tahun</th>
                            <th width="120">Harga</th>
                            <th width="60">Stok</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = $offset + 1; ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($row['judul']); ?></td>
                            <td>
                                <span class="badge bg-primary">
                                    <?php echo htmlspecialchars($row['kategori'] ?: '-'); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($row['pengarang'] ?: '-'); ?></td>
                            <td><?php echo htmlspecialchars($row['penerbit'] ?: '-'); ?></td>
                            <td><?php echo htmlspecialchars($row['tahun_terbit'] ?: '-'); ?></td>
                            <td>Rp <?php echo number_format((float) $row['harga'], 0, ',', '.'); ?></td>
                            <td class="text-center">
                                <?php if ((int) $row['stok'] > 0): ?>
                                    <span class="badge bg-success"><?php echo (int) $row['stok']; ?></span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Habis</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="edit.php?id=<?php echo (int) $row['id_buku']; ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="delete.php?id=<?php echo (int) $row['id_buku']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($total_pages > 1): ?>
            <nav aria-label="Page navigation" class="mt-3">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo max(1, $page - 1); ?><?php echo $search !== '' ? '&search=' . urlencode($search) : ''; ?>">Previous</a>
                    </li>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($page === $i) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?><?php echo $search !== '' ? '&search=' . urlencode($search) : ''; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>

                    <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo min($total_pages, $page + 1); ?><?php echo $search !== '' ? '&search=' . urlencode($search) : ''; ?>">Next</a>
                    </li>
                </ul>
            </nav>
            <?php endif; ?>

            <div class="alert alert-info mt-3 mb-0">
                <i class="bi bi-info-circle"></i>
                <strong>Total:</strong> <?php echo $total_rows; ?> buku terdaftar
                <?php if ($search !== ''): ?>
                    | <strong>Ditemukan:</strong> <?php echo $result->num_rows; ?> buku
                <?php endif; ?>
                | <strong>Halaman:</strong> <?php echo $page; ?> dari <?php echo $total_pages; ?>
            </div>
            <?php else: ?>
            <div class="alert alert-warning mb-0">
                <i class="bi bi-exclamation-triangle"></i>
                <?php if ($search !== ''): ?>
                    Tidak ada buku yang cocok dengan pencarian "<?php echo htmlspecialchars($search); ?>"
                <?php else: ?>
                    Belum ada data buku. Silakan tambah buku baru.
                <?php endif; ?>
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