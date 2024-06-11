<?php

/**
 * Classe afficher_form_composition : classe du controller afficher_form_composition
 * @todo
 * Affiche le formulaire de gestion d'une composition de pizza
 */

class afficher_form_composition extends _controller {

    /**
     * Attributs
     */

    // Nom du controller
    protected $name = "afficher_form_utilisateur";
    // Liste des objets manipulés par le controller
    protected $objects = [
        "composition" => ["read"],
        "ingredient" => ["read"]
    ]; // ["objet1" => ["action"1,"action2"...],"objet2" => ["action"1,"action2"...]]
    // Paramètres du controller attendus en entrée
    protected $paramEntree = [
        "idpizza" => ["method" => "_GET", "required" => true],
        "type" => ["method" => "_GET", "required" => false],
        "action" => ["method" => "_GET", "required" => false]
    ]; // ["nom_param1"=>["method"=>"POST","required"=>true],"nom_param2"=>["method"=>"POST","required"=>false]]
    // Type de retour
    protected $typeRetour = "json"; // json, fragments ou pages (défaut)
    // Nom du template
    protected $template = "";
    // Tableau de paramètre du template
    protected $paramTemplate = [ // ["head" => ["title" => "", "metadescription" => "", "lang" => ""], "is_nav" => true, "is_footer" => true]

    ];
    // Besoin d'être connecté
    protected $connected = true; // True par défaut

    /**
     * Vérifie que les paramètres du controller sont bien présents et/ou leur cohérence
     *
     * @return boolean True si tout s'est bien passé, False si une erreur est survenu
     */
    function verifParams() {
        if(!isSet($this->parametres["type"])) $this->parametres["type"] = "all";
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
        
        // On prépare un objet de la classe composition
        $objComposition = new composition();
        $this->paramSortie["result"] = $objComposition->getFormulaire("create",true,[
            "c_ref_ingredient" => ["autorised_value" => $this->parametres["type"]],
            "c_dosage_ingredient" => ["display" => "none"]
        ]);

        $this->makeRetour(true,"succes","ok");
    }

}