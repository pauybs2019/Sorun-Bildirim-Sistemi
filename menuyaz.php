<div class="row">
    <div class="col-md-12">
        <a href="http://iibf.pau.edu.tr"><img class="" - src="img/logo.png" alt="PAÜ İktisadi ve İdari Bilimler Fakültesi" width="80" height="128"/></a>
    </div>
</div>
    <hr/>
<div class="row">
    <div class="col-md-12">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <?php
            if($_SESSION["yetki"] == 0)
            {
                $menulink = array("bildirimyap.php", "bildirimler.php");
                $menubaslik = array("Sorun Bildir", "Bildirimlerim");

            }
            if($_SESSION["yetki"] == 1)
            {
                $menulink = array("gelenbildirim.php", "bildirimonaygecmisi.php", "bildirimyaz.php");
                $menubaslik = array("Gelen Bildirimler","Bildirim Onay Geçmişi","Bildirim Yaz");
            }
            if($_SESSION["yetki"] == 2)
            {
                $menulink = array("yonetim.php", "birimleriyonet.php", "birimekle.php", "tumbildirimler.php", "kullanicilar.php","bildirimyap.php" ,"rapor.php");
                $menubaslik = array("Genel Bakış", "Birimleri Yönet", "Birim Ekle", "Tüm Bildirimler", "Kullanıcılar","Bildirim Yap", "Raporlama");
            }
                for ($i = 0; $i < count($menubaslik); $i++)
                {
                    if($suankisayfa == $menulink[$i])
                    {
                        $aktiflik = " active";
                    }
                    else
                    {
                        $aktiflik = "";
                    }
                    echo '<a class="nav-link'.$aktiflik.'" href="'.$menulink[$i].'">'.$menubaslik[$i].'</a>';
                }
            ?>
        </div>
    </div>
</div>
