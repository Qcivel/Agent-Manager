<?php
session_start();
include_once '../db/database.php';
include_once './sanitize.php';
include_once './validate.php';

$message = "";
if(isset($_POST["submit"])){
    if (!empty($_POST["name"]) && !empty($_POST["dob"]) && !empty($_POST["archetype"]) && !empty($_POST["tier"])) {
        //Nettoyer les données
        $sani_name = sanitize($_POST["name"]);
        $dob = !empty($_POST["dob"]) ? $_POST["dob"] : null;
        $id_archetype = (int) $_POST["archetype"];
        $id_tier = (int) $_POST["tier"];
        $id_team = !empty($_POST["team"]) ? (int) $_POST["team"] : null;

        if($message === ""){
            // Créer un agent
            try{
                $sql = "INSERT INTO `agent`(a.name,a.dob,a.created_at,Id_Archetype, Id_tier, Id_Team) VALUES (?,?,NOW(),?,?,?)";
                $bdd = connect_bdd();
                $stmt = $bdd ->prepare($sql);
                $stmt->bindValue(1, $sani_name, PDO::PARAM_STR);
                $stmt->bindValue(2, $dob, PDO::PARAM_STR);
                $stmt->bindValue(3, $id_archetype, PDO::PARAM_INT);
                $stmt->bindValue(4, $id_tier, PDO::PARAM_INT);
                $stmt->bindValue(5, $id_team, $id_team === null ? PDO::PARAM_NULL : PDO::PARAM_INT);

                if ($stmt->execute()) {
                    $message = "Agent ajouté avec succès !";
                }

                }catch (PDOException $e) {
                    $message = "Erreur : " . $e->getMessage();
                }
        }
    }
}


// Récupère les informations Tiers 
    try{
        $bdd = connect_bdd();
        $sql = "SELECT t.Id_tier, t.tier, t.level FROM `tiers` t";
        $stmt = $bdd ->prepare($sql);

        $stmt -> execute();
        $tiers = $stmt->fetchall();
                    
        print_r($tiers) ;

    }catch (PDOException $e) {
        $message = "Erreur : " . $e->getMessage();
    }


    //Récupère les archetypes
        try{
        $bdd = connect_bdd();
        $sql = "SELECT a.Id_Archetype, a.archetype FROM archetypes a";
        
        $stmt = $bdd ->prepare($sql);

        $stmt -> execute();
        $archetypes = $stmt->fetchall();
                    
        print_r($archetypes) ;

    }catch (PDOException $e) {
        $message = "Erreur : " . $e->getMessage();
    }

    //Récupère les abilites
        try{
        $bdd = connect_bdd();
        $sql = "SELECT ab.Id_Ability, ab.ability FROM abilities ab";
        
        $stmt = $bdd ->prepare($sql);

        $stmt -> execute();
        $abilities = $stmt->fetchall();
                    
        print_r($abilities) ;

    }catch (PDOException $e) {
        $message = "Erreur : " . $e->getMessage();
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Agent</title>
</head>
<body>
    <header>
        <a href="/exercice3-AgentManager/index.php'">Acceuil</a>
        <a href="./monprofil.php">Mon Profil</a>
        <a href="./deco.php"> Deconnexion</a>
    </header>
    <h1>SHIELD</h1>
    <h2>Ajouter un agent </h2>
    <form action="" method="POST">
        <label for="" id="name">Nom de l'agent</label>
        <input type="text" name="name" id="name">

        <label for="" id="dob"> Date de naissance de l'agent</label>
        <input type="date" id="dob" name="dob">

        <label for="" id="tier"></label>
        <select name="tier" id="tier">
            <option value="">-- Choisir un tier --</option>
            <?php foreach ($tiers as $tier) { ?>
                <option value="<?= $tier["tier"] ?>">
                <?= htmlspecialchars($tier["tier"]) ?>
                </option>
            <?php } ?>
        </select>

        <label for="" id="archetypes"></label>
        <select name="archetype" id="archetype">
            <option value="">-- Choisir un archetypes --</option>
            <?php foreach ($archetypes as $archetype) { ?>
                <option value="<?= $archetype["archetype"] ?>">
                <?= htmlspecialchars($archetype["archetype"]) ?>
                </option>
            <?php } ?>
        </select>

        <label for="" id="abilities"></label>
        <select name="abilities" id="abilities">
            <option value="">-- Choisir un abilities --</option>
            <?php foreach ($abilities as $ability) { ?>
                <option value="<?= $ability["ability"] ?>">
                <?= htmlspecialchars($ability["ability"]) ?>
                </option>
            <?php } ?>
        </select>

        <input type="submit" name="submit" value="Enregistrer">
        
    </form>
    <h2>Liste des agents du SHIELD</h2>

    
</body>
</html>