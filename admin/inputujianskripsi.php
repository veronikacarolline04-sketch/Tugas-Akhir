<!DOCTYPE html>
<html lang="en">

<?php 
include("bagiankode/head.php");
ob_start();
session_start();
if (!isset($_SESSION['useremail']))
    header("location:login.php");
?>

<body class="sb-nav-fixed">
<?php include("bagiankode/menunav.php"); ?>

<div id="layoutSidenav">
    <?php include("bagiankode/menu.php"); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">

                    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css">

                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">
                </head>

                <body>

<?php
include("includes/config.php");

/* --------------------------- SIMPAN DATA ---------------------------- */

if (isset($_POST["Simpan"])) {
    $mhs_NPM = $_POST["npmMHS"];
    $ujian_TANGGAL = $_POST["tanggalUJIAN"];
    $ujian_WAKTU = $_POST["waktuUJIAN"];
    $peserta_JUDUL = $_POST["judulPESERTA"];
    $ujian_FOTO = $_FILES["fotoUJIAN"]["name"];
    $tmp = $_FILES["fotoUJIAN"]["tmp_name"];

    $tipe = pathinfo($ujian_FOTO, PATHINFO_EXTENSION);
    $ukuran = $_FILES["fotoUJIAN"]["size"];

    if ($ukuran <= 500000 && ($tipe == "jpg" || $tipe == "JPG")) {
        move_uploaded_file($tmp, "images/" . $ujian_FOTO);

        mysqli_query($conn,"
            INSERT INTO ujianskripsi 
            (mhs_NPM, ujian_TANGGAL, ujian_WAKTU, peserta_JUDUL, ujian_FOTO)
            VALUES ('$mhs_NPM', '$ujian_TANGGAL', '$ujian_WAKTU', '$peserta_JUDUL', '$ujian_FOTO')
        ");
    }

    header("location:inputujianskripsi.php");
}

/* --------------------------- QUERY DATA (JOIN LENGKAP) ---------------------------- */

if (isset($_POST["kirim"])) {
    $search = $_POST["search"];
    $query = mysqli_query($conn, "
        SELECT 
    ujianskripsi.*, 
    mahasiswa.mhs_Nama, 
    dosen.dosen_Nama, 
    dosen.dosen_NIDN,
    pesertaskripsi.peserta_JUDUL
FROM ujianskripsi
JOIN mahasiswa ON mahasiswa.mhs_NPM = ujianskripsi.mhs_NPM
JOIN bimbinganskripsi ON bimbinganskripsi.mhs_NPM = ujianskripsi.mhs_NPM
JOIN dosen ON dosen.dosen_NIDN = bimbinganskripsi.dosen_NIDN
JOIN pesertaskripsi ON pesertaskripsi.mhs_NPM = ujianskripsi.mhs_NPM
WHERE ujianskripsi.mhs_NPM LIKE '%$search%'
    ");
} else {
    $query = mysqli_query($conn, "
        SELECT 
    ujianskripsi.*, 
    mahasiswa.mhs_Nama, 
    dosen.dosen_Nama, 
    dosen.dosen_NIDN,
    pesertaskripsi.peserta_JUDUL
FROM ujianskripsi
JOIN mahasiswa ON mahasiswa.mhs_NPM = ujianskripsi.mhs_NPM
JOIN bimbinganskripsi ON bimbinganskripsi.mhs_NPM = ujianskripsi.mhs_NPM
JOIN dosen ON dosen.dosen_NIDN = bimbinganskripsi.dosen_NIDN
JOIN pesertaskripsi ON pesertaskripsi.mhs_NPM = ujianskripsi.mhs_NPM
    ");
}

/* ---------------------- DATA DROPDOWN NPM ---------------------- */

$databimbing = mysqli_query($conn, "
    SELECT bimbinganskripsi.*, mahasiswa.mhs_Nama, dosen.dosen_Nama
    FROM bimbinganskripsi
    JOIN mahasiswa ON mahasiswa.mhs_NPM = bimbinganskripsi.mhs_NPM
    JOIN dosen ON dosen.dosen_NIDN = bimbinganskripsi.dosen_NIDN
    JOIN pesertaskripsi ON pesertaskripsi.mhs_NPM = bimbinganskripsi.mhs_NPM
");
?>

<div class="row">
    <div class="col-1"></div>
    <div class="col-10">

        <form method="POST" enctype="multipart/form-data">

            <div class="row mb-3 mt-5">
                <label class="col-sm-2 col-form-label">NPM Mahasiswa</label>
                <div class="col-sm-10">
                    <select class="form-control" name="npmMHS" required>
                        <option value="">Pilih Mahasiswa</option>
                        <?php while ($row = mysqli_fetch_array($databimbing)) { ?>
                            <option value="<?= $row["mhs_NPM"] ?>">
                                <?= $row["mhs_NPM"] ?> - <?= $row["mhs_Nama"] ?> (<?= $row["dosen_Nama"] ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3 mt-3">
                <label class="col-sm-2 col-form-label">Tanggal Ujian</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="tanggalUJIAN" required>
                </div>
            </div>

            <div class="row mb-3 mt-3">
                <label class="col-sm-2 col-form-label">Waktu Ujian</label>
                <div class="col-sm-10">
                    <input type="time" class="form-control" name="waktuUJIAN" required>
                </div>
            </div>

            <div class="row mb-3 mt-3">
                <label class="col-sm-2 col-form-label">Unggah Foto Ujian</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" name="fotoUJIAN" required>
                    <p class="help-block">File JPG maks 500 KB</p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="col-2"></div>
                <div class="col-10">
                    <input type="submit" class="btn btn-success" value="Simpan" name="Simpan">
                    <input type="reset" class="btn btn-danger" value="Batal">
                </div>
            </div>

        </form>

    </div>
</div>

<div class="row">
    <div class="col-1"></div>
    <div class="col-10">

        <div class="jumbotron mt-5 mb-3">
            <h1 class="display-5">Daftar Ujian Skripsi</h1>
        </div>

        <form method="POST">
            <div class="form-group-row row mb-3 mt-3">
                <label class="col-sm-2">Cari NPM Mahasiswa</label>
                <div class="col-sm-6">
                    <input type="text" name="search" class="form-control" 
                    placeholder="Cari NPM"
                    value="<?php if (isset($_POST["search"])) echo $_POST["search"]; ?>">
                </div>
                <input type="submit" name="kirim" value="Cari" class="col-sm-1 btn btn-primary">
            </div>
        </form>

        <table class="table table-success table-striped table-hover">
            <tr>
                <th>NPM</th>
                <th>Nama Mahasiswa</th>
                <th>NIDN</th>
                <th>Nama Pembimbing</th>
                <th>Tanggal Ujian</th>
                <th>Waktu Ujian</th>
                <th>Judul Skripsi</th>
                <th>Foto Ujian</th>
                <th colspan="2" style="text-align:center;">Aksi</th>
            </tr>

            <?php while ($row = mysqli_fetch_array($query)) { ?>
                <tr>
                    <td><?= $row["mhs_NPM"]; ?></td>
                    <td><?= $row["mhs_Nama"]; ?></td>
                    <td><?= $row["dosen_NIDN"]; ?></td>
                    <td><?= $row["dosen_Nama"]; ?></td>
                    <td><?= $row["ujian_TANGGAL"]; ?></td>
                    <td><?= $row["ujian_WAKTU"]; ?></td>
                    <td><?= $row["peserta_JUDUL"]; ?></td>
                    <td>
                        <img src="images/<?= $row["ujian_FOTO"]; ?>" 
                        style="width:100px; height:auto; border-radius:5px;">
                    </td>

                    <td>
                        <a href="editujianskripsi.php?ubahujianskripsi=<?= $row["mhs_NPM"] ?>" 
                        class="btn btn-success" title="EDIT">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </td>

                    <td>
                        <a href="hapusujianskripsi.php?hapusujianskripsi=<?= $row["mhs_NPM"] ?>" 
                        class="btn btn-danger" title="HAPUS">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php } ?>

        </table>
    </div>
</div>

</body>
</div>
</main>

<?php include("bagiankode/footer.php"); ?>
</div>
</div>

<?php include("bagiankode/jsscript.php"); ?>

</body>
</html>
