<?php
    include("includes/config.php");
    
    if (isset($_GET['hapusjadwalseminar'])) 
    {
        $NPM = $_GET["hapusjadwalseminar"];
        mysqli_query($conn, "DELETE FROM jadwalseminar WHERE seminar_Nama = '$Nama'");
        
        echo "<script>alert('DATA BERHASIL DIHAPUS');
            document.location='inputjadwalseminar.php'</script>";
    }
?>