
<?php
require_once("koneksi.php");


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
     
        $db->beginTransaction();

     
        $sql_delete_relasi = "DELETE FROM kategoribuku_relasi WHERE BukuID = :id";
        $stmt_delete_relasi = $db->prepare($sql_delete_relasi);
        $stmt_delete_relasi->bindParam(':id', $id);
        $stmt_delete_relasi->execute();

        $sql_delete_buku = "DELETE FROM buku WHERE BukuID = :id";
        $stmt_delete_buku = $db->prepare($sql_delete_buku);
        $stmt_delete_buku->bindParam(':id', $id);
        $stmt_delete_buku->execute();

        $db->commit();

        header("Location: admin_home.php");
        exit();
    } catch (PDOException $e) {
        
        $db->rollBack();
        echo "Gagal menghapus buku: " . $e->getMessage();
    }
}
?>

