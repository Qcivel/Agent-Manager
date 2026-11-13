<?php
require_once './Model/ModelUser.php';

class ControllerAccueil{
    private User $modelUser;
    private Accueil $accueil;
    private string $messageConnection ="";
    private string $message="";
    public function __construct(User $modelUser, Accueil $accueil){
        $this->modelUser = $modelUser;
        $this->accueil = $accueil;
    }


    public function getModelUser(): User {
        return $this->modelUser;
    }


    public function setModelUser(User $modelUser): self {
        $this->modelUser = $modelUser;
        return $this;
    }


    public function getAccueil(): Accueil {
        return $this->accueil;
    }


    public function setAccueil(Accueil $accueil): self {
        $this->accueil = $accueil;
        return $this;
    }


    public function getMessageConnection(): string {
        return $this->messageConnection;
    }


    public function setMessageConnection(string $messageConnection): self {
        $this->messageConnection = $messageConnection;
        return $this;
    }


    public function getMessage(): string {
        return $this->message;
    }


    public function setMessage(string $message): self {
        $this->message = $message;
        return $this;
    }

    public function login(){
        if(isset($_POST["submitConnection"])){
            $email = trim($_POST["emailConnection"]);

            if(!empty($email) && !empty($_POST["passwordConnection"])){
                if(filter_var($email,FILTER_VALIDATE_EMAIL)){

                    if(mb_strlen($_POST["passwordConnection"]) >= 12){
                        //Vérifier si le compte existe
                        $this->modelUser->setEmail($email);
                        $data = $this->modelUser->findByEmail();
                        if(!empty($data)){
                            if(password_verify($_POST["passwordConnection"], $data["password"])){
                                $_SESSION["id"] = $data["Id_User"];
                                $_SESSION["firstname"] = $data["firstname"];
                                $_SESSION["lastname"] = $data["lastname"];
                                $_SESSION["email"] = $data["email"];
                                $_SESSION["createdAt"] = $data["created_at"];
                                $_SESSION["role"] = $data["role"];

                                $this->messageConnection = htmlspecialchars($_SESSION["firstname"])." est connecté";

                            }else{
                                $this->messageConnection = "L'email et/ou le mot de passe est invalide.";
                            }

                        }else{
                            $this->messageConnection = "L'email et/ou le mot de passe est invalide.";
                        }

                    }else{
                        $this->messageConnection = "Mot de passe doit faire au moins 12 caractères";
                    }

                }else{
                    $this->messageConnection = "Format d'email invalide";
                }

            }else{
                $this->messageConnection = "Tous les champs sont obligatoires.";
            }
}
    }




    public function managerSignIn(){


        //INSCRIPTION MANAGER
        //1. Vérifier la réception du formulaire d'inscription
        if(isset($_POST['submit'])){

            //2. Normaliser les données avec trim : firstname, lastname, email
            // On enlève les espaces avantr de vérifier les champs vide. Ainsi, si un champ obligatoire est constitué uniquement d'espace, alors il ne passera pas la vérification des champs vide. Par contre, on ne trim jamais le mot de passe, car espace peut en faire légitimement partie
            $firstname = trim($_POST['firstname']);
            $lastname = trim($_POST["lastname"]);
            $email = trim($_POST["email"]);

            //3. Vérifier les champs vide
            if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($_POST["password"])){

                //4. Vérifier le format des données
                if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                    if(mb_strlen($_POST["password"]) >= 12){
                        $this->modelUser->setEmail($email);
                        $data = $this->modelUser->findByEmail();
                        if($data === null){
                            $this->message = "Erreur serveur, réessayez plus tard.";

                    }elseif(empty($data)){
                        //6. Donner les données au Model
                        $this->modelUser->setFirstname($firstname)->setLastname($lastname)->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));

                        //7. Enregistrer le manager et vérifier que ça a marché
                        if($this->modelUser->signIn()){
                            $this->message = htmlspecialchars($firstname)." ".htmlspecialchars($lastname)." est correctement enregistré.";
                        }else{
                            $this->message = "Erreur serveur, réessayez plus tard.";
                        }

                    }else{
                        $this->message = "Email indisponible.";
                    }

                }else{
                    $this->message = "Le mot de passe doit faire au moins 12 caractères.";
                }
            }else{
                $this->message = "L'email n'est pas au bon format.";
            }
        }else{
            $this->message = "Veuillez remplir tous les champs.";
        }
    }
}

public function render(): void {
    //1. Traiter les formulaires
    $this->managerSignIn();
    $this->login();

    //2. Récupérer les données si un manager est connecté
    if(isset($_SESSION["id"])){
        $this->accueil->setListManagers($this->modelUser->findAllManagers());
    }

    //3. Donner les messages à la Vue
    $this->accueil->setMessage($this->message);
    $this->accueil->setMessageConnection($this->messageConnection);

    //4. Afficher la page
    $title = "Accueil";
    include './View/viewHeader.php';
    $this->accueil->display();
}


}

