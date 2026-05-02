<?php
require_once __DIR__ . '/../../config/database.php';

$tot = 0; $aktif = 0; $non = 0;
$r = $conn->query('SELECT COUNT(*) AS c, SUM(status = "Aktif") AS a, SUM(status = "Nonaktif") AS n FROM anggota');
if ($r) { $row = $r->fetch_assoc(); $tot = $row['c']; $aktif = $row['a']; $non = $row['n']; }

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Anggota</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Dashboard Anggota</h4>
    <div>
      <a href="index.php" class="btn btn-secondary">Kembali</a>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-md-4">
      <div class="card p-3">
        <div class="h5">Total</div>
        <div class="fs-3"><?php echo (int)$tot ?></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-3">
        <div class="h6">Aktif</div>
        <div class="fs-3 text-success"><?php echo (int)$aktif ?></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-3">
        <div class="h6">Nonaktif</div>
        <div class="fs-3 text-secondary"><?php echo (int)$non ?></div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
