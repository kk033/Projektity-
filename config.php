<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tunnukset');

    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
//tarkista yhteys
    if($link === false){
        die("ERROR: Ei voitu yhdistää. " . mysqli_connect_error());
    } else {
        echo "!";
    }
?>