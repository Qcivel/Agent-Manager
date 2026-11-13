<?php
//Déconnexion d'un utilisateur
//Démarrer la session
session_start();

//Détruire la session
session_destroy();

//Rediriger vers l'accueil (deco.php est dans utils/, l'accueil est un dossier au-dessus)
header('Location:../index.php');
exit;