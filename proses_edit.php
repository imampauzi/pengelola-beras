<?php
include 'db.php';

$id      = $_POST['id'];
$nama    = $_POST['nama'];
$jenis   = $_POST['jenis'];
$tanggal = $_POST['tanggal'];
$progres = $_POST['progres'];

$sql = "UPDATE pengiriman_beras SET 
            nama = '$nama',
            jenis = '$jenis',
            tanggal = '$tanggal',
            progres = '$progres'
        WHERE id = $id";

if ($koneksi->query($sql)) {
    header("Location: form_input.php"); // kembali ke halaman utama
} else {
    echo "Gagal mengupdate data: " . $koneksi->error;
}
?>
