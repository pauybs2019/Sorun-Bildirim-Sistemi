<?php
include("ayar.php");

include ("kontrol.php");
include "yoneticikontrol.php";
$baslik = "Kullanıcılar - PAÜ İİBF";
$panelbaslik = "Kullanıcılar";
include('ust.php');
?>

<div class="container-fluid" style="margin-top: 25px;">
    <div class="row">
        <div class="offset-1 col-md-11">
            <div class="row">
                <div class="col-md-3">

                    <?php

                    include "menuyaz.php";

                    ?>
                </div>
                <div class="col-md-8">
                    <div class="container">
                        <?php
                        include "panel.php";
                        ?>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="kullanicilar.php" method="post">
                            <?php

                                if($_POST)
                                {
                                    if(isset($_POST["aktifpasif"]))
                                    {
                                        $sql = "select * from kullanicilar where kid = ".$_POST["aktifpasif"];
                                        $sonuc = $con->query($sql)->fetch_assoc();
                                        if($sonuc["aktif"] == 0)
                                        {
                                            $sql = "update kullanicilar set aktif = 1 where kid =".$_POST["aktifpasif"];
                                        }
                                        else if($sonuc["aktif"] == 1)
                                        {
                                            $sql = "update kullanicilar set aktif = 0 where kid =".$_POST["aktifpasif"];
                                        }

                                        if($con->query($sql))
                                        {
                                            echo '<div class="alert alert-info"><a>İşlem başarılı.</a></div>';
                                        }
                                        else
                                        {
                                            echo '<div class="alert alert-danger"><a>Bir hata ile karşılaşıldı.</a></div>';
                                        }

                                    }
                                }

                                $sql = "SELECT COUNT(*) AS toplam FROM kullanicilar";
                                include "sayfalamaust.php";
                                $sql = "select * from kullanicilar order by kid desc ". $ek;
                                $sonuc = $con->query($sql);
                                if($sonuc->num_rows > 0)
                                {
                                    while($veriler = $sonuc->fetch_assoc())
                                    {
                                        if($veriler["kid"] != $_SESSION["id"])
                                        {
                                            $kid = $veriler["kid"];
                                            $eposta = $veriler["kposta"];
                                            $oposta = $veriler["oposta"];
                                            $onay = $veriler["onay"];
                                            $yetki = $veriler["yetki"];
                                            $yetkikod = $veriler["yetkikod"];
                                            $yetbirid = $veriler["yetbirid"];
                                            $aktif = $veriler["aktif"];

                                            if($aktif == 1)
                                            {
                                                $aktif = "Aktif";
                                            }
                                            else if($aktif == 0)
                                            {
                                                $aktif = "Pasif";
                                            }

                                            if($oposta == "")
                                            {
                                                $oposta = "-";
                                            }

                                            if($yetki == "0")
                                            {
                                                $yetki = "Kullanıcı";
                                            }
                                            else if($yetki == "1")
                                            {
                                                $yetki = "Yetkili";
                                            }
                                            else if($yetki == "2")
                                            {
                                                $yetki = "Yönetici";
                                            }

                                            if($yetkikod == "0")
                                            {
                                                $yetkikod1 = "";
                                            }
                                            else if($yetkikod == "1")
                                            {
                                                $yetkikod1 = "Birim Yöneticisi";
                                            }
                                            else if($yetkikod == "2")
                                            {
                                                $yetkikod1 = "Birim Yetkilisi";
                                            }

                                            $birim="";
                                            if($yetkikod == "1" || $yetkikod == "2")
                                            {
                                                $sql = "select bad from birimler where bid = ".$yetbirid;
                                                $veriler = $con->query($sql)->fetch_assoc();
                                                 $birim = $veriler["bad"];
                                            }


                                            echo '
                                        <div class="card mb-3">
                                            <div class="card-body">
                                            <h6 class="card-title">'.$eposta.'</h6>
                                                <div class="card-text">
                                                <div class="row">
                                                    <div class="col-md-4">Kullanıcı ID: <b>'.$kid.'</b></div><div class="col-md-4">İkincil E-posta: <b>'.$oposta.'</b></div> <div class="col-md-4">Durum: <b>'.$aktif.'</b>   </div>   

</div>
</div>
<div class="card-text">
<div class="row">
<div class="col-md-4"><b>'.$yetki.'</b></div><div class="col-md-4"><b>'.$yetkikod1.'</b></div><div class="col-md-4"><b>'.$birim.'</b></div>
</div>

</div>
';
                                            if($yetki != "2")
                                            {
                                                echo '<div class="card-text">
<button class="btn btn-primary float-right" name="aktifpasif" value="'.$kid.'">Aktif/Pasif</button>
</div>';
                                            }

                                            echo '

                                                
                                            </div>
                                        </div>
                                        ';
                                        }

                                    }
                                }
                                include "sayfalama.php";
                            ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('alt.php');
?>
