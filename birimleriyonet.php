<?php
include("ayar.php");

include ("kontrol.php");
include "yoneticikontrol.php";
$baslik = "Birimleri Yönet - PAÜ İİBF";
$panelbaslik = "Birimleri Yönet";
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

                            if($_POST && isset($_POST))
                            {
                                if(isset($_POST["duzenle"]))
                                {

                                }

                                if(isset($_POST["pasif"]))
                                {
                                    $birimadi="";
                                    $birimid = $_POST["pasif"];
                                    $sql = "select * from birimler where bid = ".$_POST["pasif"];
                                    if($sonuc = $con->query($sql))
                                    {
                                        while($sonuc2 = $sonuc->fetch_assoc())
                                        {
                                            $durum = $sonuc2["aktiflik"];
                                            $birimadi = $sonuc2["bad"];
                                        }
                                    }
                                    if($durum == 1)
                                    {
                                        $sql = "update birimler set aktiflik = 0 where bid = ".$birimid;
                                    }
                                    else
                                    {
                                        $sql = "update birimler set aktiflik = 1 where bid = ".$birimid;
                                    }

                                    if($con->query($sql) === TRUE)
                                    {
                                        if($durum == 1)
                                        {
                                            $sekil = "alert-warning";
                                            $metin = $birimid." numaralı ".$birimadi." birimi pasifleştirildi.";
                                        }
                                        else
                                        {
                                            $sekil = "alert-success";
                                            $metin = $birimid." numaralı ".$birimadi." birimi aktifleştirildi.";
                                        }
                                        echo '<div class="alert '.$sekil.'"><a>'.$metin.'</a></div>';
                                    }
                                    else
                                    {

                                    }
                                }
                            }

                            ?>
                            <form action="birimleriyonet.php" method="post">
                                <?php
                                    $sql = "SELECT COUNT(*) AS toplam FROM birimler";

                                    include "sayfalamaust.php";

                                    $sql = "select * from birimler order by bid asc ".$ek;
                                    $bid = array();
                                    $bad = array();
                                    $aktiflik = array();
                                    if($sonuc = $con->query($sql))
                                    {
                                        while($sonuc2 = $sonuc->fetch_array())
                                        {
                                            array_push($bid, $sonuc2["bid"]);
                                            array_push($bad, $sonuc2["bad"]);
                                            array_push($aktiflik, $sonuc2["aktiflik"]);
                                        }

                                        foreach ($bid as $i => $value) {
                                            $yonetici = "";
                                            $calisan = array();
                                            $sql = "select * from kullanicilar where yetbirid = ".$bid[$i];
                                            if($con->query($sql))
                                            {
                                                $result2 = $con->query($sql);
                                                if ($result2->num_rows > 0) {
                                                    while($sonuc2 = $result2->fetch_assoc()) {
                                                        if($sonuc2["yetkikod"] == "1")
                                                        {
                                                            $yonetici = $sonuc2["kposta"];
                                                        }
                                                        if($sonuc2["yetkikod"] == "2")
                                                        {
                                                            array_push($calisan, $sonuc2["kposta"]);
                                                        }
                                                    }
                                                }
                                            }
                                                if($aktiflik[$i] == 1)
                                                {
                                                    $badge = "badge-success";
                                                    $aktiflikkontrol = "Aktif";
                                                }
                                                else
                                                {
                                                    $badge = "badge-danger";
                                                    $aktiflikkontrol = "Pasif";
                                                }
                                                echo '
                                    
                                    <div class="card mb-4">
                                            <div class="card-header">
                                                <b>'.$bad[$i].'</b><span class="badge '.$badge.' float-right"><a style="font-size: 1.2em; font-weight: normal; margin: 10px">'.$aktiflikkontrol.'</a></span>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text"><b>Yönetici:</b> '.$yonetici.'</p>
                                                <p class="card-text"><b>Çalışanlar:</b> ';

                                                foreach ($calisan as $j => $value) {
                                                    echo $calisan[$j]. " ";
                                                }

                                                echo  '</p>
                                            <p class="card-text" style="color:white"><a class="btn btn-primary float-right" href="birimekle.php?birim='.$bid[$i].'">Düzenle</a><button type="submit" class="btn btn-secondary float-right mr-2" name="pasif" value="'.$bid[$i].'">Aktif/Pasif</button></p>
                                            </div>
                                        </div>
                                    
                                    ';




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
