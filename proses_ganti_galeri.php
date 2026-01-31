<?php
include("../koneksi.php");

$id = $_POST['id'];
$id_siswa = $_POST['id_siswa'];
$keterangan = $_POST['keterangan'];
$source = isset($_POST['source']) ? $_POST['source'] : 'index';

// Check if new file is uploaded
if (!empty($_FILES['foto']['name'])) {
    // 1. Get old filename
    $qry = "SELECT nama_file FROM galeri_siswa WHERE id='$id'";
    $result = mysqli_query($koneksi, $qry);
    $data = mysqli_fetch_array($result);
    $old_file = $data['nama_file'];

    // 2. Delete old file
    $old_file_path = "../../upload/foto/" . $old_file;
    if (file_exists($old_file_path)) {
        unlink($old_file_path);
    }

    // 3. Upload new file
    $nama_file = $_FILES['foto']['name'];
    $tmp_file = $_FILES['foto']['tmp_name'];
    $target_dir = "../../upload/foto/";
    move_uploaded_file($tmp_file, $target_dir . $nama_file);

    // 4. Update database with new filename
    $query = "UPDATE galeri_siswa SET nama_file='$nama_file', keterangan='$keterangan' WHERE id='$id'";

} else {
    // Only update keterangan
    $query = "UPDATE galeri_siswa SET keterangan='$keterangan' WHERE id='$id'";
}

$update = mysqli_query($koneksi, $query);

// Redirect
if($source == 'formedit'){
    header("Location: form_edit.php?id=$id_siswa");
} else {
    header("Location: index.php");
}
?>