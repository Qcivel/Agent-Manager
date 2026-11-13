<?php
//AGENTS
//Enregistrement d'un agent
//Listing des agents

//Démarrer la session
session_start();

//Accessible uniquement si connecté
if(!isset($_SESSION["id"])){
    //non connecté -> redirection vers accueil
    header('Location:index.php');
    exit;
}

//Inclure les fichiers nécessaires
require_once './utils/db.php';
require_once './View/viewAgent.php';
require_once './Controller/ControllerAgent.php'; // il inclut déjà les Models

//Une seule connexion à la BDD, partagée par les trois Models
$pdo = connect_bdd();

$agent = new Agent();
$agent->setPdo($pdo);

$tier = new Tier();
$tier->setPdo($pdo);

$archetype = new Archetype();
$archetype->setPdo($pdo);

$viewAgent = new ViewAgent();

//Lancer la page
$controller = new ControllerAgent($agent, $tier, $archetype, $viewAgent);
$controller->render();