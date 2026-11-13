<?php

class User {
    //ATTRIBUT
        private int $id;
        private string $firstname;
        private string $lastname;
        private string $email;
        private string $password;
        private PDO $pdo;

    //GUETTER SETTER

         public function getId(): int {
                return $this->id;
        }


        public function setId(int $id): self {
                $this->id = $id;
                return $this;
        }

        public function getFirstname(): string {
                return $this->firstname;
        }


        public function setFirstname(string $firstname): self {
                $this->firstname = $firstname;
                return $this;
        }


        public function getLastname(): string {
                return $this->lastname;
        }


        public function setLastname(string $lastname): self {
                $this->lastname = $lastname;
                return $this;
        }


        public function getEmail(): string {
                return $this->email;
        }


        public function setEmail(string $email): self {
                $this->email = $email;
                return $this;
        }


        public function getPassword(): string {
                return $this->password;
        }


        public function setPassword(string $password): self {
                $this->password = $password;
                return $this;
        }


        public function getPdo(): PDO {
                return $this->pdo;
        }

        public function setPdo(PDO $pdo): self {
                $this->pdo = $pdo;
                return $this;
        }

    public function signIn():bool{

        try{
            //E. Vérifier si $data est vide. S'il est vide, l'emai lest disponible

                $request = $this->pdo->prepare('INSERT INTO users (firstname, lastname, email, `password`, Id_Role) VALUES(?,?,?,?,2)');

                //B. Relier les ? à mes données
                $request->bindParam(1,$this->firstname,PDO::PARAM_STR);
                $request->bindParam(2,$this->lastname,PDO::PARAM_STR);
                $request->bindParam(3,$this->email,PDO::PARAM_STR);
                $request->bindParam(4,$this->password,PDO::PARAM_STR);

                //C. Exécuter la requête
                $request->execute();
                return true;
        }catch(Exception $error){
            http_response_code(500);
            error_log($error->getMessage()); // trace côté serveur
            return false;
        }
    }

    public function findByEmail(){
        try{
            //A.Préparer la requête
            $request = $this->pdo->prepare("SELECT u.Id_User, u.firstname, u.lastname, u.email, u.password, u.created_at, r.role FROM users u INNER JOIN roles r ON u.Id_Role = r.Id_Role WHERE u.email = ?");

            //B.BindParam
            $request->bindParam(1,$this->email, PDO::PARAM_STR);

            //C.Exécuter la requête
            $request->execute();

            //D.Récupérer les données
            return $request->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $error){
            http_response_code(500);
            error_log($error->getMessage());
            return null;
        }
    }

    public function findAllManagers(){
        try{

            //A.Préparer la requête
            $request = $this->pdo->prepare("SELECT u.Id_User, u.firstname, u.lastname, u.email, u.password, u.created_at, r.role FROM users u INNER JOIN roles r ON u.Id_Role = r.Id_Role WHERE r.role = 'Manager'");

            //B.Exécuter la requête
            $request->execute();

            //C.Récupérer les données
            return $request->fetchAll(PDO::FETCH_ASSOC);

        }catch(Exception $error){
            http_response_code(500);
            error_log($error->getMessage());
            return [];
        }
    }

}
