<?php
include("../koneksi.php");

$id = $_GET['id'];
$id_siswa = $_GET['id_siswa']; // Needed for redirection to formedit
$source = isset($_GET['source']) ? $_GET['source'] : 'index';

// 1. Get filename to delete
$qry = "SELECT nama_file FROM galeri_siswa WHERE id='$id'";
$result = mysqli_query($koneksi, $qry);
$data = mysqli_fetch_array($result);
$nama_file = $data['nama_file'];

// 2. Delete file from server
$file_path = "../../upload/foto/" . $nama_file;
if (file_exists($file_path)) {
    unlink($file_path);
}

// 3. Delete record from database
$del_query = "DELETE FROM galeri_siswa WHERE id='$id'";
$hapus = mysqli_query($koneksi, $del_query);

// 4. Redirect
if($source == 'formedit'){
    header("Location: form_edit.php?id=$id_siswa");
} else {
    header("Location: index.php");
}
?>