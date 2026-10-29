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

                        $NPM = $_GET["ubahdaftarseminar"];
                        $edit = mysqli_query($conn, "SELECT * FROM daftarseminar WHERE mhs_NPM='$NPM'");
                        $row_edit = mysqli_fetch_array($edit);

                        $editmhs = mysqli_query($conn,"SELECT * FROM mahasiswa WHERE mhs_NPM = '$NPM'");
                        $row_edit2 = mysqli_fetch_array($editmhs);

                        $Nama = $row_edit["seminar_Nama"];
                        $editjadwalseminar = mysqli_query($conn, "SELECT * FROM jadwalseminar WHERE seminar_Nama = '$Nama'");
                        $row_edit3 = mysqli_fetch_array($editjadwalseminar);

                        if (isset($_POST["Ubah"])) {
                            $mhs_NPM = $_POST["npmMHS"];
                            $seminar_Nama = $_POST["namaSEMINAR"];
                            
                            mysqli_query($conn,
                                "UPDATE daftarseminar SET 
                                    mhs_NPM = '$mhs_NPM',
                                    seminar_Nama = '$seminar_Nama'
                                WHERE mhs_NPM = '$NPM'" );

                            header("location:inputdaftarseminar.php");
                        }

                        if (isset($_POST["kirim"])) {
                            $search = $_POST["search"];
                            $query = mysqli_query($conn, "
                                SELECT * FROM daftarseminar 
                                JOIN mahasiswa ON mahasiswa.mhs_NPM = daftarseminar.mhs_NPM
                                JOIN jadwalseminar ON jadwalseminar.seminar_Nama = daftarseminar.seminar_Nama
                                WHERE daftarseminar.mhs_NPM LIKE '%$search%'
                            ");
                        } else {
                            $query = mysqli_query($conn, "
                                SELECT * FROM daftarseminar 
                                JOIN mahasiswa ON mahasiswa.mhs_NPM = daftarseminar.mhs_NPM
                                JOIN jadwalseminar ON jadwalseminar.seminar_Nama = daftarseminar.seminar_Nama
                            ");
                        }

                        // ambil data dropdown
                        $datamhs = mysqli_query($conn, "SELECT * FROM mahasiswa");
                        $datajadwalseminar = mysqli_query($conn, "SELECT * FROM jadwalseminar");
                        ?>

                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <form method="POST" enctype="multipart/form-data">

                                    <div class="row mb-3 mt-5">
                                        <label class="col-sm-2 col-form-label">NPM Mahasiswa</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="npmMHS">
                                                <option>
                                <?php echo $row_edit['mhs_NPM'] ?>
                                <?php echo $row_edit2['mhs_Nama'] ?>
                            </option>
                            <?php while ($row = mysqli_fetch_array($datamhs)) { ?>
                                <option value="<?php echo $row["mhs_NPM"] ?>">
                                    <?php echo $row["mhs_NPM"] ?>
                                    <?php echo $row["mhs_Nama"] ?>
                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3 mt-5">
                                        <label class="col-sm-2 col-form-label">Jadwal Seminar</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="namaSEMINAR">
                                                <option>
                                <?php echo $row_edit["seminar_Nama"] ?>
                                <?php echo $row_edit3["seminar_Tanggal"] ?>
                                <?php echo $row_edit3["seminar_Waktu"] ?>
                            </option>
                            <?php while ($row = mysqli_fetch_array($datajadwalseminar)) { ?>
                                <option value="<?php echo $row["seminar_Nama"] ?>">
                                    <?php echo $row["seminar_Nama"] ?>
                                    <?php echo $row["seminar_Tanggal"] ?>
                                    <?php echo $row["seminar_Waktu"] ?>                                     
                                </option>
                                                <?php } ?>
                                            </select>
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

                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">

                                <div class="jumbotron mt-5 mb-3">
                                    <h1 class="display-5">Daftar Peserta Seminar</h1>
                                </div>

                                <form method="POST">
                                    <div class="form-group-row row mb-3 mt-5">
                                        <label class="col-sm-2">Cari NPM Mahasiswa</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="search" class="form-control" placeholder="Cari NPM Mahasiswa"
                                            value="<?php if (isset($_POST["search"])) echo $_POST["search"]; ?>">
                                        </div>
                                        <input type="submit" name="kirim" value="Cari" class="col-sm-1 btn btn-primary">
                                    </div>
                                </form>

                                <table class="table table-success table-striped table-hover">
                                    <tr>
                                        <th>NPM</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Nama Seminar</th>
                                        <th>Tanggal Seminar</th>
                                        <th>Waktu Seminar</th>
                                        <th colspan="2" style="text-align:center;">Aksi</th>
                                    </tr>

                                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                                        <tr>
                                            <td><?= $row["mhs_NPM"]; ?></td>
                                            <td><?= $row["mhs_Nama"]; ?></td>
                                            <td><?= $row["seminar_Nama"]; ?></td>
                                            <td><?= $row["seminar_Tanggal"]; ?></td>
                                            <td><?= $row["seminar_Waktu"]; ?></td>
                                            
                                            <td>
                                                <a href="editdaftarseminar.php?ubahdaftarseminar=<?= $row["mhs_NPM"] ?>" 
                                                   class="btn btn-success" title="EDIT">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            </td>

                                            <td>
                                                <a href="hapusdaftarseminar.php?hapusdaftarseminar=<?= $row["mhs_NPM"] ?>" 
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
