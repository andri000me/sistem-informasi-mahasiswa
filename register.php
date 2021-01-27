<?php 

$connect = mysqli_connect("localhost", "root", "", "sistem_informasi_mahasiswa");

// tambah data
if(isset($_POST["submit"])){

    $username = htmlspecialchars($_POST["username"]);
    $nama = htmlspecialchars($_POST["nama"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $password2 = htmlspecialchars($_POST["password2"]);
    
    // cek apakah password sesuai
    if($password != $password2){
        echo "
        <script>
            alert('Password tidak sama');
            document.location.href = 'register.php';
        </script>
    ";
        die;
    }

    // cek apakah username dan email sudah terpakai
    $selectQuery = "SELECT * FROM `user`";
    $selectSql = mysqli_query($connect, $selectQuery);
    
    
    // var_dump($a);

    while($checkDuplicate = mysqli_fetch_assoc($selectSql)){
        if($username == $checkDuplicate["username"]){
            echo "
            <script>
                alert('Username sudah terpakai'); 
                document.location.href = 'register.php';
            </script>";
            return false;
        }elseif($email == $checkDuplicate["email"]){
            echo "<script>alert('Email sudah terpakai'); document.location.href = 'register.php';</script>";
            return false;
        }
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO `user` (`username`, `nama`, `email`, `password`) VALUES (
    '$username', '$nama', '$email', '$password'
    )";

    $sql = mysqli_query($connect, $query);
    
    // cek apakah data masuk
    if(mysqli_affected_rows($connect) > 0){
        echo "
        <script>
            alert('User berhasil ditambahkan');
            document.location.href = 'index.php';
        </script>
        ";
    }

}

?>

<?php require_once('header.php'); ?>

<div class="container pt-5">
    <div class="row justify-content-center">
        <h1>Register</h1>
    </div>
    <div class="row pt-5">
        <div class="col-md-12">
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter Username">
                </div>
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Enter Nama">
                </div>
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter E-mail">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
                </div>
                <div class="form-group">
                    <label for="password2">Konfirmasi Password:</label>
                    <input type="password" class="form-control" name="password2" id="password2" placeholder="Enter Password">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>
    
    