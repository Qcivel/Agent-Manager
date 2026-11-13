<?php

class Tier{
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


    public function allTier(): array {
        try{

            $request = $this->pdo->prepare("SELECT t.Id_Tier, t.tier FROM tiers t");


            $request->execute();


            return $request->fetchAll(PDO::FETCH_ASSOC);

        }catch(Exception $error){
            http_response_code(500);
            error_log($error->getMessage());
            return [];
        }
    }


    public function findById(int $id): array|false|null {
        try{

            $request = $this->pdo->prepare("SELECT t.tier FROM tiers t WHERE t.Id_Tier = ?");

            $request->bindParam(1, $id, PDO::PARAM_INT);

            $request->execute();

            return $request->fetch(PDO::FETCH_ASSOC);

        }catch(Exception $error){
            http_response_code(500);
            error_log($error->getMessage());
            return null;
        }
    }
}