<?php
    #1. Meng-koneksikan PHP ke MySQL
    include("../koneksi.php");

    #2. Mengambil Value dari Form Edit
    $id = (int)($_POST['id'] ?? 0);
    $nama = trim($_POST['nama'] ?? '');
    $nisn = trim($_POST['nisn'] ?? '');
    $tp_lahir = trim($_POST['tp_lahir'] ?? '');
    $tg_lahir = trim($_POST['tg_lahir'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $jk = trim($_POST['jk'] ?? '');
    $jur = (int)($_POST['jur'] ?? 0);
    $gelombang = (int)($_POST['gelombang'] ?? 0);

    // get current foto name
    $curFoto = null;
    $stmt0 = mysqli_prepare($koneksi, "SELECT foto FROM biodata WHERE id = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt0, 'i', $id);
    mysqli_stmt_execute($stmt0);
    mysqli_stmt_bind_result($stmt0, $curFoto);
    mysqli_stmt_fetch($stmt0);
    mysqli_stmt_close($stmt0);

    // basic validation
    if ($id <= 0) {
        header('Location: form_edit.php?msg=' . urlencode('ID tidak valid')); exit;
    }
    if ($nama === '') {
        header('Location: form_edit.php?id=' . $id . '&msg=' . urlencode('Nama tidak boleh kosong')); exit;
    }

    // handle new foto upload (replace if provided) with checks
    $fotoName = $curFoto;
    if (!empty($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        if ($_FILES['foto']['size'] > 2 * 1024 * 1024) {
            header('Location: form_edit.php?id=' . $id . '&msg=' . urlencode('Ukuran foto maksimal 2 MB')); exit;
        }
        $allowed = ['image/jpeg','image/png','image/gif'];
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($_FILES['foto']['tmp_name']);
        if (in_array($mime, $allowed)) {
            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $safe = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
            $uploadDir = __DIR__ . DIRECTORY_SEPARATOR . 'fotosiswa';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . DIRECTORY_SEPARATOR . $safe)) {
                // delete old foto
                if (!empty($curFoto) && file_exists($uploadDir . DIRECTORY_SEPARATOR . $curFoto)) {
                    @unlink($uploadDir . DIRECTORY_SEPARATOR . $curFoto);
                }
                $fotoName = $safe;
            } else {
                header('Location: form_edit.php?id=' . $id . '&msg=' . urlencode('Gagal menyimpan foto')); exit;
            }
        } else {
            header('Location: form_edit.php?id=' . $id . '&msg=' . urlencode('Tipe foto tidak diizinkan')); exit;
        }
    }

    #3. Prepared statement Update
    $stmt = mysqli_prepare($koneksi, "UPDATE biodata SET nama=?, nisn=?, tp_lahir=?, tg_lahir=?, alamat=?, email=?, jk=?, gelombang=?, jurusans_id=?, foto=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'sssssssiisi', $nama, $nisn, $tp_lahir, $tg_lahir, $alamat, $email, $jk, $gelombang, $jur, $fotoName, $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if($ok){
        header("location:index.php?msg=" . urlencode('Data berhasil diupdate'));
    }else{
        header('Location: form_edit.php?id=' . $id . '&msg=' . urlencode('Data gagal diupdate'));
    }
?>