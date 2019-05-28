<?php
session_start();
session_unset();
session_destroy();
header("Refresh:0 url=index.php", true, 301);
