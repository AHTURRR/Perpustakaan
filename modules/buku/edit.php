<?php
$page_title = 'Edit Data Buku';
require_once '../../config/database.php';
require_once '../../includes/header.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php?error=ID buku tidak valid');
    exit();
}

$id_buku = (int) $_GET['id'];
$errors = [];
$judul = '';
$pengarang = '';
$id_kategori = '';
$id_penerbit = '';
$tahun_terbit = '';
$harga = '';
$stok = '';

$kategori_list = [];
$penerbit_list = [];

$kat_result = $conn->query("SELECT id_kategori, nama_kategori FROM kategori_buku ORDER BY nama_kategori");
if ($kat_result) {
    while ($row = $kat_result->fetch_assoc()) {
        $kategori_list[] = $row;
    }
}

$pen_result = $conn->query("SELECT id_penerbit, nama_penerbit FROM penerbit ORDER BY nama_penerbit");
if ($pen_result) {
    while ($row = $pen_result->fetch_assoc()) {
        $penerbit_list[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $conn->prepare("SELECT b.id_buku, b.judul, b.pengarang, b.id_kategori, b.id_penerbit, b.tahun_terbit, b.harga, b.stok
                                       FROM buku b
                                       WHERE b.id_buku = ? AND b.is_deleted = 0");
    $stmt->bind_param('i', $id_buku);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $stmt->close();
        closeConnection();
        header('Location: index.php?error=Buku tidak ditemukan');
        exit();
    }

    $buku = $result->fetch_assoc();
    $stmt->close();

    $judul = $buku['judul'];
    $pengarang = $buku['pengarang'];
    $id_kategori = (int) $buku['id_kategori'];
    $id_penerbit = (int) $buku['id_penerbit'];
    $tahun_terbit = (int) $buku['tahun_terbit'];
    $harga = (float) $buku['harga'];
    $stok = (int) $buku['stok'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = sanitize($_POST['judul'] ?? '');
    $pengarang = sanitize($_POST['pengarang'] ?? '');
    $id_kategori = (int) ($_POST['id_kategori'] ?? 0);
    $id_penerbit = (int) ($_POST['id_penerbit'] ?? 0);
    $tahun_terbit = (int) ($_POST['tahun_terbit'] ?? 0);
    $harga = (float) ($_POST['harga'] ?? 0);
    $stok = (int) ($_POST['stok'] ?? 0);

    if (empty($judul)) {
        $errors[] = 'Judul buku wajib diisi';
    } elseif (strlen($judul) < 3) {
        $errors[] = 'Judul minimal 3 karakter';
    }

    if (empty($pengarang)) {
        $errors[] = 'Pengarang wajib diisi';
    }

    if ($id_kategori <= 0) {
        $errors[] = 'Kategori wajib dipilih';
    }

    if ($id_penerbit <= 0) {
        $errors[] = 'Penerbit wajib dipilih';
    }

    if (empty($tahun_terbit) || $tahun_terbit < 1900 || $tahun_terbit > date('Y')) {
        $errors[] = 'Tahun terbit tidak valid (1900 - ' . date('Y') . ')';
    }

    if ($harga < 0) {
        $errors[] = 'Harga tidak boleh negatif';
    }

    if ($stok < 0) {
        $errors[] = 'Stok tidak boleh negatif';
    }

    if (count($errors) === 0) {
        $stmt = $conn->prepare("UPDATE buku SET judul = ?, pengarang = ?, id_kategori = ?, id_penerbit = ?, tahun_terbit = ?, harga = ?, stok = ? WHERE id_buku = ? AND is_deleted = 0");
        $stmt->bind_param('ssiidiii', $judul, $pengarang, $id_kategori, $id_penerbit, $tahun_terbit, $harga, $stok, $id_buku);

        if ($stmt->execute()) {
            $stmt->close();
            closeConnection();
            header('Location: index.php?success=' . urlencode("Buku '$judul' berhasil diupdate"));
            exit();
        } else {
            $errors[] = 'Error database: ' . $stmt->error;
        }

        $stmt->close();
    }
}
?>
 
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil"></i> Edit Data Buku
                    </h4>
                </div>
                <div class="card-body">
                    <?php if (count($errors) > 0): ?>
                    <div class="alert alert-danger">
                        <h6><i class="bi bi-exclamation-triangle"></i> Terdapat kesalahan:</h6>
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <!-- Judul & Tahun Terbit -->
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="judul" class="form-label">
                                    Judul Buku <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control"
                                       id="judul"
                                       name="judul"
                                       value="<?php echo htmlspecialchars($judul); ?>"
                                       placeholder="Masukkan judul buku"
                                       required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="tahun_terbit" class="form-label">
                                    Tahun Terbit <span class="text-danger">*</span>
                                </label>
                                <input type="number"
                                       class="form-control"
                                       id="tahun_terbit"
                                       name="tahun_terbit"
                                       value="<?php echo htmlspecialchars($tahun_terbit ?: date('Y')); ?>"
                                       min="1900"
                                       max="<?php echo date('Y'); ?>"
                                       required>
                            </div>
                        </div>

                        <!-- Pengarang -->
                        <div class="mb-3">
                            <label for="pengarang" class="form-label">
                                Pengarang <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control"
                                   id="pengarang"
                                   name="pengarang"
                                   value="<?php echo htmlspecialchars($pengarang); ?>"
                                   placeholder="Nama pengarang"
                                   required>
                        </div>

                        <!-- Kategori & Penerbit -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_kategori" class="form-label">
                                    Kategori <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="id_kategori" name="id_kategori" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php foreach ($kategori_list as $kat): ?>
                                        <option value="<?php echo (int) $kat['id_kategori']; ?>" <?php echo ($id_kategori === (int) $kat['id_kategori']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($kat['nama_kategori']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="id_penerbit" class="form-label">
                                    Penerbit <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="id_penerbit" name="id_penerbit" required>
                                    <option value="">-- Pilih Penerbit --</option>
                                    <?php foreach ($penerbit_list as $pen): ?>
                                        <option value="<?php echo (int) $pen['id_penerbit']; ?>" <?php echo ($id_penerbit === (int) $pen['id_penerbit']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($pen['nama_penerbit']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Harga & Stok -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="harga" class="form-label">
                                    Harga (Rp) <span class="text-danger">*</span>
                                </label>
                                <input type="number"
                                       class="form-control"
                                       id="harga"
                                       name="harga"
                                       value="<?php echo htmlspecialchars($harga ?: 0); ?>"
                                       min="0"
                                       step="1000"
                                       placeholder="75000"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="stok" class="form-label">
                                    Stok <span class="text-danger">*</span>
                                </label>
                                <input type="number"
                                       class="form-control"
                                       id="stok"
                                       name="stok"
                                       value="<?php echo htmlspecialchars($stok ?: 0); ?>"
                                       min="0"
                                       placeholder="10"
                                       required>
                            </div>
                        </div>

                        <hr>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-save"></i> Update Data Buku
                            </button>
                            <a href="index.php" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 
<?php
closeConnection();
require_once '../../includes/footer.php';
?>