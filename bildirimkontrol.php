<?php

include ("ayar.php");

ob_start();
session_start();

if($_POST)
{
    if(isset($_POST['txtkonum']) || isset($_POST['txtbirim']) || isset($_POST['txtsorun']))
    {
        $gelenkonum = $_POST['txtkonum'];
        $gelenbirim = $_POST['txtbirim'];
        $gelensorun = $_POST['txtsorun'];
        $sql = "select bid from birimler where bad = '".$gelenbirim."'";
        $birim = mysqli_fetch_assoc(mysqli_query($con, $sql));
        @$sql = "insert into sorunlar(sbirimid,sgonderenid,konum,soruntarih,sorunsaat,sorunaciklama) values(".$birim['bid'].", ".$_SESSION["id"].", '".$gelenkonum."',NOW(),NOW(), '".$gelensorun."')";
        if($con->query($sql) === TRUE)
        {
            reddet(2);
        }
        else
        {
            reddet(1);
        }
    }
    else
    {
        reddet(1);
    }
}
else
{
    reddet(1);
}

function reddet($gdurum)
{
    header("Refresh:0 url=bildirimyap.php?durum=$gdurum", true, 301);
}