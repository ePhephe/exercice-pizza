<?php

/**
 * Classe creer_pj : classe du controller creer_pj
 * @todo
 * Gestion de la création d'une pièce jointe
 */

class creer_pj extends _controller {

    /**
     * Attributs
     */

    // Nom du controller
    protected $name = "creer_pj";
    // Liste des objets manipulés par le controller
    protected $objects = [

    ]; // ["objet1" => ["action"1,"action2"...],"objet2" => ["action"1,"action2"...]]
    // Paramètres du controller attendus en entrée
    protected $paramEntree = [ // ["nom_param1"=>["method"=>"POST","required"=>true],"nom_param2"=>["method"=>"POST","required"=>false]]
    ]; 
    // Type de retour
    protected $typeRetour = "pages"; // json, fragments ou pages (défaut)
    // Nom du template
    protected $template = "form_piecejointe";
    // Tableau de paramètre du template
    protected $paramTemplate = [ // ["head" => ["title" => "", "metadescription" => "", "lang" => ""], "is_nav" => true, "is_footer" => true]
        "head" => [
            "title" => "Ajouter une pièce jointe", 
            "metadescription" => "", 
            "lang" => "fr"
        ], 
        "is_nav" => false, 
        "is_footer" => false
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
    function verifParams(){
        // S'il n'y a pas de paramètre id, on l'initialise à 0
        if(!isSet($this->parametres["id"])) $this->parametres["action"] = "create";
        else $this->parametres["action"] = "update";
        if(!isSet($this->parametres["id"])) $this->parametres["id"] = 0;

        // On appelle en premier le contrôle global
        return parent::verifParams();
    }

    /**
     * Exécution du rôle du controller
     *
     * @return boolean True si tout s'est bien passé, False si une erreur est survenu
     */
    function execute(){
        // On commence par appeler la vérification des paramètres
        if(!$this->verifParams()) {
            $this->makeRetour(false,"param","(1) Les paramètres fournis ne sont pas corrects.");
        }
        // On instancie l'objet de l'utilisateur passé en paramètre
        $objet = new piecejointe ();

        $objet->uploadFile($_FILES["pj_nom_fichier"]);
        $objet->insertFile();

        // On génère le formulaire
        $this->paramSortie["htmlFormulaire"] = $objet->getFormulaire($this->parametres["action"]);
    }
}