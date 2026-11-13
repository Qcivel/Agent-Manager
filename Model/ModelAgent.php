<?php

require_once './Model/AbstractModel.php';

class Agent extends AbstractModel{
    //ATTRIBUTS
    private int $id;
    private string $name;
    private string $dob;
    private string $createdAt;
    private string $archetype;
    private string $tier;
    private string $team;
    private int $idTier;
    private int $idArchetype;

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

    public function getTier(): string {
        return $this->tier;
    }

    public function setTier(string $tier): self {
        $this->tier = $tier;
        return $this;
    }

    public function getArchetype(): string {
        return $this->archetype;
    }

    public function setArchetype(string $archetype): self {
        $this->archetype = $archetype;
        return $this;
    }

    public function getCreatedAt(): string {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): self {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getTeam(): string {
        return $this->team;
    }

    public function setTeam(string $team): self {
        $this->team = $team;
        return $this;
    }
    
    /**
     * Get the value of idTier
     *
     * @return int
     */
    public function getIdTier(): int {
        return $this->idTier;
    }

    /**
     * Set the value of idTier
     *
     * @param int $idTier
     *
     * @return self
     */
    public function setIdTier(int $idTier): self {
        $this->idTier = $idTier;
        return $this;
    }

    /**
     * Get the value of idArchetype
     *
     * @return int
     */
    public function getIdArchetype(): int {
        return $this->idArchetype;
    }

    /**
     * Set the value of idArchetype
     *
     * @param int $idArchetype
     *
     * @return self
     */
    public function setIdArchetype(int $idArchetype): self {
        $this->idArchetype = $idArchetype;
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
    public function findAll(): array {
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