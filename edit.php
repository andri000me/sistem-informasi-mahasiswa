<?php 

$connect = mysqli_connect("localhost", "root", "", "sistem_informasi_mahasiswa");

$id = $_GET["id"];

$query = "SELECT * FROM mahasiswa WHERE `id` = $id";

$queryJurusan = "SELECT * FROM jurusan";

$sql = mysqli_query($connect, $query);
$sqlJurusan = mysqli_query($connect, $queryJurusan);

$row = mysqli_fetch_assoc($sql);

// UPDATE
if(isset($_POST)){
    $npm = isset($_POST["npm"]) ? htmlspecialchars($_POST["npm"]) : '';
    $nama = isset($_POST["nama"]) ? htmlspecialchars($_POST["nama"]) : '';
    $tanggal_lahir = isset($_POST["tanggal_lahir"]) ? htmlspecialchars($_POST["tanggal_lahir"]) : '';
    $alamat = isset($_POST["alamat"]) ? htmlspecialchars($_POST["alamat"]) : '';
    $jenis_kelamin = isset($_POST["jenis_kelamin"]) ? htmlspecialchars($_POST["jenis_kelamin"]) : '';
    $jurusan = isset($_POST["jurusan_id"]) ? htmlspecialchars($_POST["jurusan_id"]) : '';

    $updateQuery = "UPDATE `mahasiswa` SET `nama` = '$nama', `tanggal_lahir` = '$tanggal_lahir', `alamat` = '$alamat', `jenis_kelamin` = '$jenis_kelamin', `jurusan_id` = $jurusan, `npm` = '$npm' WHERE `id` = $id";

    $updateSql = mysqli_query($connect, $updateQuery);

    if(mysqli_affected_rows($connect) > 0){
        echo "
        <script>
            alert('data berhasil diupdate');
            document.location.href = 'daftar-mahasiswa.php';
        </script>
    ";
    }
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
                    <input required value="<?= $row['npm']; ?>" type="text" class="form-control" name="npm" id="npm" placeholder="Enter NPM">
                </div>
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input required value="<?= $row['nama']; ?>" type="text" class="form-control" name="nama" id="nama" placeholder="Enter Nama">
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir:</label>
                    <input required value="<?= $row['tanggal_lahir']; ?>" type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <textarea class="form-control" name="alamat" id="alamat" rows="3"><?= $row['alamat']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin:</label>
                    <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                        <option value="Laki-laki" 
                        <?php if($row['jenis_kelamin'] == 'Laki-laki') { echo 'selected';} ?>>
                        Laki-laki</option>
                        <option value="Perempuan"
                        <?php if($row['jenis_kelamin'] == 'Perempuan') { echo 'selected';} ?>>
                        Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="jurusan">Jurusan:</label>
                    <select class="form-control" name="jurusan_id" id="jurusan">
                        <?php while ($rowJurusan = mysqli_fetch_assoc($sqlJurusan)) : ?>
                        <?php 
                            // untuk menentukan selected
                            $jurusanMahasiswa = $row["jurusan_id"]; 
                            $jurusanDb = $rowJurusan["id"];

                        ?>
                        <option value="<?= $rowJurusan["id"] ?>" <?php if($jurusanMahasiswa == $jurusanDb){ echo 'selected'; } ?>><?= $rowJurusan["nama_jurusan"] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>
    
    