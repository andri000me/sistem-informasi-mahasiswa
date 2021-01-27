<?php 

$connect = mysqli_connect("localhost", "root", "", "sistem_informasi_mahasiswa");

$id = $_GET["id"];

$query = "DELETE FROM `mahasiswa` WHERE `id` = $id";

$sql = mysqli_query($connect, $query);

if(mysqli_affected_rows($connect) > 0){
    echo "
        <script>
            alert('data berhasil dihapus');
            document.location.href = 'daftar-mahasiswa.php';
        </script>
    ";
}

?>