<?php
require_once __DIR__ . '/../../config/database.php';

$q = isset($_GET['q']) ? sanitize($_GET['q']) : '';
if ($q !== '') {
    $like = "%{$q}%";
    $stmt = $conn->prepare("SELECT * FROM anggota WHERE kode_anggota LIKE ? OR nama LIKE ? OR email LIKE ? ORDER BY created_at DESC");
    $stmt->bind_param('sss', $like, $like, $like);
    $stmt->execute();
    $res = $stmt->get_result();
} else {
    $res = $conn->query('SELECT * FROM anggota ORDER BY created_at DESC');
}

$filename = 'anggota_export_' . date('Ymd_His') . '.csv';
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);
 $out = fopen('php://output', 'w');
fputcsv($out, ['ID','Kode','Nama','Email','Telepon','Alamat','Tgl Lahir','Jenis Kelamin','Pekerjaan','Tanggal Daftar','Status','Created At','Updated At']);
while ($row = $res->fetch_assoc()) {
    fputcsv($out, [$row['id_anggota'],$row['kode_anggota'],$row['nama'],$row['email'],$row['telepon'],$row['alamat'],$row['tanggal_lahir'],$row['jenis_kelamin'],$row['pekerjaan'],$row['tanggal_daftar'],$row['status'],$row['created_at'],$row['updated_at']]);
}
fclose($out);
exit;
