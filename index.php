<?php

session_start();
$message ="";
include_once './db/database.php';

include_once './utils/signUp.php';
include_once './utils/login.php';


var_dump($_SESSION);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuil</title>
</head>
<body>
    <header>
        <a href="index.php"> Acceuil</a>
        <?php
            if(isset($_SESSION["id_user"])){ ?>
                <a href="./utils/monprofil.php"> Mon Profil</a>
                <a href="./utils/avenger.php"> SHIELD</a>
                <a href="./utils/deco.php"> Deconnexion</a>
        <?php } ?>
        
    </header>
    <main>
        <h1>Acceuil</h1>
        <h2>Inscription</h2>
        <form action="" method="POST">
            <label for="" id="firstname">Prénom :</label>
            <input type="text" id="firstname" name="firstname" placeholder="Votre prénom :">

            <label for="" id="lastname">Nom :</label>
            <input type="text" id="lastname" name="lastname" placeholder="Votre nom :">

            <label for="" id="email">email</label>
            <input type="text" id="email" name="email" placeholder="Votre email :">

            <label for="" id="password">password</label>
            <input type="password" name="password" id="password">

            <input type="submit" name="submit" value="S'inscrire">
        </form>

        <h2>Connexion</h2>
        <form action="" method="POST">
            <label for="" id="log_email">email</label>
            <input type="text" id="log_email" name="log_email" placeholder="Votre email :">

            <label for="" id="log_password">password</label>
            <input type="password" name="log_password" id="log_password">

            <input type="submit" name="login" value="Connexion">
        </form>
        <p><?php echo($message); ?></p>
        <section>
            <?php
            if(isset($_SESSION["id_user"])){ ?>
                <h2>Session connectée </h2>
            <?php } ?>
        </section>
    </main>
</body>
</html>