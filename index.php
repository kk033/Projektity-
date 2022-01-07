<?php

include_once('connection.php');
include_once('article.php');


$article = new Article;
$artikkelit = $article->fetchAll();


?>
<!DOCTYPE html>
<html lang="fi">
    <head>
        <link rel="stylesheet" href="CSS Tiedostot/styles.css">
        <title>Etusivu</title>
        <meta charset="UTF-8">
        <script src="myScript.js"></script>
    </head>
    <body>
        <header class="flex-header">
            <ul class="flex-ul">
                <li class="active"><a href="index.php">KOTI</a></li>
                <li><a href="tietoa.php">TIETOA</a></li>
                <li><a href="artikkeli-sivu.php">ARTIKKELIT</a></li>
            </ul>
            
            <nav>
                <img src="logo.png" class="logo" alt="logo">
            </nav>
            <a class="kirjaudu-link" href="kirjaudu.php"><button class="kirjaudu">KIRJAUDU</button></a>
        </header>
        

        <div class="hero-grid">
            <div class="hero-grid-item">
                <h1>Testi teksti laatikko</h1>
                <p></p>
                <div class="hero-round"></div>
            </div>
            <div class="hero-grid-item"></div>
        </div>
        <div class="text-grid">
            <div class="text-grid-item">
                <h1>test</h1>
                <p>Lorem ipsum</p>
            </div>
            <div class="text-grid-item">
                <h1>test</h1>
                <p>Lorem ipsum</p>
            </div>
            <div class="text-grid-item">
                <h1>test</h1>
                <p>Lorem ipsum</p>
            </div>
        </div>
        

        <div class="home-info">
            
            <div class="home-info-box">
                <?php
                echo "<h2>" . $artikkelit['article_title'] . "</h2>";
                echo "<p>" . $artikkelit['article_content'] . "</p>"
                ?>
            </div>

            <div class="home-info-box">
                <?php
                echo "<h2>" . $artikkelit['article_title'] . "</h2>";
                echo "<p>" . $artikkelit['article_content'] . "</p>"
                ?>
            </div>
            <div class="home-info-box">
                <?php
                echo "<h2>" . $artikkelit['article_title'] . "</h2>";
                echo "<p>" . $artikkelit['article_content'] . "</p>"
                ?>
            </div>
            
        </div>

        <div class="home-grid">
            <div class="grid-item-a">
                <h1>Testiä testiä</h1>
                <p style="color: #636060; font-size: 25px;">Lorem ipsum.</p>
            </div>
            <div class="grid-item-b">
                <h1>moi</h1>
                <p style="padding-top: 250px; padding-left: 50px; padding-right: 50px;">Moi masdadsadasd adada sdada dsasd asdasd </p>
            </div>
            <div class="grid-item-c">
                <h1>moi</h1>
                <p style="padding-top: 250px; padding-left: 50px; padding-right: 50px;"></p>
            </div>
            <div class="grid-item-d">
                <h1>moi</h1>
                <p style="padding-top: 250px; padding-left: 50px; padding-right: 50px;"></p>
            </div>
            <div class="grid-item-e">
                <h1>moi</h1>
                <p style="padding-top: 250px; padding-left: 50px; padding-right: 50px;"></p>
            </div>
        </div>
        <div class="config-box">
        <?php echo $artikkelit['article_title']; ?>
        </div>
    </body>
</html>