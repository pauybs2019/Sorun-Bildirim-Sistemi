<?php

include("ayar.php");

include ("kontrol.php");
include "genelkontrol.php";
$baslik = "Bildirim Yap - PAÜ İİBF";
$panelbaslik = "Bildirim Yap";
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
                                <hr/>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                    if($_GET && isset($_GET['durum']))
                                    {
                                        if($_GET['durum'] == 1)
                                        {
                                            echo '<div class="alert alert-danger"><a>Boş veya eksik doldurdunuz.</a></div>';
                                        }
                                        else if($_GET['durum'] == 2)
                                        {
                                            echo '<div class="alert alert-success"><a>Bildiriminiz gönderildi.</a></div>';
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="col-md-12">
                                    <form method="post" action="bildirimkontrol.php">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Sorun yaşanan konum</label>
                                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Örneğin A-B1-16" name="txtkonum" required>
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