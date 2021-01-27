<?php session_start(); ?>
<?php require_once('header.php'); ?>

<?php

$connect = mysqli_connect("localhost", "root", "", "sistem_informasi_mahasiswa");

if(!isset($_SESSION["login"])){
    echo "
        <script>
            alert('Login terlebih dahulu'); 
            document.location.href = 'login.php';
        </script>";
    exit;
}

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

    // pagination
$batas = 10;
$halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;
$previous = $halaman - 1;
$next = $halaman + 1;

$jumlah_data = mysqli_num_rows($sql);
$total_halaman = ceil($jumlah_data / $batas);

$dataMhs = mysqli_query($connect, "SELECT `mahasiswa`.`id`, `mahasiswa`.`nama`, `mahasiswa`.`tanggal_lahir`, `mahasiswa`.`alamat`, `mahasiswa`.`jenis_kelamin`, `mahasiswa`.`npm`, `jurusan`.`nama_jurusan` FROM `mahasiswa` INNER JOIN jurusan ON `mahasiswa`.`jurusan_id` = `jurusan`.`id` ORDER BY `mahasiswa`.`nama` LIMIT $halaman_awal, $batas");

$no = $halaman_awal+1;
}


?>

<div class="container pt-5">
    <div class="row justify-content-end">
        <p>Halo, <?= $_SESSION["welcome"]; ?></p>
        <a href="logout.php" style="color: orangered;"> &nbsp;Logout</a>
    </div>
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
            <?php while($row = mysqli_fetch_assoc($dataMhs)) : ?>
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

    <nav>
			<ul class="pagination justify-content-center">
				<li class="page-item">
					<a style="color: blue" class="page-link" <?php if($halaman > 1){ echo "href='?halaman=$previous'"; } ?>>Previous</a>
				</li>
				<?php 
				for($x=1;$x<=$total_halaman;$x++){
					?> 
					<li class="page-item"><a style="color: blue" class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
					<?php
				}
				?>				
				<li class="page-item">
					<a style="color: blue"  class="page-link" <?php if($halaman < $total_halaman) { echo "href='?halaman=$next'"; } ?>>Next</a>
				</li>
			</ul>
		</nav>
    </div>
</div>

<?php require_once('footer.php'); ?>