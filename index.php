<?php
include("ayar.php");
ob_start();
session_start();

if(isset($_SESSION["user"])){
    if($_SESSION["yetki"]==0)
    {
        header("Location:bildirimyap.php");
    }
    else if($_SESSION["yetki"]==1)
    {
        header("Location:gelenbildirim.php");
    }
    else if($_SESSION["yetki"]==2)
    {
        header("Location:yonetim.php");
    }
    else
    {
        header("Location:cikisyap.php");
    }
}


if($_POST && isset($_POST['eposta']))
{
    $gelen = $_POST['eposta'];
    $kontrol = true;
}
else
{
    $kontrol = false;
}

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>PAÜ İİBF Bildirim Sistemi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/signin.css">
    <link rel="icon" type="image/png" href="img/icon.png" />
</head>
<body>
<div class="container mt-4">
    <div class="row text-center mb-sm-3 mb-md-0" style="">
        <div class="col-md-12">
            <a href="http://iibf.pau.edu.tr"><img class="" style="" src="img/logo.png" alt="Pamukkale Üniversitesi İktisadi ve İdari Bilimler Fakültesi" width="100" height="160"></a>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-12 col-md-5">
            <form class="form-signin text-center" method="post" action="login.php">
                <h5 class="mb-4 font-weight-normal">Giriş Yap</h5>
                <input name="neposta" type="email" class="form-control" placeholder="ornek@posta.pau.edu.tr" required autofocus>
                <input name="nsifre" type="password" class="form-control" placeholder="Şifre" required>

                <button type="submit" class="btn btn-primary btn-block">Giriş Yap</button>

            </form>

            <?php

            if(isset($_GET["durum"]) && $_GET["durum"] == "2")
            {
                echo '<div class="form-signin text-center mt-3">';
                echo '<div class="alert alert-danger">E-posta veya şifre yanlış.</div>';
                echo '</div>';
            }

            ?>
        </div>
        <div class="col-sm-12 col-md-2 text-center form-signin">
            
        </div>
        <div class="col-sm-12 col-md-5">
            <form class="form-signin text-center" action="index.php" method="post">

                <h5 class="mb-4 font-weight-normal">E-posta onaylı giriş</h5>
                <input type="email" id="" name="eposta" class="form-control mb-3" placeholder="ornek@pau.edu.tr" required autofocus>
                <button type="submit" class="btn btn-primary btn-block">Gönder</button>
            </form>

            <?php
            if($kontrol)
            {
                $pau = paukontrol($gelen);

                if($pau)
                {
                    $token = md5(uniqid(mt_rand(), true));

                    $posta = $gelen;

                    $sorgu = "SELECT kposta FROM kullanicilar WHERE kposta = '".$posta."'";
                    $result = mysqli_query($con, $sorgu) or die(mysqli_error($con));
                    if(mysqli_num_rows($result) == 0) {
                        $sql = "INSERT INTO kullanicilar(kposta, kod)
    VALUES ('".$posta."', '".$token."')";
                    } else {
                        $sql = "UPDATE kullanicilar SET kod='".$token."', kodsay = 3 WHERE kposta='".$posta."'";
                    }

                    if ($con->query($sql) === TRUE) {
                        ini_set( 'display_errors', 1 );

                        error_reporting( E_ALL );

                        $from = "noreply@pauiibf.online";

                        $to = $gelen;

                        $subject = "E-Posta Onaylı Giriş";

                        $message = '
 Bu e-posta Pamukkale Üniversitesi İktisadi ve İdari Bilimler Fakültesi Bildirim Sistemi tarafından otomatik olarak gönderilmiştir.<br/><br/>
 Lütfen bu e-postayı cevaplamayınız.<br/>
 <br/>
 Aşağıdaki bağlantıya tıklayarak giriş işlemini gerçekleştirebilirsiniz.<br/><br/>
 <a href="http://pauiibf.online/login.php?eposta='.$posta.'&code='.$token.'">Buraya tıklayın.</a>';

                        $headers  = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";
                        $headers .= 'From: PAÜ İİBF <noreply@pauiibf.online>' . "\r\n";
                        if(mail($to, $subject, $message, $headers))
                        {
                            echo '<div class="alert alert-success mt-3">Onay e-postası gönderildi. (E-postanızın gereksiz(spam) alanını kontrol edin.)</div>';
                        }
                        else
                        {
                            echo '<div class="alert alert-danger mt-3">E-posta gönderirken hata oluştu.</div>';
                        }

                    }
                    else
                    {
                        header("Refresh:0 Location:index.php?durum=0");
                    }
                }
                else
                {
                    echo '<div class="alert alert-danger mt-3">Sadece pau.edu.tr uzantılı adres ile giriş yapabilirsiniz.</div>';
                }
            }

            if(isset($_GET["durum"]))
            {
                echo '<div class="mt-4">';
                if($_GET["durum"] == "1")
                {
                    echo '<div class="alert alert-info">Giriş bilgileriniz e-posta adresinize gönderilmiştir.</div>';
                }
                else if($_GET["durum"] == "0")
                {
                    echo '<div class="alert alert-danger">İstenmeyen bir durum oluştu.</div>';
                }
                else if($_GET["durum"] == "3")
                {
                    echo '<div class="alert alert-danger">Sadece pau.edu.tr uzantılı adresler kabul edilir.</div>';
                }
                echo '</div>';
            }
            ?>
            <div class="float-left"><a class="" style="font-size: 0.8em">* Şifrenizi unutursanız e-posta onaylı giriş ile giriş yaptıktan sonra profilim kısmından değiştirebilirsiniz.</a></div>
        </div>
    </div>
    <div class="row d-block d-sm-none d-md-block" style="height:80px"></div>
    <div class="row text-center">
        <div class="offset-md-3 col-md-6 col-sm-12">
            <a class="text-muted">Pamukkale Üniversitesi Yönetim Bilişim Sistemleri Bölümü</a><br/><br/><a class="text-center ml-1" href="hakkinda.php">Hakkında</a>
        </div>
    </div>
</div>
<script src="css/bootstrap.min.js"></script>
</body>
</html>