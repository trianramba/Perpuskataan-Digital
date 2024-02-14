<?php
require_once("koneksi.php");


// Query untuk mengambil informasi dari buku tersebut
$sql = "SELECT b.*, GROUP_CONCAT(kb.NamaKategori SEPARATOR ', ') AS Genre, p.StatusPeminjaman
        FROM buku b
        LEFT JOIN kategoribuku_relasi kbr ON b.BukuID = kbr.BukuID
        LEFT JOIN kategoribuku kb ON kbr.KategoriID = kb.KategoriID
        LEFT JOIN peminjaman p ON b.BukuID = p.BukuID AND p.UserID = :UserID
        GROUP BY b.BukuID";
$stmt = $db->prepare($sql);
$stmt->bindParam(':UserID', $_SESSION['user']['UserID']);
$stmt->execute();
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
    <!-- notifikasi pesan berhasil -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    // Fungsi untuk menampilkan notifikasi
    function showNotification(message, type) {
        var notification = document.getElementById('notification');
        notification.innerHTML = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
            message +
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
            '</div>';
    }

    // Fungsi untuk mengirim permintaan AJAX saat tombol pinjam diklik
    function pinjamBuku(BukuID) {
        // Kirim permintaan AJAX
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Tanggapan sukses dari server
                    showNotification(xhr.responseText, 'success');
                } else {
                    // Tanggapan gagal dari server
                    showNotification('Terjadi kesalahan saat memproses permintaan.', 'danger');
                }
            }
        };
        xhr.open('GET', 'pinjam_buku.php?BukuID=' + BukuID, true);
        xhr.send();
    }
    </script>


</head>

<body>
    <div id="notification"></div>
    <!--navbar-->
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">PERPUSTAKAAN ANGGOTA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto ml-2">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="keranjang.php">KERANJANG</a>
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

                        <a href="<?php echo $b['PDF']; ?>" class="btn btn-primary" target="_blank">pinjam</a>
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