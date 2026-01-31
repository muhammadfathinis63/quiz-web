<?php
include_once("../koneksi.php");
$idedit = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($idedit <= 0) {
    header('Location: index.php?msg=' . urlencode('ID tidak valid')); exit;
}
$stmt = mysqli_prepare($koneksi, "SELECT * FROM biodata WHERE id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, 'i', $idedit);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (!$result || mysqli_num_rows($result) === 0) {
    mysqli_stmt_close($stmt);
    header('Location: index.php?msg=' . urlencode('Data tidak ditemukan')); exit;
}
$data = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body style="background-color:#d1e6d4">
    <?php
    include_once("../navbar.php");
    ?>

    <div class="container">
        <div class="row my-5">
            <div class="col-8 m-auto">
                <div class="card shadow p-3 mb-5 bg-body-tertiary rounded">
                    <div class="card-header">
                        <b>FORM EDIT BIODATA SISWA</b>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($_GET['msg'])): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['msg']); ?></div>
                        <?php endif; ?>
                        <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?=$data['id']?>">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Nama Lengkap</label>
                                <input value="<?=$data['nama']?>" name="nama" type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">NISN</label>
                                <input value="<?=$data['nisn']?>" name="nisn" type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Tempat Lahir</label>
                                <input value="<?=$data['tp_lahir']?>" name="tp_lahir" type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                                <input value="<?=$data['tg_lahir']?>" name="tg_lahir" type="date" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Alamat</label>
                                <input value="<?=$data['alamat']?>" name="alamat" type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email</label>
                                <input value="<?=$data['email']?>" name="email" type="email" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jk" <?php echo $data['jk']=='Laki-laki' ? 'checked' : '' ?>
                                        id="inlineRadio1" value="Laki-laki">
                                    <label class="form-check-label" for="inlineRadio1">Laki-Laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jk" <?php echo $data['jk']=='Perempuan' ? 'checked' : '' ?>
                                        id="inlineRadio2" value="Perempuan">
                                    <label class="form-check-label" for="inlineRadio2">Perempuan</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Jurusan</label>
                                <select class="form-control" name="jur" id="">
                                    <option value="">-Pilih Jurusan-</option>
                                    <?php 
                                        include_once('../koneksi.php');
                                        $qry_jur = "SELECT * FROM jurusan";
                                        $data_jur = mysqli_query($koneksi,$qry_jur);
                                        foreach($data_jur as $item_jur){
                                    ?>
                                    <option value="<?=$item_jur['id']?>" <?php echo $data['jurusans_id']==$item_jur['id'] ? 'selected' : '' ?>><?=$item_jur['kode_jurusan']?> - <?=$item_jur['nama_jurusan']?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Gelombang</label>
                                <select class="form-control" name="gelombang" id="">
                                    <option value="">-Pilih Gelombang-</option>
                                    <?php 
                                        $qry_gel = "SELECT * FROM gelombang";
                                        $data_gel = mysqli_query($koneksi,$qry_gel);
                                        foreach($data_gel as $item_gel){
                                    ?>
                                    <option value="<?=$item_gel['id']?>" <?php echo $data['gelombang']==$item_gel['id'] ? 'selected' : '' ?>><?=$item_gel['kode']?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Foto</label>
                                <?php if (!empty($data['foto'])) { ?>
                                <div class="mb-2">
                                    <img src="fotosiswa/<?=$data['foto']?>" alt="Foto Profil" class="img-thumbnail" style="max-width: 150px;">
                                </div>
                                <?php } ?>
                                <input name="foto" accept="image/*" type="file" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>