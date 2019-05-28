<?php
$sayfada = 11; // sayfada gösterilecek içerik miktarını belirtiyoruz.

$sorgu = mysqli_query($con,$sql);
$sonuc = mysqli_fetch_assoc($sorgu);
$toplam_icerik = $sonuc['toplam'];

$toplam_sayfa = ceil($toplam_icerik / $sayfada);

$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;

if($sayfa < 1) $sayfa = 1;
if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa;

$limit = ($sayfa - 1) * $sayfada;

$ek = " LIMIT " . $limit . ", " . $sayfada;