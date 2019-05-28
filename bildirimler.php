<?php
include("ayar.php");

include ("kontrol.php");
include "genelkontrol.php";
$baslik = "Bildirimlerim - PAÜ İİBF";
$panelbaslik = "Bildirimlerim";
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
                    <hr class="mb-4">
                    <div class="row">
                        <?php
                        if(isset($_POST["sil"]))
                        {
                            echo '<div class="col-md-12">';
                            $sql = "update sorunlar set aktiflik = 0 where sorunid = ".$_POST["sil"];
                            if ($con->query($sql)) {
                                echo '<div class="alert alert-danger mt-3 mb-3 text-center"><h4>Bildiriminiz silindi.</h4></div>';
                            }
                            else
                            {
                                echo '<div class="alert alert-danger mt-3 mb-3 text-center"><h4>Silme işleminde hata oluştu.</h4></div>';
                            }
                            echo '</div>';
                        }
                        ?>
                        <div class="col-md-12">
                            <form action="bildirimler.php" method="post">
                            <?php
                                $sql = "SELECT * FROM birimler,sorunlar where sbirimid = bid and sgonderenid in(select kid from kullanicilar where kid = ".$_SESSION["id"].") ORDER BY sorunid DESC";
                                $result = $con->query($sql);
                                $sayac = 0;
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        $aktifmi = $row["aktiflik"];
                                        if($aktifmi == 1) {
                                            $sayac++;

                                            $sorun = $row["sorunaciklama"];
                                            $id = $row["sorunid"];
                                            $saat = $row["sorunsaat"];
                                            $konum = $row["konum"];
                                            $durum = $row["durum"];


                                            $oDate = new DateTime($row["soruntarih"]);
                                            $tarih = $oDate->format("d.m.Y");

                                            if ($row["durum"] == 0) {
                                                $alerttip = "text-info";
                                                $birim = $row["bad"];
                                                $badgetip = "badge-info";
                                                $durum = "Bekliyor";
                                                $birimyazi = "birimine iletildi.";

                                            } else if ($row["durum"] == 1) {
                                                $alerttip = "text-success";
                                                $birim = $row["bad"];
                                                $badgetip = "badge-success";
                                                $durum = "Başarılı";
                                                $birimyazi = "birimi tarafından onaylandı.";
                                            } else {
                                                $alerttip = "";
                                                $birim = $row["bad"];
                                                $badgetip = "badge-dark";
                                                $durum = "Başarısız";
                                                $birimyazi = "birimi tarafından geçersiz olarak işaretlendi.";
                                            }

                                            echo '
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <a class="' . $alerttip . '">' . $birim . ' '.$birimyazi.'</a><span class="badge ' . $badgetip . ' float-right"><a style="font-size: 1.2em; font-weight: normal; margin: 10px">' . $durum . '</a></span>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text"><b>Tarih:</b> ' . $tarih . ' ' . $saat . ' <a class="float-right mr-0"><b>Konum:</b> ' . $konum . '</a></p>
                                                <p class="card-text"><b>Sorun:</b> ' . $sorun . '</p>

                                            </div>
                                            
                                                
                                                ';
                                            if ($row["durum"] == 0) {

                                                echo '
                                            <div class="card-footer text-muted">
                                                <div class="float-right">
                                                    <button name="islem" class="btn btn-info btn-sm" type="submit" value="guncelle">Güncelle</button>
                                                    <button name="sil" class="btn btn-secondary btn-sm" type="submit" value="'.$id.'">Sil</button>
                                                </div>
                                            </div>
                                                    ';

                                            }
                                            echo '
                                                
                                                
                                        </div>
                                        ';
                                        }
                                    }
                                } if(0 == $sayac) {
                                    echo '<div class="alert alert-info mt-3 mb-3 text-center"><h4>Hiç bildiriminiz bulunmamakta.</h4></div>';
                            }


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
