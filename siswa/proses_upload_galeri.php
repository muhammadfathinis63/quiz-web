<?php
include("../koneksi.php");

$id_siswa = $_POST['id_siswa'];
$keterangan = $_POST['keterangan'];

// File upload handling
$nama_file = $_FILES['foto']['name'];
$tmp_file = $_FILES['foto']['tmp_name'];
$target_dir = "../../upload/foto/";
$target_file = $target_dir . basename($nama_file);

// Simple validation (can be expanded)
if ($nama_file) {
    if (move_uploaded_file($tmp_file, $target_file)) {
        // Insert into database
        $query = "INSERT INTO galeri_siswa (id_siswa, nama_file, keterangan) VALUES ('$id_siswa', '$nama_file', '$keterangan')";
        if (mysqli_query($koneksi, $query)) {
            header("Location: index.php");
        } else {
            echo "Error database: " . mysqli_error($koneksi);
        }
    } else {
        echo "Error uploading file.";
    }
} else {
    echo "No file selected.";
}
?>