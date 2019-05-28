<?php
    include ('ayar.php');
    ob_start();
    session_start();

    if (mysqli_connect_errno())
    {
    echo "Veritabanına bağlanırken hata oluştu: " . mysqli_connect_error();
    }


    include('ust.php');

    if($_POST)
    {
        if(isset($_POST["neposta"]) && isset($_POST["nsifre"]))
        {
            $eposta = $_POST['neposta'];
            $sifre = $_POST['nsifre'];
            rendele($eposta);
            $sql = "select * from kullanicilar where kposta='".$eposta."' and ksifre='".$sifre."' ";
            $sql_check = mysqli_query($con, $sql);

            if(mysqli_num_rows($sql_check))  {
                $sql = mysqli_fetch_assoc(mysqli_query($con,"select * from kullanicilar where kposta='".$eposta."'"));
                $_SESSION["sifreli"] = true;
                $_SESSION["login"] = true;
                $_SESSION["id"] = $sql['kid'];
                $_SESSION["sifre"] = $sql['ksifre'];
                $_SESSION["user"] = $sql['kposta'];
                $_SESSION["onayliposta"] = $sql['oposta'];
                $_SESSION["yetki"] = $sql['yetki'];
                $_SESSION["yetkikodu"] = $sql['yetkikod'];
                $_SESSION["yetkilibirim"] = $sql['yetbirid'];
                header("Location:index.php");
            }
            else
            {
                header("Location:index.php?durum=2");
            }
        }
    }
    if($_GET)
    {
        $token = $_GET['code'];
        $eposta = $_GET['eposta'];

        rendele($eposta);

        $sql_check = mysqli_query($con,"select * from kullanicilar where kposta='".$eposta."' and kod='".$token."' ");

        if(mysqli_num_rows($sql_check))  {

            $sql = "select kodsay from kullanicilar where kposta ='".$eposta."'";
            $tokenkontrol = mysqli_query($con, $sql) or die(mysqli_error($con));

                $tokensayisi = mysqli_fetch_assoc($tokenkontrol);
                $sayi = $tokensayisi['kodsay'];
                if($sayi == 0)
                {
                    $kontrol = 0;
                }
                else
                {
                    $sql = "UPDATE kullanicilar SET kodsay='".($sayi-1)."' WHERE kposta='".$eposta."'";

                    if ($con->query($sql) === TRUE) {
                        $sql = mysqli_fetch_assoc(mysqli_query($con,"select * from kullanicilar where kposta='".$eposta."'"));
                        $_SESSION["sifreli"] = false;
                        $_SESSION["login"] = true;
                        $_SESSION["id"] = $sql['kid'];
                        $_SESSION["user"] = $sql['kposta'];
                        $_SESSION["onayliposta"] = $sql['oposta'];
                        $_SESSION["yetki"] = $sql['yetki'];
                        $_SESSION["yetkikodu"] = $sql['yetkikod'];
                        $_SESSION["yetkilibirim"] = $sql['yetbirid'];
                        $_SESSION["pass"] = $token;
                        header("Location:index.php");
                    }
                }

            echo '<p class="h4 mt-5 ml-5">';
            if($kontrol == 0)
            {
                echo "Bu kod ile giriş hakkınız kalmamış lütfen giriş için yeni istek gönderin.";
            }
            echo '</p><p><a class="btn btn-secondary mt-5 ml-5" href="index.php">Yeni kod iste</a></p>';
        }
        else {
            if($token=="" or $eposta=="") {
                geri(0);
            }
            else {
                geri(0);
            }
        }
    }
    else
    {
        geri();
    }

    function geri($hata)
    {
        if($hata == 1)
        {
            header("Refresh: 0; url=index.php?durum=3");
        }
        else
        {
            header("Refresh: 0; url=index.php");
        }

    }

    function rendele($eposta)
    {
        $dilimler = explode("@", $eposta);
        if($dilimler[1] != "pau.edu.tr" || $dilimler[1] != "posta.pau.edu.tr")
        {
            geri(1);
        }
    }

?>
<script src="css/bootstrap.min.js"></script>
</body>
</html>
