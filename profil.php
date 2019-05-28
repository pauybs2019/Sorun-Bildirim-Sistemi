<?php

include("ayar.php");

include ("kontrol.php");
$baslik = "Profilim - PAÜ İİBF";
$panelbaslik = "Profilim";
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
                            <?php
                            $hata = 0;
                            if($_GET)
                            {
                                if(isset($_GET['txtikincil']) && filter_var($_GET['txtikincil'], FILTER_VALIDATE_EMAIL))
                                {
                                    $sql = "update kullanicilar set oposta = '".$_GET['txtikincil']."' where kid = ".$_SESSION['id'];
                                    if ($con->query($sql) === TRUE) {
                                        $_SESSION["onayliposta"] = $_GET['txtikincil'];
                                        $hata=1;
                                    }
                                    else
                                    {
                                        $hata=2;
                                    }
                                }
                                else
                                {
                                    $hata=3;
                                }
                            }

                            ?>
                            <div class="col-md-6">
                                <form method="get" action="profil.php">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">İkincil E-posta</label>
                                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Örneğin eposta@gmail.com" name="txtikincil" value="<?php echo $_SESSION['onayliposta'] ?>" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary mb-2 float-right">Güncelle</button>
                                </form>

                            </div>
                            <div class="col-md-6">

                                <form method="post" action="profil.php">
                                    <?php
                                    if($_SESSION["sifreli"])
                                    {
                                        echo '
                                        <div class="form-group">
                                        <label for="exampleFormControlInput11">Şifre</label>
                                        <input type="password" class="form-control" id="exampleFormControlInput11" name="txtsif" required>
                                    </div>
                                    ';
                                    }
                                    ?>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput12">Yeni Şifre</label>
                                        <input type="password" class="form-control" id="exampleFormControlInput12" name="txtsifyeni" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput13">Yeni Şifre Tekrar</label>
                                        <input type="password" class="form-control" id="exampleFormControlInput13" name="txtsifyenitekrar" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-muted">* Eğer şifre belirlememişseniz "Yeni Şifre" ve "Yeni Şifre Tekrar" alanlarını doldurmanız yeterlidir.</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary mb-2 float-right">Şifremi Değiştir</button>
                                </form>



                            </div>
                            <div class="col-md-12">
                                <?php
                                if($hata == 1)
                                {
                                    echo '<div class="alert alert-info mt-1 mb-1"><a>İkincil e-posta güncelleme işlemi başarılı.</a></div>';
                                }
                                if($hata == 2)
                                {
                                    echo '<div class="alert alert-danger mt-1 mb-1"><a>Güncelleme işlemi başarısız.</a></div>';
                                }
                                if($hata == 3)
                                {
                                    echo '<div class="alert alert-danger mt-1 mb-1"><a>Yapılan giriş e-posta değil.</a></div>';
                                }
                                if($_POST)
                                {

                                    if(isset($_POST['txtsifyeni']) && isset($_POST['txtsifyenitekrar']) && $_POST['txtsifyeni'] == $_POST['txtsifyenitekrar'])
                                    {

                                        if($_SESSION["sifreli"] && isset($_POST['txtsif']))
                                        {
                                            if($_SESSION['sifre'] == $_POST['txtsif'])
                                            {
                                                $sql = "update kullanicilar set ksifre = '".$_POST['txtsifyeni']."' where kid = ".$_SESSION['id'];
                                                if ($con->query($sql) === TRUE) {
                                                    $_SESSION["sifreli"] = true;
                                                    $_SESSION["sifre"] = $_POST['txtsifyeni'];
                                                    echo '<div class="alert alert-info mt-1 mb-1"><a>Şifre yenileme işlemi başarılı.</a></div>';
                                                }
                                                else
                                                {
                                                    echo '<div class="alert alert-danger mt-1 mb-1"><a>İşlem başarısız.</a></div>';
                                                }
                                            }
                                            else
                                            {
                                                echo '<div class="alert alert-danger mt-1 mb-1"><a>Girdiğiniz şifre kullandığınız şifre ile uyuşmuyor. E-Posta onaylı giriş yöntemini deneyebilirsiniz.</a></div>';
                                            }
                                        }
                                        else
                                        {
                                            $sql = "update kullanicilar set ksifre = '".$_POST['txtsifyeni']."' where kid = ".$_SESSION['id'];
                                            if ($con->query($sql) === TRUE) {
                                                $_SESSION["sifreli"] = true;
                                                $_SESSION["sifre"] = $_POST['txtsifyeni'];
                                                echo '<div class="alert alert-info mt-1 mb-1"><a>Şifre yenileme işlemi başarılı.</a></div>';
                                            }
                                            else
                                            {
                                                echo '<div class="alert alert-danger mt-1 mb-1"><a>İşlem başarısız.</a></div>';
                                            }
                                        }
                                    }
                                }

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