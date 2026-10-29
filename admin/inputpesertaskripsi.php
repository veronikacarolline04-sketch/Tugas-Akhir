<!DOCTYPE html>
<html lang="en">
    <?php include("bagiankode/head.php");
    ob_start();
    session_start();
    if (!isset($_SESSION['useremail']))
        header("location:login.php");
    ?>

<body class="sb-nav-fixed">
    <?php
    include("bagiankode/menunav.php");
    ?>
    <div id="layoutSidenav">
        <?php
        include("bagiankode/menu.php");
        ?>
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
                        <title></title>

                        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
                        <link rel="stylesheet"
                            href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css">

                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
                        <script type="text/javascript"
                            src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
                        <link rel="stylesheet" type="text/css"
                            href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">

                    </head>

                    <body>

                        <?php
                        include("includes/config.php");

                        if (isset($_POST["Simpan"])) {
                            $mhs_NPM = $_POST["npmMHS"];
                            $peserta_SMT = $_POST["smtPESERTA"];
                            $peserta_THAKD = $_POST["thakdPESERTA"];
                            $tahun = $_POST["thakdPESERTA"];
                            $peserta_TGLDAFTAR = $_POST["tgldaftarPESERTA"];
                            $peserta_JUDUL = $_POST["judulPESERTA"];
                            $peserta_DOKUMEN = $_FILES["dokumenPESERTA"]["name"];
                            $dokumen_tmp = $_FILES["dokumenPESERTA"]["tmp_name"];
                            move_uploaded_file($dokumen_tmp, "images/" . $peserta_DOKUMEN);
                            $dosen_NIDN = $_POST["nidnDOSEN"];
                            $peserta_KET = $_POST["ketPESERTA"];
                            mysqli_query($conn, "insert into pesertaskripsi values('$mhs_NPM', '$peserta_SMT', '$peserta_THAKD', '$peserta_TGLDAFTAR', '$peserta_JUDUL', '$peserta_DOKUMEN', '$dosen_NIDN', '$peserta_KET')");
                            header("location:inputpesertaskripsi.php");
                        }

                        // pencarian data
                        if (isset($_POST["kirim"])) {
                            $search = $_POST["search"];
                            $query = mysqli_query($conn, "SELECT * FROM pesertaskripsi, dosen, mahasiswa where mahasiswa.mhs_NPM = pesertaskripsi.mhs_NPM AND pesertaskripsi.dosen_NIDN = dosen.dosen_NIDN AND pesertaskripsi.mhs_NPM LIKE '%$search%'");
                        } else {
                            $query = mysqli_query($conn, "SELECT * FROM pesertaskripsi, dosen, mahasiswa where mahasiswa.mhs_NPM = pesertaskripsi.mhs_NPM and pesertaskripsi.dosen_NIDN = dosen.dosen_NIDN");
                        }
                        // end pencarian data
                        
                        $datamhs = mysqli_query($conn, "select * from mahasiswa");
                        $datadosen = mysqli_query($conn, "select * from dosen");
                        ?>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="row mb-3 mt-5">
                                        <label for="npmMHS" class="col-sm-2 col-form-label">NPM Mahasiswa</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="npmMHS" name="npmMHS">
                                                <option>Cari NPM Mahasiswa</option>
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
                                        <label for="smtPESERTA" class="col-sm-2 col-form-label">Semeseter
                                            Peserta</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="smtPESERTA" name="smtPESERTA">
                                                <option>Pilih Semeseter </option>
                                                <option>Genap</option>
                                                <option>Ganjil</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3 mt-5">
                                        <label for="thakdPESERTA" class="col-sm-2 col form-label">Tahun Akademik
                                            Peserta</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="thakdPESERTA"
                                                name="thakdPESERTA" placeholder="ex: 2024-2025">
                                        </div>
                                    </div>

                                    <div class="row mb-3 mt-5">
                                        <label for="tgldaftarPESERTA" class="col-sm-2 col form-label">Tanggal Daftar
                                            Peserta</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" id="tgldaftarPESERTA"
                                                name="tgldaftarPESERTA" placeholder="Isi Tanggal Daftar Peserta">
                                        </div>
                                    </div>

                                    <div class="row mb-3 mt-5">
                                        <label for="judulPESERTA" class="col-sm-2 col form-label">Judul Skripsi
                                            Peserta</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="judulPESERTA"
                                                name="judulPESERTA" placeholder="Masukkan Judul Skripsi">
                                        </div>
                                    </div>

                                    <div class="row mb-3 mt-5">
                                        <label for="dokumenPESERTA" class="col-sm-2 col-form-label">Unggah Dokumen
                                            Peserta</label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control" id="dokumenPESERTA"
                                                name="dokumenPESERTA">
                                            <p class="help-block">Unggah file dokumen</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3 mt-5">
                                        <label for="nidnDOSEN" class="col-sm-2 col-form-label">NIDN Dosen</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="nidnDOSEN" name="nidnDOSEN">
                                                <option>Cari NIDN Dosen</option>
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
                                        <label for="ketPESERTA" class="col-sm-2 col form-label">Keterangan
                                            Peserta</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="ketPESERTA"
                                                name="ketPESERTA" placeholder="Masukkan Keterangan Peserta">
                                        </div>

                                    <div class="form-group-row">
                                        <div class="col-2"></div>
                                        <div class="col-10">
                                            <input type="submit" class="btn btn-success" value="Simpan" name="Simpan">
                                            <input type="reset" class="btn btn-danger" value="Batal" name="Batal">
                                        </div><!--penutup class col-10-->
                                    </div><!--penutup class form-group-->
                                </form>
                                <div class="1"></div>
                            </div><!--penutup class row-->

                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col-10">
                                    <div class="jumbotron mt-5 mb-3">
                                        <h1 class="display-5">Daftar Peserta Skripsi</h1>
                                    </div>

                                    <form method="POST">
                                        <div class="form-group-row row mb-3 mt-5">
                                            <label for="search" class="col-sm-2">Cari NPM Mahasiswa</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="search" class="form-control" id="search" value="<?php if (isset($_POST["search"])) {
                                                    echo $_POST["search"];
                                                } ?>" placeholder="Cari NPM Mahasiswa">
                                            </div>
                                            <input type="submit" name="kirim" value="Cari"
                                                class="col-sm-1 btn btn-primary">
                                        </div>
                                    </form>

                                    <table class="table table-success table-striped table-hover">
                                        <tr class="info"><!--membuat judul-->
                                            <th>NPM</th>
                                            <th>Semester</th>
                                            <th>Tahun Akademik</th>
                                            <th>Tanggal Daftar</th>
                                            <th>Judul</th>
                                            <th>Dokumen</th>
                                            <th>NIDN</th>
                                            <th>Nama Dosen</th>
                                            <th>Keterangan</th>
                                            <th colspan="2" style="text-align: center;">Aksi</th>
                                        </tr>

                                        <?php { ?>
                                            <?php while ($row = mysqli_fetch_array($query)) { ?>
                                                <tr class="danger"><!--menampilkan data dari tabel kategori-->
                                                    <td><?php echo $row["mhs_NPM"]; ?> </td>
                                                    <td><?php echo $row["peserta_SMT"]; ?> </td>
                                                    <td><?php echo $row["peserta_THAKD"]; ?> </td>
                                                    <td><?php echo $row["peserta_TGLDAFTAR"]; ?> </td>
                                                    <td><?php echo $row["peserta_JUDUL"]; ?> </td>
                                                    <td>
                                                        <?php if ($row['peserta_DOKUMEN'] == "") {
                                                                    echo "<img src='images/noimage.png'
                                                        width='88'/>";
                                                                } else { ?>
                                                                    <img src="images/<?php echo $row['peserta_DOKUMEN'] ?>" width="88" class="img-responsive" />
                                                                <?php } ?>
                                                        </td>
                                                    <td><?php echo $row["dosen_NIDN"]; ?> </td>
                                                    <td><?php echo $row["dosen_Nama"]; ?> </td>
                                                    <td><?php echo $row["peserta_KET"]; ?> </td>

                                                    <td>
                                                        <a href="editpesertaskripsi.php?ubahpesertaskripsi=<?php echo $row["mhs_NPM"] ?>"
                                                            class="btn btn-success" title="EDIT">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                fill="currentColor" class="bi bi-pencil-square"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                                <path fill-rule="evenodd"
                                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                            </svg>
                                                    </td>
                                                    <td>
                                                        <a href="hapuspesertaskripsi.php?hapuspesertaskripsi=<?php echo $row["mhs_NPM"] ?>"
                                                            class="btn btn-danger" title="HAPUS">
                                                            <i class="bi bi-trash"></i>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </table>
                                </div>><!--penutup class col-10 untuk tabel-->
                            </div>><!--penutup class row untuk tabel-->
                    </body>
                </div>
            </main>
            <?php include("bagiankode/footer.php"); ?>
        </div>
    </div>
    <?php include("bagiankode/jsscript.php"); ?>
</body>

</html>