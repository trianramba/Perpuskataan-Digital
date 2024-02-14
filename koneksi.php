<?php
$host="localhost";
$username="root";
$password="";
$dbname="perpustakaan";


$conn = mysqli_connect($host,$username,$password, $dbname);
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

} catch (PDOException $e) {
    die("terjadi masalah:". $e->getMessage());
}

?>