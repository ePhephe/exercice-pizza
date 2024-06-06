<?php

/**
 * Classe index : classe du controller index
 * @todo
 * Affiche la page de connexion si l'utilisateur n'est pas connecté sinon la page d'accueil
 */

class index extends _controller {

    /**
     * Attributs
     */

    // Nom du controller
    protected $name = "index";
    // Liste des objets manipulés par le controller
    protected $objects = []; // ["objet1" => ["action"1,"action2"...],"objet2" => ["action"1,"action2"...]]
    // Paramètres du controller attendus en entrée
    protected $paramEntree = ["redirect" => ["method" => "GET", "required" => false]]; // ["nom_param1"=>["method"=>"POST","required"=>true],"nom_param2"=>["method"=>"POST","required"=>false]]
    // Type de retour
    protected $typeRetour = "pages"; // json, fragments ou pages (défaut)
    // Nom du template
    protected $template = "form_connexion";
    // Paramètres en sortie du controller
    protected $paramSortie = []; // ["nom_param1"=>["required"=>true],"nom_param2"=>["required"=>false]]
    // Besoin d'être connecté
    protected $connected = false; // True par défaut

    /**
     * Vérifie que les paramètres du controller sont bien présents et/ou leur cohérence
     *
     * @return boolean True si tout s'est bien passé, False si une erreur est survenu
     */
    function verifParams(){
        return parent::verifParams();
    }

    /**
     * Exécution du rôle du controller
     *
     * @return boolean True si tout s'est bien passé, False si une erreur est survenu
     */
    function execute(){
        //On récupère le paramètre redirect et on prépare le message d'erreur correspondant
        if (isset($this->parametres["redirect"])) {
            $this->paramSortie["arrayResult"]["type_message"] = "info";
            switch ($_GET["redirect"]) {
                case 'deconnect':
                    $this->paramSortie["arrayResult"]["message"] = "Vous avez été déconnecté car votre session a expirée.";
                    break;
                case 'notconnected':
                    $this->paramSortie["arrayResult"]["message"] = "Vous n'êtes pas connecté ! ";
                    break;
                case 'reini':
                    $this->paramSortie["arrayResult"]["message"] = "La demande de réinitialisation a été envoyé avec succès. Vous recevrez un e-mail dans les prochaines minutes.";
                    break;
                case 'password':
                    $this->paramSortie["arrayResult"]["message"] = "Votre mot de passe a été réinitialisé avec succès.";
                    break;
                default:
                    $this->paramSortie["arrayResult"]["message"] = "";
                    break;
            }
        }

        //Si l'utilisateur est déjà connecté
        if($this->get("session")->isConnected() === true) {
            //On le redirige vers la page d'accueil
            header("Location:afficher_accueil.php");
        }
        //Sinon l'utilisateur n'est pas connecté
        else {
            //On récupère le formulaire de connexion depuis un objet utilisateur
            $nomObjet = $this->get("session")->getTableUser();
            $objUtilisateur = new $nomObjet();
            $this->paramSortie["htmlFormulaireConnexion"] = $objUtilisateur->formulaireConnexion();
        }

        return true;
    }

}