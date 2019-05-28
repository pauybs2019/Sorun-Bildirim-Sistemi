<?php
include("ayar.php");

include ("kontrol.php");
include "yoneticikontrol.php";
$baslik = "Birim Ekle - PAÜ İİBF";
$panelbaslik = "Birim Ekle";
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
                            <?php
                            $birimid = "";
                            $birimadi = "";
                            $yonetici = "";
                            $calisanlar = "";
                            $kaydet = 0;

                            if($_POST)
                            {
                                if(isset($_POST["txtbirimadi"]) && isset($_POST["txtyonetici"]) && isset($_POST["txtcalisanlar"]))
                                {
                                    $birimid = $_POST["txtbirimid"];
                                    if($_POST["duzenleme"] == "1")
                                    {
                                        $kaydet = 1;
                                        $sql = "select * from kullanicilar where kposta = '".$_POST["txtyonetici"]."'";
                                        if($con->query($sql)->num_rows > 0)
                                        {
                                            $sql = "update kullanicilar set yetki = 1, yetkikod = 1, yetbirid = ".$_POST["txtbirimid"]." where kposta = '".$_POST["txtyonetici"]."'";
                                        }
                                        else
                                        {
                                            $sql = "insert into kullanicilar(kposta,yetki,yetkikod,yetbirid) values('".$_POST["txtyonetici"]."',1,1,".$_POST["txtbirimid"].")";
                                        }
                                        if($con->query($sql))
                                        {
                                            $metin = rtrim($_POST["txtcalisanlar"]);
                                            $calisanlar = explode(' ', $metin);
                                            for($i = 0; $i < count($calisanlar); $i++)
                                            {
                                                $sql = "select * from kullanicilar where kposta ='".$calisanlar[$i]."'";
                                                $result = mysqli_query($con, $sql) or die(mysqli_error($con));
                                                if(mysqli_num_rows($result) > 0)
                                                {
                                                    $sql = "update kullanicilar set yetki=1, yetkikod = 2, yetbirid = ".$birimid." where kposta = '".$calisanlar[$i]."'";
                                                }
                                                else
                                                {
                                                    $sql = "insert into kullanicilar(kposta,yetki,yetkikod,yetbirid) values('".$calisanlar[$i]."',1,2,".$birimid.")";
                                                }
                                                if($con->query($sql))
                                                {
                                                    $hata = false;
                                                }
                                                else {
                                                    echo '<div class="alert alert-danger"><a>Kullanıcı eklemede hata.</a></div>';
                                                    break;
                                                }
                                            }
                                            if(!$hata)
                                            {
                                                echo '<div class="alert alert-success"><a>Başarılı.</a></div>';
                                            }
                                        }

                                    }
                                    else
                                    {
                                        $sql = "select * from birimler where bad ='".$_POST["txtbirimadi"]."'";
                                        if($con->query($sql)->num_rows < 1)
                                        {
                                            $sql = "insert into birimler(bad) values('".$_POST["txtbirimadi"]."')";
                                            if($con->query($sql))
                                            {
                                                $sql = "select * from birimler where bad = '".$_POST["txtbirimadi"]."'";

                                                $result = $con->query($sql);
                                                $birimid = "";
                                                if ($result->num_rows > 0) {
                                                    // output data of each row
                                                    while($row = $result->fetch_assoc()) {

                                                        $birimid = $row["bid"];
                                                    }
                                                }

                                                $sql = "select * from kullanicilar where kposta = '".$_POST["txtyonetici"]."'";
                                                if($con->query($sql)->num_rows > 0)
                                                {
                                                    $sql = "update kullanicilar set yetki = 1, yetkikod = 1, yetbirid = ".$birimid." where kposta = '".$_POST["txtyonetici"]."'";
                                                }
                                                else
                                                {
                                                    $sql = "insert into kullanicilar(kposta,yetki,yetkikod,yetbirid) values('".$_POST["txtyonetici"]."',1,1,".$birimid.")";
                                                }
                                                if($con->query($sql))
                                                {
                                                    $calisanlar = explode(' ', $_POST["txtcalisanlar"]);
                                                    for($i = 0; $i < count($calisanlar); $i++)
                                                    {
                                                        $sql = "select * from kullanicilar where kposta ='".$calisanlar[$i]."'";
                                                        $result = mysqli_query($con, $sql) or die(mysqli_error($con));
                                                        if(mysqli_num_rows($result) > 0)
                                                        {
                                                            $sql = "update kullanicilar set yetki=1, yetkikod = 2, yetbirid = ".$birimid." where kposta = '".$calisanlar[$i]."'";
                                                        }
                                                        else
                                                        {
                                                            $sql = "insert into kullanicilar(kposta,yetki,yetkikod,yetbirid) values('".$calisanlar[$i]."',1,2,".$birimid.")";
                                                        }
                                                        if($con->query($sql))
                                                        {
                                                            $hata = false;
                                                        }
                                                        else {
                                                            echo '<div class="alert alert-danger"><a>Kullanıcı eklemede hata.</a></div>';
                                                            break;
                                                        }
                                                    }
                                                    if(!$hata)
                                                    {
                                                        echo '<div class="alert alert-success"><a>Başarılı.</a></div>';
                                                    }
                                                }
                                            }
                                        }
                                        else
                                        {
                                            echo '<div class="alert alert-danger"><a>Bu isimde bir birim var. Lütfen birimleri yönet sayfasından düzenleyi tıklayın.</a></div>';
                                        }
                                    }
                                    $birimid = $_POST["txtbirimid"];
                                    $birimadi = $_POST["txtbirimadi"];
                                    $yonetici = $_POST["txtyonetici"];
                                    $calisanlar = $_POST["txtcalisanlar"];

                                }
                            }

                            if($_GET)
                            {
                                if(isset($_GET['birim']))
                                {
                                    $birimid = $_GET['birim'];

                                    $sql = "select * from birimler where bid = ".$_GET['birim'];
                                    $sonuc = mysqli_fetch_assoc(mysqli_query($con,$sql));
                                    $birimadi = $sonuc['bad'];

                                    $sql = "select * from kullanicilar where yetbirid = ".$_GET['birim'];
                                    $sonuc = mysqli_fetch_assoc(mysqli_query($con,$sql));
                                    $yonetici = $sonuc['kposta'];


                                    $sql = "select * from kullanicilar where yetkikod = 2";
                                    $sonuc = $con->query($sql);

                                    while($row = $sonuc->fetch_assoc())
                                    {
                                        if($row['yetbirid'] == $birimid)
                                        {
                                            $calisanlar .= $row['kposta'] . " ";
                                        }
                                    }
                                    $kaydet = 1;
                                }
                            }

                            echo '
                            <form method="post" action="birimekle.php">
                                <div class="form-group" hidden>
                                    <input type="text" class="form-control" name="duzenleme" value="'.$kaydet.'">
                                </div>
                                <div class="form-group" hidden>
                                    <label for="exampleFormControlInput0">Birim ID</label>
                                    <input type="text" class="form-control" id="exampleFormControlInput0" placeholder="" name="txtbirimid" value="'.$birimid.'">
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Birim Adı</label>
                                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="" name="txtbirimadi" value="'.$birimadi.'" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlInput12">Yönetici E-Posta Adresi</label>
                                    <input type="text" class="form-control" id="exampleFormControlInput12" placeholder="" name="txtyonetici" value="'.$yonetici.'" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Çalışanların E-Posta Adresleri</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Aralarına boşluk bırakarak yazın." rows="5" name="txtcalisanlar" required>'.$calisanlar.'</textarea>
                                </div>
                                ';

                            if(isset($_GET['birim']))
                            {
                                echo '<button type="submit" class="btn btn-primary mb-2 float-right">Kaydet</button>';
                            }
                            else
                            {
                                echo '<button type="submit" class="btn btn-primary mb-2 float-right">Ekle</button>';
                            }


                            echo '
                            </form>
                            ';
                            ?>
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
