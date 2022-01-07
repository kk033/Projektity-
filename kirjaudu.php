<?php
// Aloita sessio
session_start();
 
// Tarkista jos käyttäjä on jo kirjautunut, jos on vie tervetuloa sivulle
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Sisällä configurointi tiedosto
require_once "config.php";
 
// Määrittele muuttujat ja alusta tyhjillä arvoilla
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Prosessoi formin data kun lähetetty
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // käyttäjänimi on tyhjä
    if(empty(trim($_POST["username"]))){
        $username_err = "Olehyvä ja syötä käyttäjänimi.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Katso jos salasana on tyhjä
    if(empty(trim($_POST["password"]))){
        $password_err = "Ole hyvä ja syötä salasanasi.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Vahvista kirjaimet
    if(empty($username_err) && empty($password_err)){
        // Valmista valittu lausunto
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Sido muuttujat valmisteltuun lausuntoon parametreina
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Aseta parametrit
            $param_username = $username;
            
            // Yritä suorittaa valmisteltu lausunto
            if(mysqli_stmt_execute($stmt)){
                // Tallenna tulos
                mysqli_stmt_store_result($stmt);
                
                // Tarkista jos käyttäjätunnus on olemassa, jos on varmista salasana
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Sido tulosmuuttujat
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Salasana on oikein, joten aloita uusi sessio
                            session_start();
                            
                            // Tallenna data session muuttujiin
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Vie käyttäjä tervetuloa sivulle
                            header("location: welcome.php");
                        } else{
                            // Salasana ei ole sopiva näytä virhe
                            $login_err = "Virheellinen käyttäjänimi tai salasana.";
                        }
                    }
                } else{
                    // Käyttäjätunnusta ei ole olemassa näytä virhe ilmoitus
                    $login_err = "Virheellinen käyttäjänimi tai salasana.";
                }
            } else{
                echo "Oho! Jotain meni pieleen. Kokeile myöhemmin uudestaan.";
            }

            // Sulje statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Sulje yhteys
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Kirjaudu sisään</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="CSS tiedostot/kirjaudu.css">
    </head>
    <body>
        <header class="flex-header">
            <ul class="flex-ul">
                <li><a href="index.php">HOME</a></li>
                <li><a>ABOUT</a></li>
                <li><a href="artikkeli-sivu.php">ARTICLES</a></li>
            </ul>
            <nav>
                <img src="logo.png" class="logo" alt="logo">
            </nav>
            <a class="kirjaudu-link" href="rekisteröidy.php"><button class="kirjaudu-button">REKISTERÖIDY</button></a>
        </header>

        <div class="front-text">
            <h1>Liity meihin!</h1>
            <p>Moi</p>
        </div>
        <div class="kirjaudu">
            <?php
            if(!empty($login_err)){
                echo '<div class="alert alert-danger">' . $login_err . '</div>';
            }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h2>KIRJAUDU SISÄÄN</h2>
                <div class="syöttö-wrap">
                    <label for="username">Käyttäjätunnus</label>
                    <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'on väärin' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>

                <div class="syöttö-wrap">
                    <label for="password">Salasana</label>
                    <input id="myInput" type="text" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                    <input type="checkbox" onclick="myFunction()">Piilota salasana
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>

                <br>

                <input type="submit" name="kirjaudu" value="KIRJAUDU">
                <p>Eikö sinulla ole tiliä? <a href="rekisteröidy.php">Rekisteröidy nyt.</a></p>
                
            </form>
        </div>
    <script>
        function myFunction() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
    </body>
</html>