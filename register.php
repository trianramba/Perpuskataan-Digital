<?php

require_once("koneksi.php");

if (isset($_POST['register'])) {
    // filter data that is entered
    $username = filter_input(INPUT_POST, 'Username', FILTER_SANITIZE_STRING);
    $password = password_hash(strip_tags($_POST["password"]), PASSWORD_DEFAULT); 
    $email = filter_input(INPUT_POST, 'Email', FILTER_VALIDATE_EMAIL);
    $namelengkap = filter_input(INPUT_POST, 'NamaLengkap', FILTER_SANITIZE_STRING);
    $alamat = filter_input(INPUT_POST, 'Alamat', FILTER_SANITIZE_STRING);

    $sql = "INSERT INTO user (Username, password, Email, NamaLengkap, Alamat) 
    VALUES (:Username, :password, :Email, :NamaLengkap, :Alamat)";
        $stmt = $db->prepare($sql);

        $params = array(
        ":Username" => $username,
        ":password" => $password, // Change to lowercase "password"
        ":Email" => $email,
        ":NamaLengkap" => $namelengkap,
        ":Alamat" => $alamat
        );


    $saved = $stmt->execute($params);

    if ($saved) {
        header("Location: index.php");
    } else {
        echo "Registration failed.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <!--narbar-->
    <nav class="navbar navbar-light bg-primary navbar-center">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PERPUSTAKAAN SMK TAGARI</a>
        </div>
    </nav>

    <!--akhir navabar-->

    <!--content-->
    <div class="full-container">
        <div class="card latar-login">
            <div class="card-text">
                <h1>R E G I S T E R</h1>
                <form action="" method="POST">
                    <form class="row g-3">
                        <div class="col-12">
                            <label for="Username" class="form-label">username</label>
                            <input type="text" class="form-control" id="inputAddress" name="Username"
                                placeholder="username" />
                        </div>
                        <div class="col-md-6">
                            <label for="Password" class="form-label">Password</label>
                            <input type="Password" class="form-control" id="inputPassword4" name="password"
                                placeholder=".........." />
                        </div>

                        <div class="col-md-6">
                            <label for="Email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="inputEmail4" name="Email"
                                placeholder="exsample@gmail.com" />
                        </div>


                        <div class="col-12">
                            <label for="NamaLengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="inputAddress2" name="NamaLengkap"
                                placeholder="Nama lengkap" />
                        </div>
                        <div class="col-md-6">
                            <label for="Alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="inputCity" name="Alamat"
                                placeholder="alamat domisili" />
                        </div>


                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" name="register">Sign in</button>
                            <a href="index.php" class="link-primary">kembali</a>
                        </div>
                    </form>
                </form>
            </div>
        </div>
    </div>
    <!--akhir content-->
</body>

</html>