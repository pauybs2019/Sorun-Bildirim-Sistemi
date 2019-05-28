<?php
include("ayar.php");

include ("kontrol.php");
include "yoneticikontrol.php";
include "excel.php";
$baslik = "Raporlama - PAÜ İİBF";
$panelbaslik = "Raporlama";
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

                            <form action="raporla.php" method="post">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Rapor Türü</label>
                                    <select class="form-control" id="exampleFormControlSelect1" name="txtbirim" required>
                                        <option>Kişi listesi</option>
                                    </select>
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
