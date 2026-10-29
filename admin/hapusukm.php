<?php
include "includes/config.php";
if (isset($_GET["hapusukm"]))
    {
        $NPM = $_GET["hapusukm"];
        mysqli_query($conn,"DELETE FROM ukm
        WHERE mhs_NPM = '$NPM'");
        echo"<script>alert('DATA BERHASIL DIHAPUS');
        document.location='inputukm.php'</script>";
    }
?>