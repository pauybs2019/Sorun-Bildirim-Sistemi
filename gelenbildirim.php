<?php
include("ayar.php");
include ("kontrol.php");

include "yetkilikontrol.php";
$baslik = "Gelen Bildirimler - PAÜ İİBF";
$panelbaslik = "Gelen Bildirimler";
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
                        <?php

                        if($_POST)
                        {

                            $kisiid = $_SESSION["id"];
                            if(isset($_POST["onayla"]))
                            {
                                $gelenid = $_POST["onayla"];
                                $sql = "update sorunlar set durum = 1, onaykisid = ".$kisiid.", onaytarih = NOW(), onaysaat = NOW() where sorunid = ".$gelenid;
                                //update sorunlar set durum = 1, onaykisid = 10, onaytarih = NOW(), onaysaat = NOW() where sorunid = 3
                            }
                            else if(isset($_POST["gecersiz"]))
                            {
                                $gelenid = $_POST["gecersiz"];
                                $sql = "update sorunlar set durum = 2, onaykisid = ".$kisiid.", onaytarih = NOW(), onaysaat = NOW() where sorunid = ".$gelenid;                            }
                            echo '<div class="col-md-12">';
                            if ($con->query($sql)) {
                                if(isset($_POST["onayla"]))
                                {
                                    $baslik = "onaylandı";
                                }
                                else if(isset($_POST["gecersiz"]))
                                {
                                    $baslik = "geçersiz";
                                }
                                echo '<div class="alert alert-info mt-1 mb-3 text-center"><h5><p>Bildirim düzenleme işlemi gerçekleşti.</p><p>'.$gelenid.' numaralı bildirim '.$baslik.' olarak işaretlendi.</p></h5></div>';
                            }
                            else
                            {
                                echo '<div class="alert alert-danger mt-1 mb-3 text-center"><h5><p>Bildirim düzenleme işleminde hata oluştu.</p><p>'.$gelenid.' numaralı bildirimde değişiklik yapılamadı.</p></h5></div>';                            }
                            echo '</div>';

                        }


                        ?>

                        <div class="col-md-12">
                            <form action="gelenbildirim.php" method="post">
                                <?php
                                //$sql = "SELECT * FROM birimler,sorunlar where sbirimid = bid and sgonderenid in(select kid from kullanicilar where kid = ".$_SESSION["id"].") ORDER BY sorunid DESC";
                                $sql = "select * from sorunlar where durum = 0 and sbirimid = ".$_SESSION["yetkilibirim"];
                                $result = $con->query($sql);
                                $sayac = 0;
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                            $sorun = $row["sorunaciklama"];
                                            $id = $row["sorunid"];
                                            $saat = $row["sorunsaat"];
                                            $konum = $row["konum"];


                                            $oDate = new DateTime($row["soruntarih"]);
                                            $tarih = $oDate->format("d.m.Y");

                                            echo '
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <p class="card-text"><b>Tarih:</b> ' . $tarih . ' ' . $saat . ' <a class="float-right mr-0"><b>Konum:</b> ' . $konum . '</a></p>
                                                <p class="card-text"><b>Sorun:</b> ' . $sorun . '</p>
                                            </div>
                                            <div class="card-footer text-muted">
                                                <div class="float-right">
                                                    <button name="gecersiz" class="btn btn-secondary btn-sm" type="submit" value="'.$id.'">Geçersiz Olarak İşaretle</button>
                                                    <button name="onayla" class="btn btn-info btn-sm" type="submit" value="'.$id.'">Onayla</button>
                                                </div>
                                            </div>
                                        </div>
                                        ';
                                    }
                                } else {
                                    echo '<div class="alert alert-info mt-3 mb-3 text-center"><h4>Gelen bildirim yok.</h4></div>';
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
