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
                            $mhs_NPM = $_POST["npmMHS"];
                            $ukm_NAMA = $_POST["namaUKM"];
                            $ukm_KET = $_POST["ketUKM"];
                            $ukm_FOTO = $_FILES["fotoUKM"]["name"];

                            $dokumen_tmp = $_FILES["fotoUKM"]["tmp_name"];

                            $typefoto = pathinfo($ukm_FOTO, PATHINFO_EXTENSION);
                            $ukuranfoto = $_FILES["fotoUKM"]["size"];
                            $path = "images/". $ukm_FOTO;
                            if($ukuranfoto<=500000){
                                if($typefoto=="jpg" || $typefoto=="JPG"){
                                    if(!file_exists($path)){
                                    move_uploaded_file($dokumen_tmp, "images/" . $ukm_FOTO);
                                }
                            }

                                mysqli_query($conn,
                                "INSERT INTO ukm 
                                (mhs_NPM, ukm_NAMA, ukm_KET, ukm_FOTO)
                                VALUES ('$mhs_NPM', '$ukm_NAMA', '$ukm_KET', '$ukm_FOTO')"
                            );

                            header("location:inputukm.php");
                        }}

                        if (isset($_POST["kirim"])) {
                            $search = $_POST["search"];
                            $query = mysqli_query($conn, "
                                SELECT * FROM ukm 
                                JOIN mahasiswa ON mahasiswa.mhs_NPM = ukm.mhs_NPM
                                WHERE ukm.mhs_NPM LIKE '%$search%'
                            ");
                        } else {
                            $query = mysqli_query($conn, "
                                SELECT * FROM ukm 
                                JOIN mahasiswa ON mahasiswa.mhs_NPM = ukm.mhs_NPM
                            ");
                        }

                        // ambil data dropdown
                        $datamhs = mysqli_query($conn, "SELECT * FROM mahasiswa");
                        ?>

                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <form method="POST" enctype="multipart/form-data">

                                    <div class="row mb-3 mt-5">
                                        <label class="col-sm-2 col-form-label">NPM Mahasiswa</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="npmMHS">
                                                <option value="">Cari NPM Mahasiswa</option>
                                                <?php while ($row = mysqli_fetch_array($datamhs)) { ?>
                                                    <option value="<?= $row["mhs_NPM"] ?>">
                                                        <?= $row["mhs_NPM"] ?> - <?= $row["mhs_Nama"] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3 mt-5">
                                        <label class="col-sm-2 col-form-label">Nama UKM</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="namaUKM" name="namaUKM">
                                                <option>Pilih UKM </option>
                                                <option>UKM Seni Tari</option>
                                                <option>UKM Seni Musik</option>
                                                <option>UKM Paduan Suara</option>
                                                <option>UKM Teater</option>
                                                <option>UKM Fotografi</option>
                                                <option>UKM Sinematografi</option>
                                                <option>UKM Futsal</option>
                                                <option>UKM Sepak Bola</option>
                                                <option>UKM Basket</option>
                                                <option>UKM Voli</option>
                                                <option>UKM Badminton</option>
                                                <option>UKM Karate</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3 mt-5">
                                        <label class="col-sm-2 col-form-label">Keterangan UKM</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="ketUKM" placeholder="Masukkan keterangan UKM">
                                        </div>
                                    </div>

                                    <div class="row mb-3 mt-5">
                                        <label class="col-sm-2 col-form-label">Unggah Foto UKM</label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control" name="fotoUKM">
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
                                    <h1 class="display-5">Daftar UKM</h1>
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
                                        <th>Nama</th>
                                        <th>Nama UKM</th>
                                        <th>Keterangan UKM</th>
                                        <th>Foto UKM</th>
                                        <th colspan="2" style="text-align:center;">Aksi</th>
                                    </tr>

                                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                                        <tr>
                                            <td><?= $row["mhs_NPM"]; ?></td>
                                            <td><?= $row["mhs_Nama"]; ?></td>
                                            <td><?= $row["ukm_NAMA"]; ?></td>
                                            <td><?= $row["ukm_KET"]; ?></td>
                                            <td>
                                                <img src="images/<?= $row["ukm_FOTO"]; ?>" 
                                                    style="width:100px; height:auto; border-radius:5px;">
                                            </td>

                                            <td>
                                                <a href="editukm.php?ubahukm=<?= $row["mhs_NPM"] ?>" 
                                                   class="btn btn-success" title="EDIT">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            </td>

                                            <td>
                                                <a href="hapusukm.php?hapusukm=<?= $row["mhs_NPM"] ?>" 
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
