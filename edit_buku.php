<?php
require_once("koneksi.php");


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    //
    $sql = "SELECT * FROM buku WHERE BukuID = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $buku = $stmt->fetch(PDO::FETCH_ASSOC);

   
    if ($buku) {
        $judul = $buku['Judul'];
        $penulis = $buku['Penulis'];
        $penerbit = $buku['Penerbit'];
        $tahun_terbit = $buku['TahunTerbit'];
    } else {
        
        echo "Buku tidak ditemukan.";
        exit();
    }
} else {
    
    echo "ID buku tidak disertakan.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <link href="bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Edit Buku</h1>
        <form action="proses_edit_buku.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $judul; ?>" required>
            </div>
            <div class="mb-3">
                <label for="penulis" class="form-label">Penulis</label>
                <input type="text" class="form-control" id="penulis" name="penulis" value="<?php echo $penulis; ?>"
                    required>
            </div>
            <div class="mb-3">
                <label for="penerbit" class="form-label">Penerbit</label>
                <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?php echo $penerbit; ?>"
                    required>
            </div>
            <div class="mb-3">
                <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                <input type="text" class="form-control" id="tahun_terbit" name="tahun_terbit"
                    value="<?php echo $tahun_terbit; ?>" required>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Buku</label>
                <input type="file" class="form-control" id="gambar" name="gambar" required>
            </div>
            <div class="mb-3">
                <label for="pdf" class="form-label">File PDF Buku</label>
                <input type="file" class="form-control" id="pdf" name="pdf" required>
            </div>
           
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <select id="genre" class="form-select" name="genre">
                    <?php
                    $stmt_genre = $db->query("SELECT * FROM kategoribuku");
                    $genres = $stmt_genre->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($genres as $genre) {
                        echo "<option value='{$genre['KategoriID']}'>{$genre['NamaKategori']}</option>";
                    }
                    ?>
                </select>
            </div>


            <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
            <a href="admin_home.php" class="link-primary">Kembali</a>
        </form>
    </div>

    <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>