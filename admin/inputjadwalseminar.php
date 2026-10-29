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

                        if (isset($_POST["Simpan"])) {
                            $seminar_Nama = $_POST["namaSEMINAR"];
                            $seminar_Tanggal = $_POST["tanggalSEMINAR"];
                            $seminar_Waktu = $_POST["waktuSEMINAR"];
                            $seminar_Ruangan = $_POST["ruanganSEMINAR"];
                                
                            mysqli_query($conn,
                                "INSERT INTO jadwalseminar 
                                (seminar_Nama, seminar_Tanggal, seminar_Waktu, seminar_Ruangan)
                                VALUES ('$seminar_Nama', '$seminar_Tanggal', '$seminar_Waktu', '$seminar_Ruangan')"
                            );

                            header("location:inputjadwalseminar.php");
                        }

                        if (isset($_POST["kirim"])) {
                            $search = $_POST["search"];
                            $query = mysqli_query($conn, "
                                SELECT * FROM jadwalseminar
                                WHERE seminar_Nama LIKE '%$search%'
                            ");
                        } else {
                            $query = mysqli_query($conn, "
                                SELECT * FROM jadwalseminar
                            ");
                        }


                        ?>

                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <form method="POST" enctype="multipart/form-data">

                                    <div class="row mb-3 mt-5">
                                        <label class="col-sm-2 col-form-label">Nama Seminar</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="namaSEMINAR" placeholder="Masukkan Nama Seminar">
                                        </div>
                                    </div>

                                    <div class="row mb-3 mt-5">
                                        <label class="col-sm-2 col-form-label">Tanggal Seminar</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" name="tanggalSEMINAR">
                                        </div>
                                    </div>

                                    <div class="row mb-3 mt-5">
                                        <label class="col-sm-2 col-form-label">Waktu Seminar</label>
                                        <div class="col-sm-10">
                                            <input type="time" class="form-control" name="waktuSEMINAR">
                                        </div>
                                    </div>

                                    <div class="row mb-3 mt-5">
                                        <label class="col-sm-2 col-form-label">Ruangan Seminar</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="ruanganSEMINAR" placeholder="Masukkan Ruangan Seminar">
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
                                    <h1 class="display-5">Daftar Jadwal Seminar</h1>
                                </div>

                                <form method="POST">
                                    <div class="form-group-row row mb-3 mt-5">
                                        <label class="col-sm-2">Cari Nama Seminar</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="search" class="form-control" placeholder="Cari Nama Seminar"
                                            value="<?php if (isset($_POST["search"])) echo $_POST["search"]; ?>">
                                        </div>
                                        <input type="submit" name="kirim" value="Cari" class="col-sm-1 btn btn-primary">
                                    </div>
                                </form>

                                <table class="table table-success table-striped table-hover">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Ruangan</th>
                                        <th colspan="2" style="text-align:center;">Aksi</th>
                                    </tr>

                                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                                        <tr>
                                            <td><?= $row["seminar_Nama"]; ?></td>
                                            <td><?= $row["seminar_Tanggal"]; ?></td>
                                            <td><?= $row["seminar_Waktu"]; ?></td>
                                            <td><?= $row["seminar_Ruangan"]; ?></td>
                                            
                                            <td>
                                                <a href="editjadwalseminar.php?ubahjadwalseminar=<?= $row["seminar_Nama"] ?>" 
                                                   class="btn btn-success" title="EDIT">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            </td>

                                            <td>
                                                <a href="hapusjadwalseminar.php?hapusjadwalseminar=<?= $row["seminar_Nama"] ?>" 
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
