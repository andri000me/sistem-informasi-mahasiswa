<?php 
session_start();

$connect = mysqli_connect("localhost", "root", "", "sistem_informasi_mahasiswa");

if(isset($_SESSION["login"])){
    echo "
        <script>
            document.location.href = 'daftar-mahasiswa.php';
        </script>";
}

// tambah data
if(isset($_POST["submit"])){

    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);

    // cek apakah username dan email sudah terpakai
    $selectQuery = "SELECT * FROM `user` WHERE `username` = '$username'";
    $selectSql = mysqli_query($connect, $selectQuery);


    // enkripsi password
    $credentials = mysqli_fetch_assoc($selectSql);
    
    if($username == $credentials["username"] && password_verify($password, $credentials["password"])){
        $_SESSION["login"] = true;
        $_SESSION["welcome"] = $credentials["username"];
        echo "
        <script>
            alert('Berhasil login'); 
            document.location.href = 'daftar-mahasiswa.php';
        </script>";
    }else{
        echo "<script>alert('Username atau password salah'); document.location.href = 'loginphp';</script>";
    }
}

?>

<?php require_once('header.php'); ?>

<div class="container pt-5">
    <div class="row justify-content-center">
        <h1>Login</h1>
    </div>
    <div class="row pt-5">
        <div class="col-md-12">
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter Username">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
                </div>
                <a href="register.php" style="color: orangered">Register</a><br>
                <button type="submit" name="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>
    
    