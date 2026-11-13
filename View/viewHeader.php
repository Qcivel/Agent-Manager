<?php

if(!isset($title)){
    $title = "The Shield";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php">Accueil</a>

            <?php
                //Vérifier si un manager est connecté
                if(isset($_SESSION["id"])){
            ?>
                    <a href="monprofil.php">Mon Compte</a>
                    <a href="agents.php">Agents</a>
                    <a href="utils/deco.php">Se Déconnecter</a>
            <?php
                };
            ?>
        </nav>
    </header>