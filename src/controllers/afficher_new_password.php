<?php

/**
 * Classe afficher_new_password : classe du controller afficher_new_password
 * @todo
 * Affiche le formulaire de définition du nouveau mot de passe
 */

class afficher_new_password extends _controller {

    /**
     * Attributs
     */

    // Nom du controller
    protected $name = "afficher_new_password";
    // Liste des objets manipulés par le controller
    protected $objects = []; // ["objet1" => ["action"1,"action2"...],"objet2" => ["action"1,"action2"...]]
    // Paramètres du controller attendus en entrée
    protected $paramEntree = [
        "selector" => ["method" => "GET", "required" => true],
        "validator" => ["method" => "GET", "required" => true]
    ]; // ["nom_param1"=>["method"=>"POST","required"=>true],"nom_param2"=>["method"=>"POST","required"=>false]]
    // Type de retour
    protected $typeRetour = "pages"; // json, fragments ou pages (défaut)
    // Nom du template
    protected $template = "form_new_password";
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

        // On vérifie que les paramètres nécessaires à afficher le formulaire sont présents
        if(!isSet($this->parametres["selector"]) || !isSet($this->parametres["validator"])){
            // Sinon on redirige vers la page de connexion
            header("Location: index.php?redirect=echecnewpassword");
            exit;
        }

        //On récupère les paramètres dans des variables
        $strSelector = $this->parametres["selector"];
        $strToken = $this->parametres["validator"];

        $this->paramSortie["htmlFormulaireNewPassword"] = $objUtilisateur->formulaireNewPassword(
            $strSelector,
            $strToken
        );

        return true;
    }

}