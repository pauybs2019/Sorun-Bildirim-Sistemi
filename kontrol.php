<?php

ob_start();
session_start();

if(!isset($_SESSION['user'])){
    header("Refresh:0 url=index.php", true, 301);
    exit();
}
