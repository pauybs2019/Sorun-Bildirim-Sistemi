<?php
include("ayar.php");

include ("kontrol.php");
include "yetkilikontrol.php";
$baslik = "Bildirim Onay Geçmişi - PAÜ İİBF";
$panelbaslik = "Bildirim Onay Geçmişi";
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
                            <form action="bildirimonaygecmisi.php" method="post">
                                <?php
                                //$sql = "SELECT * FROM birimler,sorunlar where sbirimid = bid and sgonderenid in(select kid from kullanicilar where kid = ".$_SESSION["id"].") ORDER BY sorunid DESC";
                                $sql = "select * from sorunlar where durum not in(0) and sbirimid = ".$_SESSION["yetkilibirim"]." order by onaytarih desc";
                                $result = $con->query($sql);
                                $sayac = 0;
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        $sorun = $row["sorunaciklama"];
                                        $id = $row["sorunid"];
                                        $saat = $row["sorunsaat"];
                                        $konum = $row["konum"];
                                        $durum = $row["durum"];
                                        if($durum == 1)
                                        {
                                            $alerttip = "text-info";
                                            $yazi = "Onaylandı.";
                                        }
                                        else if($durum == 2)
                                        {
                                            $alerttip = "text-danger";
                                            $yazi = "Geçersiz olarak işaretlendi.";
                                        }

                                        $oDate = new DateTime($row["soruntarih"]);
                                        $tarih = $oDate->format("d.m.Y");

                                        echo '
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <a class="'.$alerttip.'">'.$yazi.'</a>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text"><b>Tarih:</b> ' . $tarih . ' ' . $saat . ' <a class="float-right mr-0"><b>Konum:</b> ' . $konum . '</a></p>
                                                <p class="card-text"><b>Sorun:</b> ' . $sorun . '</p>
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
