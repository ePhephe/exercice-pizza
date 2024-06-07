<?php

/**
 * Classe afficher_form_utilisateur : classe du controller afficher_form_utilisateur
 * @todo
 * Affiche le formulaire de gestion d'un' utilisateur
 */

class afficher_form_utilisateur extends _controller {

    /**
     * Attributs
     */

    // Nom du controller
    protected $name = "afficher_form_utilisateur";
    // Liste des objets manipulés par le controller
    protected $objects = [
        "utilisateur" => ["read"]
    ]; // ["objet1" => ["action"1,"action2"...],"objet2" => ["action"1,"action2"...]]
    // Paramètres du controller attendus en entrée
    protected $paramEntree = [
        "id" => ["method" => "GET", "required" => false],
        "action" => ["method" => "GET", "required" => false]
    ]; // ["nom_param1"=>["method"=>"POST","required"=>true],"nom_param2"=>["method"=>"POST","required"=>false]]
    // Type de retour
    protected $typeRetour = "pages"; // json, fragments ou pages (défaut)
    // Nom du template
    protected $template = "form_utilisateur";
    // Tableau de paramètre du template
    protected $paramTemplate = [ // ["head" => ["title" => "", "metadescription" => "", "lang" => ""], "is_nav" => true, "is_footer" => true]
        "head" => [
            "title" => "Accueil MyPizza", 
            "metadescription" => "", 
            "lang" => "fr"
        ], 
        "is_nav" => true, 
        "is_footer" => true
    ];
    // Paramètres en sortie du controller
    protected $paramSortie = []; // ["nom_param1"=>["required"=>true],"nom_param2"=>["required"=>false]]
    // Besoin d'être connecté
    protected $connected = true; // True par défaut

    /**
     * Vérifie que les paramètres du controller sont bien présents et/ou leur cohérence
     *
     * @return boolean True si tout s'est bien passé, False si une erreur est survenu
     */
    function verifParams() {
        // S'il n'y a pas de paramètre id, on l'initialise à 0
        if(!isSet($this->parametres["id"])) $this->parametres["id"] = 0;

        // S'il n'y a pas de paramètre action, on l'initialise à read
        if(!isSet($this->parametres["action"])) $this->parametres["action"] = "read";

        return parent::verifParams();
    }

    /**
     * Exécution du rôle du controller
     *
     * @return boolean True si tout s'est bien passé, False si une erreur est survenu
     */
    function execute(){
        // On déclenche la vérification des paramètres 
        $this->verifParams();
        // On prépare un objet de la classe user
        $nomObjet = $this->get("session")->getTableUser();
        $objUtilisateur = new $nomObjet($this->parametres["id"]);

        // On génère le formulaire
        $this->paramSortie["htmlFormulaire"] = $objUtilisateur->getFormulaire($this->parametres["action"],$json=true);

        return true;
    }

}