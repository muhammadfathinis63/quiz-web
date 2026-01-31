<?php
    #1. Meng-koneksikan PHP ke MySQL
    include("../koneksi.php");

    #2. Mengambil Value dari Form Tambah
    $id = $_POST['id'];
    $kode = $_POST['kode'];
    $gelombang = $_POST['gelombang'];

    
    #3. Query Insert (proses edit data)
    $query = "UPDATE gelombang SET kode='$kode', gelombang='$gelombang' 
    WHERE id='$id'";

    $tambah = mysqli_query($koneksi,$query);

    #4. Jika Berhasil triggernya apa? (optional)
    if($tambah){
        header("location:index.php");
    }else{
        echo "Data Gagal ditambah";
    }
?>