<?php
include 'db.php';

// Escape input
$nama = $_POST['nama'];
$jenis_kelamin = $_POST['jenis_kelamin']; // ambil dari form
$jenis = $_POST['jenis'];
$tanggal = $_POST['tanggal'];
$progres = $_POST['progres'];

$sql = "INSERT INTO pengiriman_beras (nama, jenis_kelamin, jenis, tanggal, progres)
        VALUES ('$nama', '$jenis_kelamin', '$jenis', '$tanggal', '$progres')";


if ($koneksi->query($sql)) {
    header("Location: index.php");
    exit();
} else {
    echo "Gagal menyimpan: " . $koneksi->error;
}
?>
