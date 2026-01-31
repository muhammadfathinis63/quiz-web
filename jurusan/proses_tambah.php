<?php
    #1. Meng-koneksikan PHP ke MySQL
    include("../koneksi.php");

    #2. Mengambil Value dari Form Tambah
    $kode_jurusan = $_POST['kode_jurusan'];
    $nama_jurusan = $_POST['nama_jurusan'];

    #3. Query Insert (proses tambah data)
    $query = "INSERT INTO jurusan (kode_jurusan,nama_jurusan) 
    VALUES ('$kode_jurusan','$nama_jurusan')";

    $tambah = mysqli_query(mysql: $koneksi,query: $query);

    #4. Jika Berhasil triggernya apa? (optional)
    if($tambah){
        header(header: "location:index.php");
    }else{
        echo "Data Gagal ditambah";
    }
?>