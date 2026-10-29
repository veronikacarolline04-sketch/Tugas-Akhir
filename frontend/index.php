<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>

        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    </head>
    <body>

    <?php include "includes/frontmenu.php";
    $detail = mysqli_query(
      $conn, "SELECT * FROM pesertaskripsi
      JOIN mahasiswa ON mahasiswa.mhs_NPM = pesertaskripsi.mhs_NPM
      JOIN dosen ON dosen.dosen_NIDN = pesertaskripsi.dosen_NIDN
      ORDER BY peserta_TGLDAFTAR DESC"
    );
    $peserta = [];
    while ($row = mysqli_fetch_assoc($detail)){
      $peserta[] = $row;
    }

    $datamhs = mysqli_query($conn, "select * from mahasiswa");
    $datadosen = mysqli_query($conn, "select * from dosen");
    
    $detail = mysqli_query(
      $conn, "SELECT * FROM ujianskripsi 
    JOIN mahasiswa ON mahasiswa.mhs_NPM = ujianskripsi.mhs_NPM
    JOIN bimbinganskripsi ON bimbinganskripsi.mhs_NPM = ujianskripsi.mhs_NPM
    JOIN dosen ON dosen.dosen_NIDN = bimbinganskripsi.dosen_NIDN
    JOIN pesertaskripsi ON pesertaskripsi.mhs_NPM = ujianskripsi.mhs_NPM
    ORDER BY ujianskripsi.ujian_TANGGAL DESC
    ");
    $ujian = [];
    while ($row = mysqli_fetch_assoc($detail)){
      $ujian[] = $row;
    }

    $detail = mysqli_query(
      $conn, "SELECT * FROM ukm 
    JOIN mahasiswa ON mahasiswa.mhs_NPM = ukm.mhs_NPM
    ORDER BY ukm_NAMA DESC
    ");
    $ukm = [];
    while ($row = mysqli_fetch_assoc($detail)){
      $ukm[] = $row;
    }

    $detail = mysqli_query(
      $conn, "SELECT * FROM jadwalseminar 
    ORDER BY seminar_Nama DESC
    ");
    $jadwalseminar = [];
    while ($row = mysqli_fetch_assoc($detail)){
      $jadwalseminar[] = $row;
    }

    $detail = mysqli_query(
      $conn, "SELECT * FROM daftarseminar 
    JOIN mahasiswa ON mahasiswa.mhs_NPM = daftarseminar.mhs_NPM
    JOIN jadwalseminar ON jadwalseminar.seminar_Nama = daftarseminar.seminar_Nama
    ORDER BY daftarseminar.seminar_Nama DESC
    ");
    $daftarseminar = [];
    while ($row = mysqli_fetch_assoc($detail)){
      $daftarseminar[] = $row;
    }

     $detail = mysqli_query(
      $conn, "SELECT * FROM dosen 
    ORDER BY dosen_NIDN DESC
    ");
    $dosen = [];
    while ($row = mysqli_fetch_assoc($detail)){
      $dosen[] = $row;
    }
    ?>


    <!-- slider -->
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/untarr.jpeg" class="d-block w-100" alt="No Picture">
      <div class="carousel-caption d-none d-md-block">
        <h5>Gedung Utama UNTAR</h5>
        <p>Kampus yang strategis di Kota Jakarta Barat</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/maba.jpg" class="d-block w-100" alt="No Picture">
      <div class="carousel-caption d-none d-md-block">
        <h5>Mahasiswa Baru</h5>
        <p>Some representative placeholder content for the second slide.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/untarr.jpeg" class="d-block w-100" alt="No Picture">
      <div class="carousel-caption d-none d-md-block">
        <h5>Third slide label</h5>
        <p>Some representative placeholder content for the third slide.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<div class="container">
    <div class="row atas mt-5">
        <div class="col-sm-8">
          <?php foreach ($peserta as $row): ?>
            <div class="d-flex align-items-center mb-4">
              <div class="flex-shrink-0">
                <img src="../admin/images/<?php echo $row['peserta_DOKUMEN']; ?>"
                width="110"
                height="85" alt="Foto Dokumen">
              </div>

              <div class="flex-grow-1 ms-3" style="margin-left: 10px; text-align: justify;">
                            <h2><?php echo $row['peserta_JUDUL']; ?></h2>

                            <p>
                                Siswa <?php echo $row['mhs_Nama']; ?>, dengan NPM <?php echo $row['mhs_NPM']; ?>
                                di semester <?php echo $row['peserta_SMT']; ?> dengan tahun akademik
                                <?php echo $row['peserta_THAKD']; ?> mendaftarkan skripsi pada tanggal
                                <?php echo $row['peserta_TGLDAFTAR']; ?> bersama dosen pembimbing
                                <?php echo $row['dosen_Nama']; ?> dengan keterangan
                                <?php echo $row['peserta_KET']; ?>.
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="col-sm-4">
                <div class="list-group">        

  <?php foreach ($ujian as $row): ?>
  <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1"><?php echo $row['mhs_NPM']; ?> 
    <?php echo $row['mhs_Nama']; ?></h5>
      <small><?php echo $row['ujian_TANGGAL']; ?></small>
      <small><?php echo $row['ujian_WAKTU']; ?></small>
    </div>
    <p class="mb-1"><?php echo $row['dosen_Nama']; ?></p>
  </a>
  <?php endforeach; ?>
</div>
        </div>
    </div> <!-- penutup row atas -->

    <!-- galeri -->
    <h1 class="mt-15, mb-15" style="text-align: center">Hasil Skripsi</h1>
    <div class="galerifoto row g-4">
      <?php foreach ($ujian as $row): ?>
        <figure class="col-lg-4 col-sm-6 col-xs-12">
  <img style="width: 350px; height: 300px; src=" src="../admin/images/<?php echo $row['ujian_FOTO']; ?>" class="figure-img img-fluid rounded" alt="...">
  <figcaption class="figure-caption"><?php echo $row['peserta_JUDUL']; ?></figcaption>
</figure>
<?php endforeach; ?>
    </div>
    

    <div class="row tengah mt-5">
      <!-- tengah sebelah kiri -->
        <div class="col-md-4">
            <div class="accordion accordion-flush" id="accordionFlushExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingOne">
            <?php foreach ($jadwalseminar as $row): ?>
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
        Jadwal Seminar
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body"><?php echo $row['seminar_Nama']; ?> <code><?php echo $row['seminar_Tanggal']; ?></code> <code><?php echo $row['seminar_Waktu']; ?></code> <?php echo $row['seminar_Ruangan']; ?></div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
        </div>
        </div>
        <!-- kotak  tengah sebelah kanan -->
        
        
        <div class="col-md-4">
          <h5>List Daftar Seminar</h5>
          <?php foreach ($daftarseminar as $row): ?>
            <ul class="list-group">
  <li class="list-group-item"><?php echo $row['mhs_NPM']; ?> <?php echo $row['mhs_Nama']; ?> <code> <?php echo $row['seminar_Nama']; ?> </code></li>
</ul>
<?php endforeach; ?>
        </div>

        <div class="col-md-4">
            <div class="card" style="width: 18rem;">
                    <?php foreach ($ukm as $row): ?>
  <img src="../admin/images/<?php echo $row['ukm_FOTO']; ?>" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">Unit Kegiatan Mahasiswa</h5>
    <p class="card-text"><?php echo $row['ukm_NAMA']; ?></p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
    <?php endforeach; ?>
  </div>
</div>
        </div>
    </div>
    <div class="row atas mt-5">
      <!-- kotak bawah sebelah kiri -->
        <div class="col-sm-4">
          <div class="spinner-border text-primary" role="status">
  <span class="visually-hidden">Loading...</span>
</div>
<div class="spinner-border text-secondary" role="status">
  <span class="visually-hidden">Loading...</span>
</div>
<div class="spinner-border text-success" role="status">
  <span class="visually-hidden">Loading...</span>
</div>
<div class="spinner-border text-danger" role="status">
  <span class="visually-hidden">Loading...</span>
</div>
<div class="spinner-border text-warning" role="status">
  <span class="visually-hidden">Loading...</span>
</div>
<div class="spinner-border text-info" role="status">
  <span class="visually-hidden">Loading...</span>
</div>
<div class="spinner-border text-light" role="status">
  <span class="visually-hidden">Loading...</span>
</div>
<div class="spinner-border text-dark" role="status">
  <span class="visually-hidden">Loading...</span>
</div>
          </div>
          <!-- kotak bawah sebelah kanan -->
          <div class="col-sm-8">
            <h5>List Daftar Dosen</h5>
          <?php foreach ($dosen as $row): ?>
            <ul class="list-group">
  <li class="list-group-item"><?php echo $row['dosen_NIDN']; ?> <?php echo $row['dosen_Nama']; ?></li>
</ul>
<?php endforeach; ?>
</div>
            <div class="row">
              <!-- kotak bawah 1 -->
                <div class="col-sm-8">
                  <nav aria-label="Page navigation example">
                  <ul class="pagination">
                  <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">Next</a></li>
                  </ul>
                  </nav>
                </div>

                <!-- kotak bawah 2 -->
                <div class="col-sm-4">
              <div class="card" style="width: 18rem; margin-top: 20px;">
  <img src="../admin/images/vero.jpeg" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">Data Diri</h5>
    <p class="card-text">Veronika Carolline Hadynata</p>
    <a>825240100 Kelas A</a>
  </div>
</div>     
              </div>
            </div>
        </div>
    </div>
</div>

    </body>
    <script type="text/javascript" src="js/bootstrap.bundle.js"></script>
</html>