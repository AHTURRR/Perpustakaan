<?php
require_once __DIR__ . '/../../config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) { header('Location: index.php'); exit; }

$stmt = $conn->prepare('SELECT * FROM anggota WHERE id_anggota = ?');
$stmt->bind_param('i', $id); $stmt->execute(); $res = $stmt->get_result();
if ($res->num_rows === 0) { header('Location: index.php'); exit; }
$data = $res->fetch_assoc(); $stmt->close();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = sanitize($_POST['kode_anggota'] ?? '');
    $nama = sanitize($_POST['nama'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $telepon = sanitize($_POST['telepon'] ?? '');
    $alamat = sanitize($_POST['alamat'] ?? '');
    $tanggal_lahir = sanitize($_POST['tanggal_lahir'] ?? '');
    $jenis_kelamin = sanitize($_POST['jenis_kelamin'] ?? '');
    $pekerjaan = sanitize($_POST['pekerjaan'] ?? '');
    $tanggal_daftar = sanitize($_POST['tanggal_daftar'] ?? date('Y-m-d'));
    $status = in_array($_POST['status'] ?? '', ['Aktif','Nonaktif']) ? $_POST['status'] : 'Aktif';

    if ($kode === '') $errors[] = 'Kode anggota wajib diisi.';
    if ($nama === '') $errors[] = 'Nama wajib diisi.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email tidak valid.';
    if ($telepon === '' || strpos($telepon, '08') !== 0) $errors[] = 'Telepon harus diawali 08.';

    // Age check
    if ($tanggal_lahir) {
        $age = (int)date('Y') - (int)date('Y', strtotime($tanggal_lahir));
        if ($age < 10) $errors[] = 'Usia minimal 10 tahun.';
    }

    // Unique checks excluding current id
    $stmt = $conn->prepare('SELECT COUNT(*) FROM anggota WHERE (email = ? OR kode_anggota = ?) AND id_anggota != ?');
    $stmt->bind_param('ssi', $email, $kode, $id);
    $stmt->execute(); $stmt->bind_result($count); $stmt->fetch(); $stmt->close();
    if ($count > 0) $errors[] = 'Email atau Kode anggota sudah dipakai oleh data lain.';

    // Handle upload replace
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
        $f = $_FILES['foto'];
        $allowed = ['image/jpeg','image/png','image/jpg'];
        if ($f['error'] === 0 && in_array($f['type'], $allowed)) {
            $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
            $foto_name = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
            $dest = __DIR__ . '/uploads/' . $foto_name;
            if (move_uploaded_file($f['tmp_name'], $dest)) {
                // remove old
                if (!empty($data['foto']) && file_exists(__DIR__ . '/uploads/' . $data['foto'])) {
                    @unlink(__DIR__ . '/uploads/' . $data['foto']);
                }
                $data['foto'] = $foto_name;
            } else {
                $errors[] = 'Gagal mengunggah foto baru.';
            }
        } else {
            $errors[] = 'Format foto tidak didukung (jpg/png).';
        }
    }

    if (empty($errors)) {
        $now = date('Y-m-d H:i:s');
        $stmt = $conn->prepare('UPDATE anggota SET kode_anggota=?,nama=?,email=?,telepon=?,alamat=?,tanggal_lahir=?,jenis_kelamin=?,pekerjaan=?,tanggal_daftar=?,status=?,foto=?,updated_at=? WHERE id_anggota=?');
        $foto_db = $data['foto'] ?? '';
        $stmt->bind_param('ssssssssssssi', $kode,$nama,$email,$telepon,$alamat,$tanggal_lahir,$jenis_kelamin,$pekerjaan,$tanggal_daftar,$status,$foto_db,$now,$id);
        if ($stmt->execute()) {
            header('Location: index.php'); exit;
        } else {
            $errors[] = 'Gagal menyimpan: ' . $stmt->error;
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Anggota</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h4>Edit Anggota</h4>
  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach ($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data">
    <div class="row">
      <div class="mb-3 col-md-4">
        <label class="form-label">Kode Anggota</label>
        <input name="kode_anggota" class="form-control" required value="<?php echo htmlspecialchars($_POST['kode_anggota'] ?? $data['kode_anggota']) ?>">
      </div>
      <div class="mb-3 col-md-8">
        <label class="form-label">Nama</label>
        <input name="nama" class="form-control" required value="<?php echo htmlspecialchars($_POST['nama'] ?? $data['nama']) ?>">
      </div>
    </div>
    <div class="row">
      <div class="mb-3 col-md-6">
        <label class="form-label">Email</label>
        <input name="email" type="email" class="form-control" required value="<?php echo htmlspecialchars($_POST['email'] ?? $data['email']) ?>">
      </div>
      <div class="mb-3 col-md-6">
        <label class="form-label">Telepon</label>
        <input name="telepon" class="form-control" required value="<?php echo htmlspecialchars($_POST['telepon'] ?? $data['telepon']) ?>">
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Alamat</label>
      <textarea name="alamat" class="form-control"><?php echo htmlspecialchars($_POST['alamat'] ?? $data['alamat']) ?></textarea>
    </div>

    <div class="row">
      <div class="mb-3 col-md-4">
        <label class="form-label">Tanggal Lahir</label>
        <input name="tanggal_lahir" type="date" class="form-control" required value="<?php echo htmlspecialchars($_POST['tanggal_lahir'] ?? $data['tanggal_lahir']) ?>">
      </div>
      <div class="mb-3 col-md-4">
        <label class="form-label">Jenis Kelamin</label>
        <select name="jenis_kelamin" class="form-select">
          <option value="">- Pilih -</option>
          <option value="L" <?php echo (($_POST['jenis_kelamin'] ?? $data['jenis_kelamin'])=='L')?'selected':'' ?>>Laki-laki</option>
          <option value="P" <?php echo (($_POST['jenis_kelamin'] ?? $data['jenis_kelamin'])=='P')?'selected':'' ?>>Perempuan</option>
        </select>
      </div>
      <div class="mb-3 col-md-4">
        <label class="form-label">Pekerjaan</label>
        <input name="pekerjaan" class="form-control" value="<?php echo htmlspecialchars($_POST['pekerjaan'] ?? $data['pekerjaan']) ?>">
      </div>
    </div>

    <div class="row">
      <div class="mb-3 col-md-4">
        <label class="form-label">Tanggal Daftar</label>
        <input name="tanggal_daftar" type="date" class="form-control" value="<?php echo htmlspecialchars($_POST['tanggal_daftar'] ?? $data['tanggal_daftar']) ?>">
      </div>
      <div class="mb-3 col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="Aktif" <?php echo (($_POST['status'] ?? $data['status'])=='Aktif')?'selected':'' ?>>Aktif</option>
          <option value="Nonaktif" <?php echo (($_POST['status'] ?? $data['status'])=='Nonaktif')?'selected':'' ?>>Nonaktif</option>
        </select>
      </div>
      <div class="mb-3 col-md-4">
        <label class="form-label">Foto (opsional)</label>
        <input name="foto" type="file" accept="image/*" class="form-control">
        <?php if (!empty($data['foto']) && file_exists(__DIR__ . '/uploads/' . $data['foto'])): ?>
          <img src="uploads/<?php echo htmlspecialchars($data['foto']) ?>" style="width:80px;margin-top:8px;border-radius:6px;">
        <?php endif; ?>
      </div>
    </div>

    <div class="d-flex gap-2">
      <button class="btn btn-primary">Simpan</button>
      <a href="index.php" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
</body>
</html>
