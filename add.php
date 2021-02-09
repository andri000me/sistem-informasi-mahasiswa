<?php session_start(); ?>
<?php 

$connect = mysqli_connect("localhost", "root", "", "sistem_informasi_mahasiswa");

$query = "SELECT * FROM jurusan";

$sql = mysqli_query($connect, $query);


// tambah data
if(isset($_POST["submit"])){

    $npm = htmlspecialchars($_POST["npm"]);
    $nama = htmlspecialchars($_POST["nama"]);
    $tanggal_lahir = htmlspecialchars($_POST["tanggal_lahir"]);
    $alamat = htmlspecialchars($_POST["alamat"]);
    $jenis_kelamin = htmlspecialchars($_POST["jenis_kelamin"]);
    $jurusan = htmlspecialchars($_POST["jurusan_id"]);

    $insertQuery = "INSERT INTO `mahasiswa` (`nama`, `tanggal_lahir`, `alamat`, `jenis_kelamin`, `jurusan_id`, `npm` ) VALUES (
        '$nama', '$tanggal_lahir', '$alamat', '$jenis_kelamin', $jurusan, $npm
    )";

    $insertSql = mysqli_query($connect, $insertQuery);

    // cek apakah data masuk
    if(mysqli_affected_rows($connect) > 0){
        echo "
        <script>
            alert('data berhasil ditambahkan');
            document.location.href = 'daftar-mahasiswa.php';
        </script>
    ";
    }
}

?>

<?php 
    if(!isset($_SESSION["login"])){
        echo "
            <script>
                alert('Login terlebih dahulu'); 
                document.location.href = 'login.php';
            </script>";
    }
?>

<?php require_once('header.php'); ?>

<div class="container pt-5">
    <div class="row justify-content-center">
        <h1>Tambah Mahasiswa</h1>
    </div>
    <div class="row pt-5">
        <div class="col-md-12">
            <form method="POST">
                <div class="form-group">
                    <label for="npm">NPM:</label>
                    <input required type="text" class="form-control" name="npm" id="npm" placeholder="Enter NPM">
                </div>
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input required type="text" class="form-control" name="nama" id="nama" placeholder="Enter Nama">
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir:</label>
                    <input required type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <textarea class="form-control" name="alamat" id="alamat" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin:</label>
                    <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="jurusan">Jurusan:</label>
                    <select class="form-control" name="jurusan_id" id="jurusan">
                        <?php while ($row = mysqli_fetch_assoc($sql)) : ?>
                        <option value="<?= $row["id"] ?>"><?= $row["nama_jurusan"] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>
    
    