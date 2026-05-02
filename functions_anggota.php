<?php
/**
 * functions_anggota.php
 * Kumpulan fungsi untuk mengelola data anggota perpustakaan
 */

// 1. Hitung total anggota
function hitung_total_anggota($anggota_list) {
    return count($anggota_list);
}

// 2. Hitung anggota aktif
function hitung_anggota_aktif($anggota_list) {
    $aktif = 0;
    foreach ($anggota_list as $anggota) {
        if ($anggota['status'] == 'Aktif') $aktif++;
    }
    return $aktif;
}

// 3. Hitung anggota non-aktif
function hitung_anggota_nonaktif($anggota_list) {
    $nonaktif = 0;
    foreach ($anggota_list as $anggota) {
        if ($anggota['status'] == 'Non-Aktif') $nonaktif++;
    }
    return $nonaktif;
}

// 4. Hitung rata-rata pinjaman
function hitung_rata_rata_pinjaman($anggota_list) {
    $total = 0;
    $jumlah = count($anggota_list);
    if ($jumlah == 0) return 0;
    foreach ($anggota_list as $anggota) {
        $total += $anggota['total_pinjaman'];
    }
    return $total / $jumlah;
}

// 5. Cari anggota berdasarkan ID
function cari_anggota_by_id($anggota_list, $id) {
    foreach ($anggota_list as $anggota) {
        if ($anggota['id'] == $id) return $anggota;
    }
    return null;
}

// 6. Cari anggota teraktif (total pinjaman tertinggi)
function cari_anggota_teraktif($anggota_list) {
    if (empty($anggota_list)) return null;
    $teraktif = $anggota_list[0];
    foreach ($anggota_list as $anggota) {
        if ($anggota['total_pinjaman'] > $teraktif['total_pinjaman']) {
            $teraktif = $anggota;
        }
    }
    return $teraktif;
}

// 7. Filter anggota berdasarkan status
function filter_by_status($anggota_list, $status) {
    $hasil = [];
    foreach ($anggota_list as $anggota) {
        if ($anggota['status'] == $status) $hasil[] = $anggota;
    }
    return $hasil;
}

// 8. Validasi email (menggunakan filter_var)
function validasi_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// 9. Format tanggal ke format Indonesia (DD NamaBulan YYYY)
function format_tanggal_indo($tanggal) {
    $timestamp = strtotime($tanggal);
    if (!$timestamp) return '-';
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    return date('d', $timestamp) . ' ' . $bulan[(int)date('m', $timestamp)] . ' ' . date('Y', $timestamp);
}

// 10. Pencarian anggota berdasarkan nama (case-insensitive, partial match)
function search_by_nama($anggota_list, $keyword) {
    if (empty($keyword)) return $anggota_list;
    $hasil = [];
    $keyword_lower = strtolower($keyword);
    foreach ($anggota_list as $anggota) {
        if (strpos(strtolower($anggota['nama']), $keyword_lower) !== false) {
            $hasil[] = $anggota;
        }
    }
    return $hasil;
}

// 11. Pengurutan anggota berdasarkan nama (A-Z)
function sort_by_nama($anggota_list, $order = 'asc') {
    usort($anggota_list, function($a, $b) use ($order) {
        $cmp = strcmp($a['nama'], $b['nama']);
        return ($order == 'asc') ? $cmp : -$cmp;
    });
    return $anggota_list;
}
?>