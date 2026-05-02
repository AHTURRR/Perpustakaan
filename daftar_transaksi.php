<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5 mb-5">
        <h1 class="mb-4">Daftar Transaksi Peminjaman</h1>
        
        <?php
        // Inisialisasi variabel statistik
        $total_transaksi = 0;
        $total_dipinjam = 0;
        $total_dikembalikan = 0;
        
        // Loop pertama untuk menghitung statistik sesuai aturan (skip genap, stop di 8)
        for ($i = 1; $i <= 10; $i++) {
            if ($i == 8) {
                break; // Berhenti di transaksi ke-8
            }
            if ($i % 2 == 0) {
                continue; // Lewati transaksi genap
            }

            $total_transaksi++;
            $status = ($i % 3 == 0) ? "Dikembalikan" : "Dipinjam";
            
            if ($status == "Dikembalikan") {
                $total_dikembalikan++;
            } else {
                $total_dipinjam++;
            }
        }
        ?>
        
        <div class="row mb-4 text-center">
            <div class="col-md-4">
                <div class="card text-bg-primary shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Total Ditampilkan</h5>
                        <h2 class="card-text"><?= $total_transaksi ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-bg-warning shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Masih Dipinjam</h5>
                        <h2 class="card-text"><?= $total_dipinjam ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-bg-success shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Sudah Dikembalikan</h5>
                        <h2 class="card-text"><?= $total_dikembalikan ?></h2>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>ID Transaksi</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Hari Terlewat</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1; // Variabel untuk nomor urut tabel sesungguhnya
                    
                    // Loop kedua untuk menampilkan data ke dalam tabel
                    for ($i = 1; $i <= 10; $i++) {
                        // Stop di transaksi ke-8 dengan BREAK
                        if ($i == 8) {
                            break;
                        }
                        
                        // Skip transaksi genap dengan CONTINUE
                        if ($i % 2 == 0) {
                            continue;
                        }

                        // Generate data transaksi
                        $id_transaksi = "TRX-" . str_pad($i, 4, "0", STR_PAD_LEFT);
                        $nama_peminjam = "Anggota " . $i;
                        $judul_buku = "Buku Teknologi Vol. " . $i;
                        $tanggal_pinjam = date('Y-m-d', strtotime("-$i days"));
                        $tanggal_kembali = date('Y-m-d', strtotime("+7 days", strtotime($tanggal_pinjam)));
                        $status = ($i % 3 == 0) ? "Dikembalikan" : "Dipinjam";
                        
                        // Hitung jumlah hari sejak pinjam (karena - $i days, maka otomatis $i hari)
                        $hari_sejak_pinjam = $i; 
                        
                        // Tentukan class warna badge Bootstrap
                        $badge_class = ($status == "Dikembalikan") ? "bg-success" : "bg-warning text-dark";
                        ?>
                        
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><span class="fw-bold"><?= $id_transaksi ?></span></td>
                            <td><?= $nama_peminjam ?></td>
                            <td><?= $judul_buku ?></td>
                            <td><?= date('d M Y', strtotime($tanggal_pinjam)) ?></td>
                            <td><?= date('d M Y', strtotime($tanggal_kembali)) ?></td>
                            <td><?= $hari_sejak_pinjam ?> Hari</td>
                            <td><span class="badge <?= $badge_class ?>"><?= $status ?></span></td>
                        </tr>
                        
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>