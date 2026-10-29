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
                    <h1 class="mt-4">Data Diri</h1>
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
                        <div class="foto">
                            <img src="images/vero.jpeg" alt="..." style="width: 100px; height: 100px;"/>
                            <h2>Veronika Carolline Hadynata</h2>
                            <h2>825240100</h2>
                        </div>

                        <?php include("bagiankode/footer.php"); ?>
        </div>
    </div>

    <?php include("bagiankode/jsscript.php"); ?>

</body>

</html>