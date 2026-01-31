<?php
    #1. Meng-koneksikan PHP ke MySQL
    include("../koneksi.php");

    #2. Mengambil Value dari Form Tambah
    $nama = $_POST['nama'];
    $nisn = $_POST['nisn'];
    $tp_lahir = $_POST['tp_lahir'];
    $tg_lahir = $_POST['tg_lahir'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $jk = $_POST['jk'];
    $jur = $_POST['jur'];
    $gelombang = $_POST['gelombang'];
    $nama_foto = $_FILES['foto']['name'];
    $tmp_foto = $_FILES['foto']['tmp_name'];

    #3. Query Insert (proses tambah data)
    $query = "INSERT INTO biodata (nama,nisn,tp_lahir,tg_lahir,alamat,email,jk,gelombang,jurusans_id,foto) 
    VALUES ('$nama','$nisn','$tp_lahir','$tg_lahir','$alamat','$email','$jk','$gelombang','$jur','$nama_foto')";

    // ensure upload dir exists and move uploaded file
    $uploadDir = __DIR__ . DIRECTORY_SEPARATOR . 'fotosiswa';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    move_uploaded_file($tmp_foto, $uploadDir . DIRECTORY_SEPARATOR . $nama_foto);

    $tambah = mysqli_query($koneksi,$query);

    #4. Jika Berhasil triggernya apa? (optional)
    if($tambah){
        header("location:index.php");
    }else{
        echo "Data Gagal ditambah";
    }
?>