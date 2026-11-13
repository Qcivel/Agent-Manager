<?php
//ACCUEIL
//Création d'un compte Manager
//Connexion d'un compte Manager
//Listing des Managers
//Affichage dynamique selon l'état de connexion

//Démarrage de la session
session_start();

//Inclure les fichiers nécessaires
require_once './utils/db.php';
require_once './View/viewAccueil.php';
require_once './Controller/ControllerLogin.php'; // il inclut déjà le Model User

//Créer les objets
$user = new User();
$user->setPdo(connect_bdd());
$accueil = new Accueil();

//Lancer la page (le controller affiche le header puis la vue)
$controller = new ControllerAccueil($user, $accueil);
$controller->render();
