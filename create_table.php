<?php
include("../koneksi.php");

$query = "CREATE TABLE IF NOT EXISTS galeri_siswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_siswa INT NOT NULL,
    nama_file VARCHAR(255) NOT NULL,
    keterangan TEXT,
    FOREIGN KEY (id_siswa) REFERENCES biodata(id) ON DELETE CASCADE
)";

if (mysqli_query($koneksi, $query)) {
    echo "Table 'galeri_siswa' created successfully.";
} else {
    echo "Error creating table: " . mysqli_error($koneksi);
}
?>