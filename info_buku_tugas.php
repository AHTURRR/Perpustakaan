<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Buku - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-borderless th {
            font-weight: 600;
            color: #555;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <h1 class="mb-4 text-center">Informasi Buku Perpustakaan</h1>
        
        <?php
        // --- DATA BUKU ---

        // Buku 1
        $judul1 = "Data Buku (Mastering SQL)";
        $pengarang1 = "Ahmad Turmudi";
        $penerbit1 = "Informatika";
        $tahun_terbit1 = 2023;
        $harga1 = 206000; // Harga disesuaikan agar lebih realistis
        $stok1 = 19;
        $isbn1 = "978-602-1234-56-7";
        $kategori1 = "Database";
        $bahasa1 = "Indonesia";
        $halaman1 = 350;
        $berat1 = 450;
        $badge_color1 = "bg-info text-dark"; // Info (Biru Muda)

        // Buku 2
        $judul2 = "Pemrograman PHP Modern";
        $pengarang2 = "Budi Raharjo";
        $penerbit2 = "Andi Publisher";
        $tahun_terbit2 = 2022;
        $harga2 = 150000;
        $stok2 = 25;
        $isbn2 = "978-602-5555-11-2";
        $kategori2 = "Programming";
        $bahasa2 = "Indonesia";
        $halaman2 = 450;
        $berat2 = 600;
        $badge_color2 = "bg-success"; // Success (Hijau)

        // Buku 3
        $judul3 = "Mastering UI/UX Web Design";
        $pengarang3 = "Sarah Connor";
        $penerbit3 = "Elex Media Komputindo";
        $tahun_terbit3 = 2024;
        $harga3 = 210000;
        $stok3 = 12;
        $isbn3 = "978-602-9999-33-4";
        $kategori3 = "Web Design";
        $bahasa3 = "Inggris";
        $halaman3 = 320;
        $berat3 = 400;
        $badge_color3 = "bg-warning text-dark"; // Warning (Kuning)

        // Buku 4
        $judul4 = "Advanced Database Administration";
        $pengarang4 = "John Doe";
        $penerbit4 = "O'Reilly Media";
        $tahun_terbit4 = 2021;
        $harga4 = 450000;
        $stok4 = 5;
        $isbn4 = "978-144-9393-22-1";
        $kategori4 = "Database";
        $bahasa4 = "Inggris";
        $halaman4 = 550;
        $berat4 = 800;
        $badge_color4 = "bg-info text-dark"; // Info (Biru Muda)
        ?>
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><?php echo $judul1; ?></h5>
                        <span class="badge <?php echo $badge_color1; ?>"><?php echo $kategori1; ?></span>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm">
                            <tr><th width="150">Pengarang</th><td>: <?php echo $pengarang1; ?></td></tr>
                            <tr><th>Penerbit</th><td>: <?php echo $penerbit1; ?></td></tr>
                            <tr><th>Tahun Terbit</th><td>: <?php echo $tahun_terbit1; ?></td></tr>
                            <tr><th>ISBN</th><td>: <?php echo $isbn1; ?></td></tr>
                            <tr><th>Bahasa</th><td>: <?php echo $bahasa1; ?></td></tr>
                            <tr><th>Halaman</th><td>: <?php echo $halaman1; ?> hal</td></tr>
                            <tr><th>Berat</th><td>: <?php echo $berat1; ?> gram</td></tr>
                            <tr><th>Harga</th><td>: Rp <?php echo number_format($harga1, 0, ',', '.'); ?></td></tr>
                            <tr><th>Stok</th><td>: <?php echo $stok1; ?> buku</td></tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><?php echo $judul2; ?></h5>
                        <span class="badge <?php echo $badge_color2; ?>"><?php echo $kategori2; ?></span>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm">
                            <tr><th width="150">Pengarang</th><td>: <?php echo $pengarang2; ?></td></tr>
                            <tr><th>Penerbit</th><td>: <?php echo $penerbit2; ?></td></tr>
                            <tr><th>Tahun Terbit</th><td>: <?php echo $tahun_terbit2; ?></td></tr>
                            <tr><th>ISBN</th><td>: <?php echo $isbn2; ?></td></tr>
                            <tr><th>Bahasa</th><td>: <?php echo $bahasa2; ?></td></tr>
                            <tr><th>Halaman</th><td>: <?php echo $halaman2; ?> hal</td></tr>
                            <tr><th>Berat</th><td>: <?php echo $berat2; ?> gram</td></tr>
                            <tr><th>Harga</th><td>: Rp <?php echo number_format($harga2, 0, ',', '.'); ?></td></tr>
                            <tr><th>Stok</th><td>: <?php echo $stok2; ?> buku</td></tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><?php echo $judul3; ?></h5>
                        <span class="badge <?php echo $badge_color3; ?>"><?php echo $kategori3; ?></span>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm">
                            <tr><th width="150">Pengarang</th><td>: <?php echo $pengarang3; ?></td></tr>
                            <tr><th>Penerbit</th><td>: <?php echo $penerbit3; ?></td></tr>
                            <tr><th>Tahun Terbit</th><td>: <?php echo $tahun_terbit3; ?></td></tr>
                            <tr><th>ISBN</th><td>: <?php echo $isbn3; ?></td></tr>
                            <tr><th>Bahasa</th><td>: <?php echo $bahasa3; ?></td></tr>
                            <tr><th>Halaman</th><td>: <?php echo $halaman3; ?> hal</td></tr>
                            <tr><th>Berat</th><td>: <?php echo $berat3; ?> gram</td></tr>
                            <tr><th>Harga</th><td>: Rp <?php echo number_format($harga3, 0, ',', '.'); ?></td></tr>
                            <tr><th>Stok</th><td>: <?php echo $stok3; ?> buku</td></tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><?php echo $judul4; ?></h5>
                        <span class="badge <?php echo $badge_color4; ?>"><?php echo $kategori4; ?></span>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm">
                            <tr><th width="150">Pengarang</th><td>: <?php echo $pengarang4; ?></td></tr>
                            <tr><th>Penerbit</th><td>: <?php echo $penerbit4; ?></td></tr>
                            <tr><th>Tahun Terbit</th><td>: <?php echo $tahun_terbit4; ?></td></tr>
                            <tr><th>ISBN</th><td>: <?php echo $isbn4; ?></td></tr>
                            <tr><th>Bahasa</th><td>: <?php echo $bahasa4; ?></td></tr>
                            <tr><th>Halaman</th><td>: <?php echo $halaman4; ?> hal</td></tr>
                            <tr><th>Berat</th><td>: <?php echo $berat4; ?> gram</td></tr>
                            <tr><th>Harga</th><td>: Rp <?php echo number_format($harga4, 0, ',', '.'); ?></td></tr>
                            <tr><th>Stok</th><td>: <?php echo $stok4; ?> buku</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>