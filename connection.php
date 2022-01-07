<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "cms";

try {
    $pdo = new PDO('mysql:host=localhost;dbname=cms', 'root', '');
    echo "<h3>Yhteys luotu!</h3>";
} catch(PDOException $e) {
    exit('Epäonnistui');
}
?>