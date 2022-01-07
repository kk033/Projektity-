<!DOCTYPE html>
<?php

include_once 'connection.php';
include_once 'article.php';

// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo "<h1>Sinun pitää olla kirjautuneena sisään lukeaksesi artikkeleita</h1>";
    header( "Refresh:3; url='kirjaudu.php'");
    exit;
}


$article = new Article;


if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = $article->fetch_data($id);
    

}

    


?>
<html>
<head>
<meta charset="UTF-8">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
<style>
    body, html {
        margin: 0;
        padding: 0;
        text-align: center;
    }
    .back-button {
        position: relative;
        top: 125px;
        width: 140px;
        height: 45px;
        border-radius: 25px;
        font-size: 18px;
        font-family: 'Roboto', arial;
        font-weight: 500;
        
        letter-spacing: 2px;
        background-color: white;
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
        border: none;
        transition: 0.3s ease 0s;
        cursor: pointer;
        outline: none;
    }
    .back-button:hover {
        background-color: #24a0ed;
        box-shadow: 0px 5px 20px #6bbff2;
        color: #fff;
        transform: translateY(-3px);
    }

    .article-container {
        background-color: white;
        width: 500px;
        margin: 0 auto;
        box-shadow: 0px 0px 1px 1px lightgrey;
        font-family: 'Roboto';

    }
    h1 {
        text-align: center;
        font-family: 'Roboto', sans-serif;
        font-weight: 500;
    }
</style>
</head>
<body>
<h1> Artikkelit </h1>

<div class="article-container">
    
    <?php
    
    echo "<h2>" . $data['article_title'] . "</h2>";
    echo "<p>" . $data['article_content'] . "</p>";
    echo date('l jS', $data['article_timestamp']);
    echo time();
    ?>
    
    
</div>
    


<a class="back-link" href="index.php"><button class="back-button">Back</button></a>
</body>
</html>
