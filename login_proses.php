<?php
session_start();
include 'db.php';

$username = $_POST['username'];
$password = md5($_POST['password']); // Sesuai dengan enkripsi di database

$sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
$result = $koneksi->query($sql);

if ($result->num_rows > 0) {
    $_SESSION['admin'] = $username;
    header("Location: menu_admin.php"); // halaman setelah login
} else {
    echo "<script>alert('Login gagal!'); window.location='login.php';</script>";
}
?>
