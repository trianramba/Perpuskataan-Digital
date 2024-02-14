<?php
require_once("koneksi.php");


$sql = "SELECT b.*, GROUP_CONCAT(kb.NamaKategori SEPARATOR ', ') AS Genre
        FROM buku b
        LEFT JOIN kategoribuku_relasi kbr ON b.BukuID = kbr.BukuID
        LEFT JOIN kategoribuku kb ON kbr.KategoriID = kb.KategoriID
        GROUP BY b.BukuID";
$stmt = $db->query($sql);
$buku = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <title>HOME PEMINJAM</title>
</head>

<body>
    <!--navbar-->
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">PERPUSTAKAAN ADMIN</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto ml-2">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">HOME </a>
                    </li>
                   
                    <li class="nav-item">
                        <a class="nav-link" href="register_admin.php">REGISTER ADMIN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tambah_buku.php">TAMBAH BUKU </a>
                    </li>



                    <li class="nav-item">
                        <a class="nav-link" href="#">GENRE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">KELUAR</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!--content-->
    <div id="container-peminjam" class="container mt-3">
        <div class="row">
            <?php foreach ($buku as $b) : ?>
            <div class="col-sm-6">
                <div class="card mb-4">
                    <img src="<?php echo $b['Gambar']; ?>" class="card-img-top" alt="Gambar Buku">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $b['Judul']; ?></h5>
                        <p class="card-text">Penulis: <?php echo $b['Penulis']; ?></p>
                        <p class="card-text">Penerbit: <?php echo $b['Penerbit']; ?></p>
                        <p class="card-text">Tahun Terbit: <?php echo $b['TahunTerbit']; ?></p>
                        <p class="card-text">Genre: <?php echo $b['Genre']; ?></p>
                        <a href="<?php echo $b['PDF']; ?>" class="btn btn-primary" target="_blank">baca</a>

                     
                        <a href="hapus_buku.php?id=<?php echo $b['BukuID']; ?>" class="btn btn-danger">Hapus</a>

                        <a href="edit_buku.php?id=<?php echo $b['BukuID']; ?>" class="btn btn-warning">Edit</a>

                    </div>

                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>



    <!--akhir content-->

    <!-- Bootstrap JavaScript (Popper.js and Bootstrap.js) -->
    <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>