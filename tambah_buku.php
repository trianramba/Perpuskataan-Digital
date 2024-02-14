<?php
require_once("koneksi.php");

// Tangani pengiriman formulir
if (isset($_POST['submit'])) {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $genre_nama = strtolower($_POST['genre']);

    // Tambahkan genre baru ke dalam tabel kategoribuku
    $stmt_add_genre = $db->prepare("INSERT INTO kategoribuku (NamaKategori) VALUES (:genre_nama)");
    $stmt_add_genre->bindParam(':genre_nama', $genre_nama);
    $saved = $stmt_add_genre->execute();

    // Periksa apakah operasi penyimpanan genre berhasil
    if ($saved) {
        // Dapatkan ID genre yang baru saja ditambahkan
        $new_genre_id = $db->lastInsertId();

        // Unggah gambar buku
        $gambar_name = $_FILES['gambar']['name'];
        $gambar_tmp_name = $_FILES['gambar']['tmp_name'];
        $gambar_dest = "uploads/" . $gambar_name;
        move_uploaded_file($gambar_tmp_name, $gambar_dest);

        // Unggah file PDF buku
        $pdf_name = $_FILES['pdf']['name'];
        $pdf_tmp_name = $_FILES['pdf']['tmp_name'];
        $pdf_dest = "uploads/" . $pdf_name;
        move_uploaded_file($pdf_tmp_name, $pdf_dest);

        // Simpan informasi buku ke database
        $sql = "INSERT INTO buku (Judul, Penulis, Penerbit, TahunTerbit, Gambar, PDF)
            VALUES (:judul, :penulis, :penerbit, :tahun_terbit, :gambar, :pdf)";
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':judul', $judul);
        $stmt->bindParam(':penulis', $penulis);
        $stmt->bindParam(':penerbit', $penerbit);
        $stmt->bindParam(':tahun_terbit', $tahun_terbit);
        $stmt->bindParam(':gambar', $gambar_dest);
        $stmt->bindParam(':pdf', $pdf_dest);

        $saved = $stmt->execute();

        // Cek apakah operasi penyimpanan buku berhasil
        if ($saved) {
            // Dapatkan ID buku yang baru saja disimpan
            $new_book_id = $db->lastInsertId();

            // Simpan relasi antara buku dan genre dalam tabel kategoribuku_relasi
            $sql_genre_relasi = "INSERT INTO kategoribuku_relasi (BukuID, KategoriID) VALUES (:buku_id, :genre_id)";
            $stmt_genre_relasi = $db->prepare($sql_genre_relasi);
            $stmt_genre_relasi->bindParam(':buku_id', $new_book_id);
            $stmt_genre_relasi->bindParam(':genre_id', $new_genre_id);
            $stmt_genre_relasi->execute();

            // Redirect setelah berhasil
            header("Location: admin_home.php");
        } else {
            echo "Gagal menambahkan buku.";
        }
    } else {
        echo "Gagal menambahkan genre baru.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link href="bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h1>Tambah Buku</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" required>
            </div>
            <div class="mb-3">
                <label for="penulis" class="form-label">Penulis</label>
                <input type="text" class="form-control" id="penulis" name="penulis" required>
            </div>
            <div class="mb-3">
                <label for="penerbit" class="form-label">Penerbit</label>
                <input type="text" class="form-control" id="penerbit" name="penerbit" required>
            </div>
            <div class="mb-3">
                <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                <input type="text" class="form-control" id="tahun_terbit" name="tahun_terbit" required>
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
                    <option value="Novel">Novel</option>
                    <option value="Pendidikan">Pendidikan</option>
                    <option value="Manga">koran</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
            <a href="admin_home.php" class="link-primary">kembali</a>
        </form>
    </div>

  
</body>

</html>