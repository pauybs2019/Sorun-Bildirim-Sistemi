<?php

if($_SESSION["yetki"] == 0 || $_SESSION["yetki"] == 2)
{
    header("Refresh:0 url=index.php", true, 301);
    exit();
}