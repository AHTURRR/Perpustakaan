<?php
require_once __DIR__ . '/../../config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id) {
    // get photo
    $stmt = $conn->prepare('SELECT foto FROM anggota WHERE id_anggota = ?');
    $stmt->bind_param('i', $id); $stmt->execute(); $stmt->bind_result($foto); $stmt->fetch(); $stmt->close();

    if (!empty($foto) && file_exists(__DIR__ . '/uploads/' . $foto)) {
        @unlink(__DIR__ . '/uploads/' . $foto);
    }

    $stmt = $conn->prepare('DELETE FROM anggota WHERE id_anggota = ?');
    $stmt->bind_param('i', $id); $stmt->execute(); $stmt->close();
}

header('Location: index.php'); exit;
