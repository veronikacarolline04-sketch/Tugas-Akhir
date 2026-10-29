<!DOCTYPE html>
<html lang="en">
<?php 
include("bagiankode/head.php");
ob_start();
session_start();

if (!isset($_SESSION['useremail']))
    header("location:login.php");

include("includes/config.php");

$NPM = $_GET["ubahujianskripsi"];

// Data ujian skripsi
$edit = mysqli_query($conn, "SELECT * FROM ujianskripsi WHERE mhs_NPM='$NPM' LIMIT 1");
$row_edit = mysqli_fetch_array($edit);

// Data dosen pembimbing
$editmhs = mysqli_query($conn, "SELECT * FROM bimbinganskripsi WHERE mhs_NPM='$NPM' LIMIT 1");
$row_edit2 = mysqli_fetch_array($editmhs);
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

    <!-- Tambahan CSS dan JS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">

<?php
// UPDATE DATA
if (isset($_POST["Ubah"])) {
    $mhs_NPM = $_POST["npmMHS"];
    $ujian_TANGGAL = $_POST["tanggalUJIAN"];
    $ujian_WAKTU = $_POST["waktuUJIAN"];

    // FOTO
    if ($_FILES["fotoUJIAN"]["name"]) {
        $ujian_FOTO = $_FILES["fotoUJIAN"]["name"];
        $tmp_foto = $_FILES["fotoUJIAN"]["tmp_name"];
        $size = $_FILES["fotoUJIAN"]["size"];
        $ext = strtolower(pathinfo($ujian_FOTO, PATHINFO_EXTENSION));
        $path = "images/" . $ujian_FOTO;

        if ($size <= 500000 && ($ext == "jpg")) {
            if (!file_exists($path)) {
                move_uploaded_file($tmp_foto, $path);
            }
        }
    } else {
        $ujian_FOTO = $row_edit["ujian_FOTO"]; // jika tidak upload, pakai foto lama
    }

    mysqli_query($conn,
        "UPDATE ujianskripsi SET 
            mhs_NPM='$mhs_NPM',
            ujian_TANGGAL='$ujian_TANGGAL',
            ujian_WAKTU='$ujian_WAKTU',
            ujian_FOTO='$ujian_FOTO'
        WHERE mhs_NPM='$NPM'");

    header("location:inputujianskripsi.php");
}

// SEARCH DATA
if (isset($_POST["kirim"])) {
    $search = $_POST["search"];
    $query = mysqli_query($conn,
        "SELECT * FROM ujianskripsi 
        JOIN bimbinganskripsi ON bimbinganskripsi.mhs_NPM = ujianskripsi.mhs_NPM
        WHERE ujianskripsi.mhs_NPM LIKE '%$search%'");
} else {
    $query = mysqli_query($conn,
        "SELECT * FROM ujianskripsi 
        JOIN bimbinganskripsi ON bimbinganskripsi.mhs_NPM = ujianskripsi.mhs_NPM");
}

$databimbinganskripsi = mysqli_query($conn, "SELECT * FROM bimbinganskripsi");
?>

<!-- FORM EDIT -->
<div class="row">
    <div class="col-1"></div>
    <div class="col-10">

        <form method="POST" enctype="multipart/form-data">

            <div class="row mb-3 mt-5">
                <label class="col-sm-2 col-form-label">NPM Mahasiswa</label>
                <div class="col-sm-10">
                    <select class="form-control" name="npmMHS">
                        <option value="<?= $row_edit['mhs_NPM'] ?>">
                            <?= $row_edit['mhs_NPM'] ?> - <?= $row_edit2['dosen_NIDN'] ?>
                        </option>

                        <?php while ($row = mysqli_fetch_array($databimbinganskripsi)) { ?>
                        <option value="<?= $row["mhs_NPM"] ?>">
                            <?= $row["mhs_NPM"] ?> - <?= $row["dosen_NIDN"] ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3 mt-5">
                <label class="col-sm-2 col-form-label">Tanggal Ujian</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="tanggalUJIAN"
                        value="<?= $row_edit["ujian_TANGGAL"] ?>">
                </div>
            </div>

            <div class="row mb-3 mt-5">
                <label class="col-sm-2 col-form-label">Waktu Ujian</label>
                <div class="col-sm-10">
                    <input type="time" class="form-control" name="waktuUJIAN"
                        value="<?= $row_edit["ujian_WAKTU"] ?>">
                </div>
            </div>

            <div class="row mb-3 mt-5">
                <label class="col-sm-2 col-form-label">Unggah Foto Ujian</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" name="fotoUJIAN">
                    <p class="help-block">File JPG maks 500 KB</p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="col-2"></div>
                <div class="col-10">
                    <input type="submit" class="btn btn-success" value="Ubah" name="Ubah">
                    <input type="reset" class="btn btn-danger" value="Batal">
                </div>
            </div>

        </form>
    </div>
</div>

<!-- TABEL -->
<div class="row">
    <div class="col-1"></div>
    <div class="col-10">

        <div class="jumbotron mt-5 mb-3">
            <h1 class="display-5">Daftar Ujian Skripsi</h1>
        </div>

        <form method="POST">
            <div class="form-group-row row mb-3 mt-5">
                <label class="col-sm-2">Cari NPM Mahasiswa</label>
                <div class="col-sm-6">
                    <input type="text" name="search" class="form-control"
                        placeholder="Cari NPM Mahasiswa"
                        value="<?php if (isset($_POST["search"])) echo $_POST["search"]; ?>">
                </div>
                <input type="submit" name="kirim" value="Cari" class="col-sm-1 btn btn-primary">
            </div>
        </form>

        <table class="table table-success table-striped table-hover">
            <tr>
                <th>NPM</th>
                <th>NIDN</th>
                <th>Tanggal Ujian</th>
                <th>Waktu Ujian</th>
                <th>Foto Ujian</th>
                <th colspan="2" style="text-align:center;">Aksi</th>
            </tr>

            <?php while ($row = mysqli_fetch_array($query)) { ?>
            <tr>
                <td><?= $row["mhs_NPM"]; ?></td>
                <td><?= $row["dosen_NIDN"]; ?></td>
                <td><?= $row["ujian_TANGGAL"]; ?></td>
                <td><?= $row["ujian_WAKTU"]; ?></td>
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

</div>
</main>

<?php include("bagiankode/footer.php"); ?>
</div>
</div>

<?php include("bagiankode/jsscript.php"); ?>

</body>
</html>
