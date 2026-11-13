<?php
 class Accueil{
    //ATTRIBUT
    private array $listManagers = [];
    private string $message = "";
    private string $messageConnection = "";


    public function getMessage(): string {
        return $this->message;
    }


    public function setMessage(string $message): self {
        $this->message = $message;
        return $this;
    }


    public function getMessageConnection(): string {
        return $this->messageConnection;
    }


    public function setMessageConnection(string $messageConnection): self {
        $this->messageConnection = $messageConnection;
        return $this;
    }

    public function getListManagers(): array {
        return $this->listManagers;
    }


    public function setListManagers(array $listManagers): self {
        $this->listManagers = $listManagers;
        return $this;
    }

    public function display(){
?>
        <main>
            <h1>Accueil</h1>
            <?php
                //Vérifier si personne n'est connecté
                if(!isset($_SESSION["id"])){
            ?>
            <section>
                <h2>Inscription</h2>
                <form action="" method="post">
                    <label for="firstname">Prenom :<input id="firstname" type="text" name="firstname"></label>
                    <label for="lastname">Nom :<input id="lastname" type="text" name="lastname"></label>
                    <label for="email">Email :<input id="email" type="text" name="email"></label>
                    <label for="password">Motde Passe :<input id="password" type="text" name="password"></label>
                    <input type="submit" name="submit">
                </form>
                <p><?php echo $this->message ?></p>
            </section>
            <section>
                <h2>Connexion</h2>
                <form action="" method="post">
                    <label for="emailConnection">Email :<input id="emailConnection" type="text" name="emailConnection"></label>
                    <label for="passwordConnection">Motde Passe :<input id="passwordConnection" type="text" name="passwordConnection"></label>
                    <input type="submit" name="submitConnection">
                </form>
                <p><?php echo $this->messageConnection ?></p>
            </section>
            <?php
                };

                //Vérifier si un manager est connecté
                if(isset($_SESSION["id"])){
            ?>
                    <section>
                        <h2>Liste des Managers</h2>
                        <ul>
                            <?php
                                foreach($this->listManagers as $manager){
                            ?>
                                    <li><?php
                                    //Affichage des données avec nettoyage du code malveillant
                                    echo(htmlspecialchars($manager['firstname'])." ".htmlspecialchars($manager['lastname'])." - ".htmlspecialchars($manager['email'])) ?></li>
                            <?php
                                }
                            ?>
                        </ul>
                    </section>
            <?php
                }
            ?>
        </main>
    </body>
    </html>
    <?php
    }


}
