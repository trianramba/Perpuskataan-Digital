<?php
require_once("koneksi.php");

if (isset($_POST['login'])) {
    $username = filter_input(INPUT_POST, 'Username', FILTER_SANITIZE_STRING);
    $password = strip_tags($_POST["password"]);

    $sql = "SELECT * FROM user WHERE Username=:Username OR Email=:Email";
    $stmt = $db->prepare($sql);

    $params = array(
        "Username" => $username,
        "Email" => $username
    );

    $stmt->execute($params);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $hashedPassword = $user["password"];
        if (password_verify($password, $hashedPassword)) {
            session_start();
            $_SESSION["user"] = $user;

            if ($user['Role'] == 'administrator') {
                header("location:admin_home.php");
            } elseif ($user['Role'] == 'petugas') {
                header("location:petugas_home.php");
            } elseif ($user['Role'] == 'peminjam') {
                header("location:peminjam_home.php");
            }

            exit();
        } else {
            $error_message = "Password salah. Silakan coba lagi.";
        }
    } else {
        $error_message = "Email atau username tidak ditemukan.";
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
                <h1>L O G I N</h1>
                <?php if (isset($error_message)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
                <?php endif; ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="Username"
                            placeholder="email atau username anda!" aria-describedby="emailHelp" />
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="........"
                            id="exampleInputPassword1" />
                    </div>

                    <button type="submit" class="btn btn-primary" name="login">Gas login</button>
                    <a href="register.php" class="link-primary">tidak punya akunnya?</a>
                </form>
            </div>
        </div>
    </div>
    <!--akhir content-->
</body>

</html>