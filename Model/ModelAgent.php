<?php

class Agent{
    //ATTRIBUTS
    private int $id;
    private string $name;
    private string $dob;
    private int $idTier;
    private int $idArchetype;
    private PDO $pdo;

    //GETTERS SETTERS
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    public function getDob(): string {
        return $this->dob;
    }

    public function setDob(string $dob): self {
        $this->dob = $dob;
        return $this;
    }

    public function getIdTier(): int {
        return $this->idTier;
    }

    public function setIdTier(int $idTier): self {
        $this->idTier = $idTier;
        return $this;
    }

    public function getIdArchetype(): int {
        return $this->idArchetype;
    }

    public function setIdArchetype(int $idArchetype): self {
        $this->idArchetype = $idArchetype;
        return $this;
    }

    public function getPdo(): PDO {
        return $this->pdo;
    }

    public function setPdo(PDO $pdo): self {
        $this->pdo = $pdo;
        return $this;
    }

    //METHODES


    public function findByName(): array|false|null {
        try{
            //A. Préparer la requête
            $request = $this->pdo->prepare("SELECT a.name FROM agents a WHERE a.name = ?");

            //B. Relier le ? au nom
            $request->bindParam(1, $this->name, PDO::PARAM_STR);

            //C. Exécuter la requête
            $request->execute();

            //D. Récupérer les données (false si aucun agent trouvé)
            return $request->fetch(PDO::FETCH_ASSOC);

        }catch(Exception $error){
            http_response_code(500);
            error_log($error->getMessage());
            return null;
        }
    }

    //Enregistrer un agent
    public function addAgent(): bool {
        try{
            //A. Préparer la requête
            $request = $this->pdo->prepare("INSERT INTO agents (`name`, dob, Id_Tier, Id_Archetype) VALUES (?,?,?,?)");

            //B. Relier les ? aux données
            $request->bindParam(1, $this->name, PDO::PARAM_STR);
            $request->bindParam(2, $this->dob, PDO::PARAM_STR);
            $request->bindParam(3, $this->idTier, PDO::PARAM_INT);
            $request->bindParam(4, $this->idArchetype, PDO::PARAM_INT);

            //C. Exécuter la requête
            $request->execute();
            return true;

        }catch(Exception $error){
            http_response_code(500);
            error_log($error->getMessage());
            return false;
        }
    }

    //Liste de tous les agents
    public function listAgent(): array {
        try{
            //A. Préparer la requête
            $request = $this->pdo->prepare("SELECT a.Id_Agent, a.name, a.dob, a.created_at, t.tier, ac.archetype, te.team_name FROM agents a INNER JOIN tiers t ON t.Id_Tier = a.Id_Tier INNER JOIN archetypes ac ON ac.Id_Archetype = a.Id_Archetype LEFT JOIN teams te ON te.Id_Team = a.Id_Team");

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
}