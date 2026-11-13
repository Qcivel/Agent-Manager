<?php
require_once './Model/ModelAgent.php';
require_once './Model/ModelTier.php';
require_once './Model/ModelArchetype.php';

class ControllerAgent{
    //ATTRIBUTS
    private Agent $modelAgent;
    private Tier $modelTier;
    private Archetype $modelArchetype;
    private ViewAgent $viewAgent;
    private string $message = "";

    public function __construct(Agent $modelAgent, Tier $modelTier, Archetype $modelArchetype, ViewAgent $viewAgent){
        $this->modelAgent = $modelAgent;
        $this->modelTier = $modelTier;
        $this->modelArchetype = $modelArchetype;
        $this->viewAgent = $viewAgent;
    }

    //ENREGISTREMENT D'UN AGENT
    public function addAgent(): void {
        //1. Vérifier si on reçoit le formulaire
        if(isset($_POST["submit"])){
            //2. Normaliser les données
            $name = trim($_POST["name"]);
            $dob = trim($_POST["dob"]);
            $tier = trim($_POST["tier"]);
            $archetype = trim($_POST["archetype"]);

            //3. Vérifier les champs vides
            if(!empty($name) && !empty($dob) && !empty($tier) && !empty($archetype)){
                //4. Vérifier le format des données
                if(filter_var($tier, FILTER_VALIDATE_INT)){
                    if(filter_var($archetype, FILTER_VALIDATE_INT)){

                        //5. Vérifier si le nom est disponible
                        $this->modelAgent->setName($name);
                        $dataName = $this->modelAgent->findByName();

                        //6. Vérifier si l'archetype et le tier existent
                        $dataArchetype = $this->modelArchetype->findById((int)$archetype);
                        $dataTier = $this->modelTier->findById((int)$tier);

                        if($dataName === null || $dataArchetype === null || $dataTier === null){
                            $this->message = "Erreur serveur, réessayez plus tard.";
                        }elseif(!empty($dataName)){
                            $this->message = "Ce nom n'est pas disponible.";
                        }elseif(empty($dataArchetype)){
                            $this->message = "Cet Archetype n'existe pas";
                        }elseif(empty($dataTier)){
                            $this->message = "Ce Tier n'existe pas";
                        }else{
                            //7. Donner les données au Model
                            $this->modelAgent->setDob($dob)->setIdTier((int)$tier)->setIdArchetype((int)$archetype);

                            //8. Enregistrer l'agent et vérifier que ça a marché
                            if($this->modelAgent->addAgent()){
                                $this->message = htmlspecialchars($name)." a été enregistré.";
                            }else{
                                $this->message = "Erreur serveur, réessayez plus tard.";
                            }
                        }

                    }else{
                        $this->message = "Archetype est invalide";
                    }
                }else{
                    $this->message = "Le Tier est invalide";
                }
            }else{
                $this->message = "Remplissez tous les champs.";
            }
        }
    }

    //AFFICHAGE DE LA PAGE
    public function render(): void {
        //1. Traiter le formulaire
        $this->addAgent();

        //2. Récupérer les données pour la Vue
        $this->viewAgent->setTiers($this->modelTier->allTier());
        $this->viewAgent->setArchetypes($this->modelArchetype->allArchetypes());
        $this->viewAgent->setListAgents($this->modelAgent->listAgent());
        $this->viewAgent->setMessage($this->message);

        //3. Afficher la page
        $title = "Agents of Shield";
        include './View/viewHeader.php';
        $this->viewAgent->displayAgent();
    }
}