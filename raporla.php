<?php
include "ayar.php";
include "excel.php";

if($_POST)
{
    $liste=mysqli_fetch_all($con->query('SELECT * FROM kullanicilar'));
    $token = md5(uniqid(mt_rand(), true));

    $excel =new Excel();
    $excel->doldur($liste);
    $excel->kaydet($token);

}

?>