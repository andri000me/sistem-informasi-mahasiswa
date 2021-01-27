<?php require_once('header.php'); ?>

<?php

// begin connect db
// $host = "localhost";
// $username = "root";
// $password = "";
// $db = "sistem-informasi-mahasiswa";

$connect = mysqli_connect("localhost", "root", "", "sistem_informasi_mahasiswa");

// end connect

// begin show all data
// end show all data

// search
// $keyword = $_GET["keyword"];

if(isset($_POST["submit"])){
    $keyword = isset($_POST["keyword"]) ? htmlspecialchars($_POST["keyword"]) : '';

    $query = "SELECT `mahasiswa`.`id`, `mahasiswa`.`nama`, `mahasiswa`.`tanggal_lahir`, `mahasiswa`.`alamat`, `mahasiswa`.`jenis_kelamin`, `mahasiswa`.`npm`, `jurusan`.`nama_jurusan` FROM `mahasiswa` INNER JOIN jurusan ON `mahasiswa`.`jurusan_id` = `jurusan`.`id` 
    WHERE `mahasiswa`.`nama` LIKE '%$keyword%'
        OR `mahasiswa`.`npm` LIKE '%$keyword%' 
        OR `mahasiswa`.`alamat` LIKE '%$keyword%' 
        OR `jurusan`.`nama_jurusan` LIKE '%$keyword%' 
    ORDER BY `mahasiswa`.`nama`";
    $sql = mysqli_query($connect, $query);
}else{
    $query = "SELECT `mahasiswa`.`id`, `mahasiswa`.`nama`, `mahasiswa`.`tanggal_lahir`, `mahasiswa`.`alamat`, `mahasiswa`.`jenis_kelamin`, `mahasiswa`.`npm`, `jurusan`.`nama_jurusan` FROM `mahasiswa` INNER JOIN jurusan ON `mahasiswa`.`jurusan_id` = `jurusan`.`id` ORDER BY `mahasiswa`.`nama`";
    $sql = mysqli_query($connect, $query);
}



?>

<div class="container pt-5">
    <div class="row justify-content-center">
        <h1>Daftar Mahasiswa</h1>
    </div>
    <div class="row pt-5">
        <div class="col-md-12 d-flex justify-content-between">
            <button class="btn btn-primary"><a href="add.php">Add New</a></button>
            <form method="POST">
                <div class="form-group form-inline">
                    <input type="text" class="form-control" name="keyword" autofocus autocomplete="off">
                    <button class="btn btn-secondary" type="submit" name="submit">Search</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <table class="table table-striped mt-5">
        <thead>
            <tr>
                <th>No</th>
                <th>NPM</th>
                <th>Nama</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
                <th>Jenis Kelamin</th>
                <th>Jurusan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php while($row = mysqli_fetch_assoc($sql)) : ?>
            <tr>
                
                <th scope="row"><?= $no++ ?></th>
                <td><?= $row["npm"] ?></td>
                <td><?= $row["nama"] ?></td>
                <td><?= $row["tanggal_lahir"] ?></td>
                <td><?= $row["alamat"] ?></td>
                <td><?= $row["jenis_kelamin"] ?></td>
                <td><?= $row["nama_jurusan"] ?></td>
                <td>
                    <button class="btn btn-warning"> <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> </button>
                    <button class="btn btn-danger"><a href="delete.php?id=<?= $row['id'] ?>"
                    onclick = "return confirm('Yakin ingin menghapus data?')">Delete</a></button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>




<?php require_once('footer.php'); ?>