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
                <h1 class="h4 mb-3 font-weight-normal">Kayıt Ol</h1>
                <div class="form-group">
                    <?php
                    $geleneposta = "";
                    if($_POST && isset($_POST["keposta"]))
                    {
                        $geleneposta = $_POST["keposta"];
                    }
                    ?>
                    <input id="inputEmail" name="keposta" type="email" class="form-control" placeholder="ornek@posta.pau.edu.tr" value ="<?php echo $geleneposta?>" required autofocus>
                </div>
                <div class="form-group">
                    <input name="ksifre" type="password" id="inputPassword" class="form-control" placeholder="Şifre" required>
                </div>
                <div class="form-group">
                    <input name="ksifre2" type="password" id="inputPassword2" class="form-control" placeholder="Tekrar Şifre" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Kayıt Ol</button>
                </div>
                <div class="form-group">
                    <a href="index.php" class="btn btn-secondary btn-block">Geri Dön</a>
                </div>
            </form>
            <?php

            if($_POST)
            {
                if(isset($_POST["keposta"]) && isset($_POST["ksifre"]) && isset($_POST["ksifre2"]))
                {
                    $eposta = $_POST["keposta"];
                    $sifre = $_POST["ksifre"];
                    $sifre2 = $_POST["ksifre2"];

                    if($_POST["ksifre"] == $_POST["ksifre2"])
                    {
                        $sql = "select * from kullanicilar where kposta ='".$_POST["keposta"]."'";
                        $result = mysqli_query($con, $sql) or die(mysqli_error($con));
                        if(mysqli_num_rows($result) > 0)
                        {
                            $sql = "select ksifre from kullanicilar where kposta = '$eposta'";
                            $sql_check = mysqli_query($con,$sql);
                            $sqlSonuc = mysqli_fetch_assoc($sql_check);
                            $gelensifre = $sqlSonuc["ksifre"];
                            $kontrol = false;
                            $mesaj = "Kullanıcı zaten kayıtlı lütfen e-posta onaylı giriş üzerinden giriş yaparak profil kısmından şifre belirleyin.";
                        }
                        else // kullanici yoksa
                        {
                            $token = md5(uniqid(mt_rand(), true));
                            $sql = "insert into kullanicilar(kposta, ksifre, kod) values('$eposta', '$sifre', '$token')";
                            if($con->query($sql) === true)
                            {
                                $kontrol = true;
                                $mesaj = "Kullanıcı oluşturma işlemi başarılı. Lütfen e-posta adresinize gelen link üzerinden doğrulayın.";
                            }
                            else // kullanici eklenemezse
                            {
                                $kontrol = false;
                                $mesaj = "Kullanıcı eklenirken bir hata oluştu. Lütfen e-posta onaylı giriş alanını deneyin. ".$con->error;
                            }
                        }
                    }
                    else // şifreler eşit değilse
                    {
                        $kontrol = false;
                        $mesaj = "Girdiğiniz şifreler aynı değil lütfen tekrar deneyin.";
                    }
                    if($kontrol)
                    {
                        echo '<div class="alert alert-success"><a>'.$mesaj.'</a></div>';
                    }
                    else if(!$kontrol)
                    {
                        echo '<div class="alert alert-danger"><a>'.$mesaj.'</a></div>';
                    }
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