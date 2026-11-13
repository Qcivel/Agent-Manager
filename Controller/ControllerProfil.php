<?php

class ControllerProfil{
    //ATTRIBUT
    private Profil $profil;

    public function __construct(Profil $profil){
        $this->profil = $profil;
    }

    //AFFICHAGE DE LA PAGE
    public function render(): void {
        //1. Donner les informations du manager connecté à la Vue
        //   (elles ont été enregistrées en session lors de la connexion)
        $this->profil->setFirstname($_SESSION["firstname"])
                     ->setLastname($_SESSION["lastname"])
                     ->setEmail($_SESSION["email"])
                     ->setRole($_SESSION["role"])
                     ->setCreatedAt($_SESSION["createdAt"]);

        //2. Afficher la page
        $title = "Mon Compte";
        include './View/viewHeader.php';
        $this->profil->display();
    }
}
