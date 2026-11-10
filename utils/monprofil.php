<?php
session_start();


var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte</title>
</head>
<body>
    <header>
        <a href="/exercice3-AgentManager/index.php'">Acceuil</a>
        <a href="./deco.php"> Deconnexion</a>
    </header>
    <h1>Mon profil </h1>
    <p>Mon prénom : <?= htmlspecialchars($_SESSION["firstname"]) ?></p>
    <p>Mon Nom : <?= htmlspecialchars($_SESSION["lastname"]) ?> </p>
    <p>Mon Email: <?= htmlspecialchars($_SESSION["email"]) ?> </p>
    <p>Compte crée le : <?= htmlspecialchars($_SESSION["created_at"]) ?> </p>

    
</body>
</html>