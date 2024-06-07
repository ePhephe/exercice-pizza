<?php

/**
 * Classe reinitialisation_password : classe du controller reinitialisation_password
 * @todo
 * Réinitialisation du mot de passe
 */

class reinitialisation_password extends _controller {

    /**
     * Attributs
     */

    // Nom du controller
    protected $name = "reinitialisation_password";
    // Liste des objets manipulés par le controller
    protected $objects = []; // ["objet1" => ["action"1,"action2"...],"objet2" => ["action"1,"action2"...]]
    // Paramètres du controller attendus en entrée
    protected $paramEntree = ["login" => ["method" => "POST", "required" => true]]; // ["nom_param1"=>["method"=>"POST","required"=>true],"nom_param2"=>["method"=>"POST","required"=>false]]
    // Type de retour
    protected $typeRetour = "pages"; // json, fragments ou pages (défaut)
    // Nom du template
    protected $template = "form_reini_password";
    // Tableau de paramètre du template
    protected $paramTemplate = [ // ["head" => ["title" => "", "metadescription" => "", "lang" => ""], "is_nav" => true, "is_footer" => true]
        "head" => [
            "title" => "Accueil MyPizza", 
            "metadescription" => "", 
            "lang" => "fr"
        ], 
        "is_nav" => false, 
        "is_footer" => false
    ];
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
        // On prépare un objet de la classe user
        $nomObjet = $this->get("session")->getTableUser();
        $objUtilisateur = new $nomObjet();
        //On vérifie que les paramètres nécessaires à lancer la réinitialisation sont présents
        if(!isSet($this->parametres["login"])){
            //On met en forme une erreur si les paramètres nécessaires sont absents
            $this->paramSortie["arrayResult"]["type_message"] = "erreur";
            $this->paramSortie["arrayResult"]["message"] = "Merci de renseigner correctement votre identifiant.";
            //On récupère le formulaire de réinitialisation du mot de passe depuis un objet utilisateur
            $this->paramSortie["htmlFormulaireReini"] = $objUtilisateur->formulaireReiniPassword();
            
            return false;
        }

        //On lance la demande de réinitialisation du mot de passe
        $resultatReini = $objUtilisateur->demandeReiniPassword($this->parametres["login"]);
        //Si la demande est un échec
        if($resultatReini === false){
            //On met en forme une erreur
            $this->paramSortie["arrayResult"]["type_message"] = "erreur";
            $this->paramSortie["arrayResult"]["message"] = "Nous n'avons pas réussi à réinitialiser votre mot de passe.";
            //On récupère le formulaire de réinitialisation du mot de passe depuis un objet utilisateur
            $this->paramSortie["htmlFormulaireReini"] = $objUtilisateur->formulaireReiniPassword();

            return false;
        }

        header("Location: index.php?redirect=reini");
    }

}