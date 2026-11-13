<?php

class Archetype{
    //ATTRIBUT
    private PDO $pdo;

    //GETTER SETTER
    public function getPdo(): PDO {
        return $this->pdo;
    }

    public function setPdo(PDO $pdo): self {
        $this->pdo = $pdo;
        return $this;
    }

    //METHODES


    public function allArchetypes(): array {
        try{
            //A. Préparer la requête
            $request = $this->pdo->prepare("SELECT a.Id_Archetype, a.archetype FROM archetypes a");

            //B. Exécuter la requête
            $request->execute();

            //C. Récupérer les données
            return $request->fetchAll(PDO::FETCH_ASSOC);

        }catch(Exception $error){
            http_response_code(500);
            error_log($error->getMessage());
            return [];
        }
    }


    public function findById(int $id): array|false|null {
        try{
            //A. Préparer la requête
            $request = $this->pdo->prepare("SELECT a.archetype FROM archetypes a WHERE a.Id_Archetype = ?");

            //B. Relier le ? à l'id
            $request->bindParam(1, $id, PDO::PARAM_INT);

            //C. Exécuter la requête
            $request->execute();

            //D. Récupérer les données (false si aucun archetype trouvé)
            return $request->fetch(PDO::FETCH_ASSOC);

        }catch(Exception $error){
            http_response_code(500);
            error_log($error->getMessage());
            return null;
        }
    }
}