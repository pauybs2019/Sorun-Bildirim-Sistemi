<?php
include("ayar.php");

include ("kontrol.php");
include "yetkilikontrol.php";
$baslik = "Bildirim Yaz - PAÜ İİBF";
$panelbaslik = "Bildirim Yaz";
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

                        if($_POST) {
                            echo '<div class="col-md-12">';
                            $kisiid = $_SESSION["id"];
                            if (isset($_POST['txtyazan']) && isset($_POST['txtkonum']) && isset($_POST['txtbirim']) && isset($_POST['txtsorun'])) {
                                $gelenkonum = $_POST['txtkonum'];
                                $gelenbirim = $_POST['txtbirim'];
                                $gelensorun = $_POST['txtsorun'];
                                $gelenposta = $_POST['txtyazan'];

                                $sql = "select * from kullanicilar where kposta = '".$gelenposta."'";
                                $result = $con->query($sql);
                                if ($result->num_rows > 0) {
                                    $sql = "select * from kullanicilar where kposta = '".$gelenposta."'";
                                    $gonderenkisiid = mysqli_fetch_assoc(mysqli_query($con, $sql));
                                    $gonderen = $gonderenkisiid['kid'];
                                }
                                else
                                {
                                    $sql = "insert into kullanicilar(kposta) values('".$gelenposta."')";
                                    if ($con->query($sql)) {
                                        $sql = "select * from kullanicilar where kposta = '".$gelenposta."'";
                                        $gonderenkisiid = mysqli_fetch_assoc(mysqli_query($con, $sql));
                                        $gonderen = $gonderenkisiid['kid'];
                                    }
                                    else{
                                        echo '<div class="alert alert-danger mt-1 mb-3 text-center"><p>Veritabanına yazdırılamadı.</p></div>';
                                    }
                                }
                                $sql = "select bid from birimler where bad = '" . $gelenbirim . "'";
                                $birim = mysqli_fetch_assoc(mysqli_query($con, $sql));
                                @$sql = "insert into sorunlar(sbirimid,sgonderenid,konum,soruntarih,sorunsaat,sorunaciklama) values(" . $birim['bid'] . ", " . $gonderen . ", '" . $gelenkonum . "',NOW(),NOW(), '" . $gelensorun . "')";
                                if ($con->query($sql)) {
                                    echo '<div class="alert alert-info mt-1 mb-3 text-center"><p>Bildirim yazma işlemi gerçekleşti.</p></div>';
                                } else {
                                    echo '<div class="alert alert-danger mt-1 mb-3 text-center"><p>Veritabanına yazdırılamadı.</p></div>';
                                }
                            } else {
                                echo '<div class="alert alert-danger mt-1 mb-3 text-center"><p>Boş alan bırakmayınız.</p></div>';
                            }
                        }
                        ?>

                        <div class="col-md-12">
                            <form action="bildirimyaz.php" method="post">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Sorunu ileten kişinin e-posta adresi</label>
                                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Örneğin aaa@pau.edu.tr" name="txtyazan">
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Sorun yaşanan konum</label>
                                    <input type="text" class="form-control" id="exampleFormControlInput2" placeholder="Örneğin A-B1-16" name="txtkonum" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Gönderilecek birim</label>
                                    <select class="form-control" id="exampleFormControlSelect1" name="txtbirim" required>
                                        <?php

                                        $sql = "select * from birimler";
                                        $result = $con->query($sql);
                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc())
                                            {
                                                if($row["aktiflik"] == 1)
                                                {
                                                    echo '<option>'.$row["bad"].'</option>';
                                                }
                                            }
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Sorun</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Sorunu yazın" rows="5" name="txtsorun" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary mb-2 float-right">Gönder</button>
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
