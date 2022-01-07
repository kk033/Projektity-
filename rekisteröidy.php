<?php
//config tiedosto
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    //tarkista käyttäjänimi
    if(empty(trim($_POST["username"]))){
        $username_err = "Ole hyvä ja syötä käyttäjätunnus.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Käyttäjätunnus voi sisältää vain kirjaimia, numeroja ja ala.";
    } else{
        //Valitse
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            //Sido muuttujat valmisteltuun lauseeseen parametreina
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            //aseta parametrit
            $param_username = trim($_POST["username"]);

            //
            if(mysqli_stmt_execute($stmt)){
                /*tallenna tulos */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Tämä käyttäjänimi on jo varattu.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oho! Jotain meni pieleen. Yritä myöhemmin uudelleen.";
            }

            // sulje
            mysqli_stmt_close($stmt);
        }
    }

    //tarkista salasana
    if(empty(trim($_POST["password"]))){
        $password_err = "Ole hyvä ja syötä salasana.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Salasanan on oltava enintään 6 kirjainta.";
    } else {
        $password = trim($_POST["password"]);
    }

    //tarkista vahvista salasana
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Ole hyvä ja varmista salasana.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Salasana ei täsmännyt.";
        }
    }

    //tarkista käyttäjäsyöte ennen tietokantaan tallentamista
    if(empty($username_err) && empty($password_err) &&
empty($confirm_password_err)) {

        //Valmista tallennus
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Sido muuttujat valmisteltuun lauseeseen parametreina
            mysqli_stmt_bind_param($stmt, "ss", $param_username,
$param_password);

            //aseta parametrit
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); 
            //Luo salasanatiivisteen

            //Suorita
            if(mysqli_stmt_execute($stmt)){
                //Login sivulle
                header("location: kirjaudu.php");
            } else{
                echo "Oho! Jotain meni pieleen. Yritä myöhemmin uudelleen.";
            }

            //Sulje
            mysqli_stmt_close($stmt);
        }
    }

    //Sulje yhteys SQL:ään
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Rekisteröidy</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <link rel="stylesheet" href="CSS tiedostot/rekisteröidy.css">
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
        
    <div class="rekisteröidy-info">
        <h1>Liity meihin!</h1>
        <p>testi</p>
        
    </div>

        <div class="rekisteröidy">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <h2>Rekisteröidy</h2>
                <div class="syöttö-wrap">
                    <label for="username">Käyttäjätunnus</label>
                    <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'ei kelpaa' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="invalid-feedback"><?php echo $username_err; ?>
                    </span>
                </div>

                <div class="syöttö-wrap">
                    <label for="password">Salasana</label>
                    <input type="text" name="password" class="form-control <?php echo (!empty($password_err)) ? 'ei kelpaa' : ''; ?>" value="<?php echo $password; ?>">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>

                <div class="syöttö-wrap">
                    <label for="confirm_password">Salasana uudelleen</label>
                    <input type="text" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'ei kelpaa' : ''; ?>" value="<?php echo $confirm_password; ?>">
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <br>
                <input type="submit" name="rekisteröidy" value="Rekisteröidy">
                    <p>Onko sinulla jo tili? <a href="kirjaudu.php">Kirjaudu sisään.</a></p>
            </form>
        </div>
       
    </body>
</html>