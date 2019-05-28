<?php
$con=mysqli_connect("localhost","u361522097_pau","",""); // Güvenlik nedeniyle bu alan boş bırakılmıştır.
mysqli_query($con,"SET NAMES 'utf8'");
mysqli_query($con, "SET CHARACTER SET utf8_general_ci");

function paukontrol($eposta)
{
    $dilimler = explode("@", $eposta);
    $dilimler2 = explode(".", $dilimler[1]);
    if(count($dilimler2) == 4)
    {
        if($dilimler2[0] == "posta" and $dilimler2[1] == "pau" and $dilimler2[2] == "edu" and $dilimler2[3] == "tr")
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else if(count($dilimler2) == 3)
    {
        if($dilimler2[0] == "pau" and $dilimler2[1] == "edu" and $dilimler2[2] == "tr")
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>