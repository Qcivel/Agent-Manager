<?php

include_once './utils/sanitize.php' ;
include_once './utils/validate.php';

if(isset($_POST["submit"])){
    if(!empty($_POST["firstname"]) && !empty($_POST["lastname"]) && !empty($_POST["email"]) && !empty($_POST["password"]) ){
        //Nettoyer les données
        $sani_firstname = sanitize($_POST["firstname"]);
        $sani_lastname =sanitize($_POST["lastname"]);
        $sani_email =sanitize($_POST["email"]);
        
        // Valider le format des données
        $message = validateName($sani_firstname,"firstname")  .validateName($sani_lastname,"lastname") . validateEmail($sani_email) . validatePassword($_POST["password"]);
        //Hash du mot de passe
        $hash_password = password_hash($_POST["password"],PASSWORD_DEFAULT);
        //Vérifier si l'email existe déjà dans la bdd
        if($message === ""){
            try{
                $bdd = connect_bdd();
                $sql = "SELECT u.email FROM `users` u WHERE u.email = ? ";
    
                $stmt = $bdd ->prepare($sql);
                $stmt->bindValue(1,$sani_email, PDO::PARAM_STR);
                $stmt -> execute();
                if($stmt->fetch()) {
                    $message = "Email existe déjà";
                }
               
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }
        if($message === ""){

            //Enregistrer le compte en bdd
            try {
            //11 ecrire la requête (INSERT)
            $sql = "INSERT INTO `users`(firstname, lastname, email, `password`,Id_Role)
            VALUE(?,?,?,?,?)";
            //12 se connecter à la BDD
            //13 préparer la requête
            $stmt = connect_bdd()->prepare($sql);
            //14 assigner les paramètres
            $stmt->bindValue(1, $sani_firstname, PDO::PARAM_STR);
            $stmt->bindValue(2, $sani_lastname, PDO::PARAM_STR);
            $stmt->bindValue(3, $sani_email, PDO::PARAM_STR);
            $stmt->bindValue(4, $hash_password, PDO::PARAM_STR);
            $stmt->bindValue(5, 2, PDO::PARAM_STR);
            //15 exécution de la requête
            if($stmt->execute()){
                $_SESSION['firstname'] = $sani_firstname;
                $message = "Compte enregistré avec succes";
            }
                
        } catch (PDOException $e) {
            $message = "Erreur : " . $e->getMessage();
        }
    }
   
    }
}