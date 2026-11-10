<?php

include_once './utils/sanitize.php' ;
include_once './utils/validate.php';

$message = "";
if(isset($_POST["login"])){
    if(!empty($_POST["log_email"]) && !empty($_POST["log_password"]) ){
        //Nettoyer les données 
        $sani_log_email = sanitize($_POST["log_email"]);
        //Valider le format
        $message= validateEmail($sani_log_email);
        
        if($message === ""){
            try{
                $bdd = connect_bdd();
                $sql = "SELECT u.Id_User, u.email, u.password , u.Id_Role, u.firstname, u.lastname, u.created_at FROM `users` u WHERE u.email = ? ";
    
                $stmt = $bdd ->prepare($sql);
                $stmt->bindValue(1,$sani_log_email, PDO::PARAM_STR);
                
                $stmt -> execute();
                $user = $stmt->fetch();
                
                if($user && $stmt && password_verify($_POST["log_password"], $user["password"] )){
                    //Création de la session
                    $_SESSION["id_user"]   = $user["Id_User"];
                    $_SESSION["firstname"] = $user["firstname"];
                    $_SESSION["lastname"]   = $user["lastname"];
                    $_SESSION["email"]   = $user["email"];
                    $_SESSION["created_at"]   = $user["created_at"];
                    $_SESSION["id_role"]   = $user["Id_Role"];
                    $message = "Vous êtes connecté !";
                }else{
                    $message = "Email ou mot de passe incorrect";
                }

            }catch (PDOException $e) {
                $message = "Erreur : " . $e->getMessage();
            }
        }
    }else {
        $message = "Veuillez remplir tout les champs !";
    }
}