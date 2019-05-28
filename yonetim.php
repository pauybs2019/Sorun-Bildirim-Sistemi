<?php
include("ayar.php");

include ("kontrol.php");
include "yoneticikontrol.php";
$baslik = "Yönetim - PAÜ İİBF";
$panelbaslik = "Yönetim";
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

                            $sql = "select count(*) as toplam from kullanicilar";
                            $sonuc = mysqli_fetch_assoc(mysqli_query($con,$sql));
                            $kayitli = $sonuc['toplam'];

                            $sql = "select count(*) as toplam from sorunlar where durum = 2";
                            $sonuc = mysqli_fetch_assoc(mysqli_query($con,$sql));
                            $basarisiz = $sonuc['toplam'];

                            $sql = "select count(*) as toplam from sorunlar";
                            $sonuc = mysqli_fetch_assoc(mysqli_query($con,$sql));
                            $toplam = $sonuc['toplam'];

                            $sql = "select count(*) as toplam from sorunlar where durum = 1";
                            $sonuc = mysqli_fetch_assoc(mysqli_query($con,$sql));
                            $basarili = $sonuc['toplam'];

                            $sql = "select count(*) as toplam from sorunlar where durum = 0";
                            $sonuc = mysqli_fetch_assoc(mysqli_query($con,$sql));
                            $bekleyen = $sonuc['toplam'];

                            ?>
                            <div class="card-columns">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white">Kayıtlı Kişi Sayısı</div>
                                    <div class="card-body">
                                        <h1 class="card-title"><?php echo $kayitli ?></h1>
                                    </div>
                                </div>
                                <div class="card border-warning">
                                    <div class="card-header bg-warning text-white">Toplam Bildirim</div>
                                    <div class="card-body">
                                        <h1 class="card-title"><?php echo $toplam ?></h1>
                                    </div>
                                </div>
                                <div class="card border-success">
                                    <div class="card-header bg-success text-white">Başarılı Bildirim</div>
                                    <div class="card-body">
                                        <h1 class="card-title"><?php echo $basarili ?></h1>
                                    </div>
                                </div>
                                <div class="card border-danger">
                                    <div class="card-header bg-danger text-white">Başarısız Bildirim</div>
                                    <div class="card-body">
                                        <h1 class="card-title"><?php echo $basarisiz ?></h1>
                                    </div>
                                </div>
                                <div class="card border-info">
                                    <div class="card-header bg-info text-white">Bekleyen Bildirim</div>
                                    <div class="card-body">
                                        <h1 class="card-title"><?php echo $bekleyen ?></h1>
                                    </div>
                                </div>
                            </div>
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
