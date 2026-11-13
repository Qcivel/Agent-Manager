<?php
//MON COMPTE
//Affichage des informations du manager connecté

//Démarrer la session
session_start();

//Accessible uniquement si connecté
if(!isset($_SESSION["id"])){
    //non connecté -> redirection vers accueil
    header('Location:index.php');
    exit;
}

//Inclure les fichiers nécessaires
require_once './View/viewProfil.php';
require_once './Controller/ControllerProfil.php';

//Lancer la page
$profil = new Profil();
$controller = new ControllerProfil($profil);
$controller->render();
