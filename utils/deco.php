<?php
//Démarrer la session
session_start();
// Vider les variables de session
$_SESSION = [];
//Suppression de la session
session_destroy();

//Rediriger l'utilisateur
header('Location: /exercice3-AgentManager/index.php');

//Nettoyer correctement les entêtes de la requête
exit;