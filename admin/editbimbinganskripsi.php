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
                        <link rel="stylesheet"
                            href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css">

                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
                        <link rel="stylesheet"
                            href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">
                    </head>

                    <body>

                        <?php
                        include("includes/config.php");

                        $NPM = $_GET["ubahbimbinganskripsi"];
                        $edit = mysqli_query($conn, "SELECT * FROM bimbinganskripsi WHERE mhs_NPM='$NPM'");
                        $row_edit = mysqli_fetch_array($edit);

                        $editmhs = mysqli_query($conn, "SELECT * FROM pesertaskripsi WHERE mhs_NPM = '$NPM'");
                        $row_edit2 = mysqli_fetch_array($editmhs);

                        $NIDN = $row_edit["dosen_NIDN"];
                        $editdosen = mysqli_query($conn, "SELECT * FROM dosen WHERE dosen_NIDN = '$NIDN'");
                        $row_edit3 = mysqli_fetch_array($editdosen);

                        if (isset($_POST["Ubah"])) {
                            $dosen_NIDN = $_POST["nidnDOSEN"];
                            $mhs_NPM = $_POST["npmMHS"];
                            $bimbingan_TANGGAL = $_POST["tanggalBIMBINGAN"];
                            $bimbingan_ISI = $_POST["isiBIMBINGAN"];

                            $bimbingan_DOKUMEN = $_FILES["dokumenBIMBINGAN"]["name"];
                            $dokumen_tmp = $_FILES["dokumenBIMBINGAN"]["tmp_name"];

                            $typedokumen = pathinfo($bimbingan_DOKUMEN, PATHINFO_EXTENSION);
                            $ukurandokumen = $_FILES["dokumenBIMBINGAN"]["size"];
                            $path = "dokumen/" . $bimbingan_DOKUMEN;

                            if ($ukurandokumen <= 500000) {
                                if ($typedokumen == "pdf") {
                                    if (!file_exists($path)) {
                                        move_uploaded_file($dokumen_tmp, $path);
                                    }
                                }
                            }

                            mysqli_query(
                                $conn,
                                "UPDATE bimbinganskripsi SET dosen_NIDN='$dosen_NIDN', mhs_NPM='$mhs_NPM', bimbingan_TANGGAL='$bimbingan_TANGGAL', 
                                bimbingan_ISI='$bimbingan_ISI', bimbingan_DOKUMEN='$bimbingan_DOKUMEN' 
                                WHERE mhs_NPM='$NPM'");

                            header("location:inputbimbinganskripsi.php");
                        }

                        if (isset($_POST["kirim"])) {
                            $search = $_POST["search"];
                            $query = mysqli_query($conn, "
                                SELECT * FROM bimbinganskripsi 
                                JOIN pesertaskripsi ON pesertaskripsi.mhs_NPM = bimbinganskripsi.mhs_NPM
                                JOIN dosen ON dosen.dosen_NIDN = bimbinganskripsi.dosen_NIDN
                                WHERE bimbinganskripsi.mhs_NPM LIKE '%$search%'
                            ");
                        } else {
                            $query = mysqli_query($conn, "
                                SELECT * FROM bimbinganskripsi 
                                JOIN pesertaskripsi ON pesertaskripsi.mhs_NPM = bimbinganskripsi.mhs_NPM
                                JOIN dosen ON dosen.dosen_NIDN = bimbinganskripsi.dosen_NIDN
                            ");
                        }

                        $datadosen = mysqli_query($conn, "SELECT * FROM dosen");
                        $datapesertaskripsi = mysqli_query($conn, "SELECT * FROM pesertaskripsi");
                        ?>

                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <form method="POST" enctype="multipart/form-data">

                                    <div class="row mb-3 mt-5">
                                        <label class="col-sm-2 col-form-label">NIDN Dosen</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="nidnDOSEN" name="nidnDOSEN">
                            <option>
                                <?php echo $row_edit["dosen_NIDN"] ?>
                                <?php echo $row_edit3["dosen_Nama"] ?>
                            </option>
                            <?php while ($row = mysqli_fetch_array($datadosen)) { ?>
                                <option value="<?php echo $row["dosen_NIDN"] ?>">
                                    <?php echo $row["dosen_NIDN"] ?>
                                    <?php echo $row["dosen_Nama"] ?>
                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3 mt-5">
                                        <label class="col-sm-2 col-form-label">NPM Mahasiswa</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="npmMHS" name="npmMHS">
                            <option>
                                <?php echo $row_edit['mhs_NPM'] ?>
                                <?php echo $row_edit2['peserta_JUDUL'] ?>
                            </option>
                            <?php while ($row = mysqli_fetch_array($datapesertaskripsi)) { ?>
                                <option value="<?php echo $row["mhs_NPM"] ?>">
                                    <?php echo $row["mhs_NPM"] ?>
                                    <?php echo $row["peserta_JUDUL"] ?>
                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3 mt-5">
                                        <label class="col-sm-2 col-form-label">Tanggal Bimbingan</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" name="tanggalBIMBINGAN"
                                            value="<?php echo $row_edit["bimbingan_TANGGAL"] ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3 mt-5">
                                        <label class="col-sm-2 col-form-label">Isi Bimbingan</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="isiBIMBINGAN"
                                                placeholder="Masukkan Isi Bimbingan"
                                                value="<?php echo $row_edit["bimbingan_ISI"] ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3 mt-5">
                                        <label class="col-sm-2 col-form-label">Unggah Dokumen</label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control" name="dokumenBIMBINGAN"
                                            value="<?php echo $row_edit["bimbingan_DOKUMEN"] ?>">
                                            <p class="help-block">File PDF maks 500 KB</p>
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

                        <!-- TABEL DATA -->
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">

                                <div class="jumbotron mt-5 mb-3">
                                    <h1 class="display-5">Daftar Bimbingan Skripsi</h1>
                                </div>

                                <form method="POST">
                                    <div class="form-group-row row mb-3 mt-5">
                                        <label class="col-sm-2">Cari NPM Mahasiswa</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Cari NPM Mahasiswa"
                                                value="<?php if (isset($_POST["search"]))
                                                    echo $_POST["search"]; ?>">
                                        </div>
                                        <input type="submit" name="kirim" value="Cari" class="col-sm-1 btn btn-primary">
                                    </div>
                                </form>

                                <table class="table table-success table-striped table-hover">
                                    <tr>
                                        <th>NIDN</th>
                                        <th>Nama Dosen</th>
                                        <th>NPM</th>
                                        <th>Judul Skripsi</th>
                                        <th>Tanggal</th>
                                        <th>Isi Bimbingan</th>
                                        <th>Dokumen</th>
                                        <th colspan="2" style="text-align:center;">Aksi</th>
                                    </tr>

                                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                                        <tr>
                                            <td><?= $row["dosen_NIDN"]; ?></td>
                                            <td><?= $row["dosen_Nama"]; ?></td>
                                            <td><?= $row["mhs_NPM"]; ?></td>
                                            <td><?= $row["peserta_JUDUL"]; ?></td>
                                            <td><?= $row["bimbingan_TANGGAL"]; ?></td>
                                            <td><?= $row["bimbingan_ISI"]; ?></td>
                                            <td>
                                                <a href="dokumen/<?= $row['bimbingan_DOKUMEN']; ?>" 
                                               >
                                                Lihat PDF
                                                </a>
                                                </td>
                                            <td>
                                                <a href="editbimbinganskripsi.php?ubahbimbinganskripsi=<?php echo $row["mhs_NPM"]; ?>"
                                                    class="btn btn-success" title="EDIT">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            </td>

                                            <td>
                                                <a href="hapusbimbinganskripsi.php?hapusbimbinganskripsi=<?php echo $row["mhs_NPM"]; ?>"
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