<?php
include("ayar.php");
ob_start();
session_start();

if(isset($_POST["login"]))
{
    header("Refresh:0 url=index.php", true, 301);
    exit();
}

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>PAÜ İİBF Bildirim Sistemi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/signin2.css">
    <link rel="icon" type="image/png" href="img/icon.png" />
</head>
<body>
<div class="container mt-4">
    <div class="row text-center" style="">
        <div class="col-md-12">
            <a href="http://iibf.pau.edu.tr"><img class="" style="" src="img/logo.png" alt="" width="100" height="160"></a>
        </div>
    </div>
    <div class="row mb-3">
        <div class="offset-3 col-sm-12 col-md-6">
            <form class="form-signin text-center" method="post" action="kayitol.php">
                <h1 class="h4 mb-3 font-weight-normal">Şifremi Unuttum</h1>
                <div class="form-group">
                    <input name="ueposta" type="email" class="form-control" placeholder="ornek@posta.pau.edu.tr" required autofocus>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Kurtarma Bağlantısı Gönder</button>
                </div>
                <div class="form-group">
                    <a href="index.php" class="btn btn-secondary btn-block">Geri Dön</a>
                </div>
            </form>
            <?php

            if($_POST)
            {
                if(isset($_POST["ueposta"]))
                {



                }
            }

            ?>
        </div>
    </div>
    <div class="row" style="height: 40px"></div>
    <div class="row text-center">
        <div class="offset-3 col-md-6">
            <a class="text-muted">&copy; <?php echo date("Y"); ?> - Pamukkale Üniversitesi Yönetim Bilişim Sistemleri Bölümü</a>
        </div>
    </div>
</div>
<script src="css/bootstrap.min.js"></script>
</body>
</html>