<?php

/**
 * Classe modifier_composition_pizza : classe du controller modifier_composition_pizza
 * @todo
 * Gestion de la modification de la composition d'une pizza
 */

class modifier_composition_pizza extends _controller {

    /**
     * Attributs
     */

    // Nom du controller
    protected $name = "modifier_utilisateur";
    // Liste des objets manipulés par le controller
    protected $objects = ["utilisateur" => ["update"]]; // ["objet1" => ["action"1,"action2"...],"objet2" => ["action"1,"action2"...]]
    // Paramètres du controller attendus en entrée
    protected $paramEntree = [ // ["nom_param1"=>["method"=>"POST","required"=>true],"nom_param2"=>["method"=>"POST","required"=>false]]
        "idpizza" => ["method" => "_GET", "required" => true],
        "form" => ["method" => "_POST", "required" => true],
        "type" => ["method" => "_GET", "required" => true]
    ]; 
    // Type de retour
    protected $typeRetour = "json"; // json, fragments ou pages (défaut)
    // Nom du template
    protected $template = "";
    // Tableau de paramètre du template
    protected $paramTemplate = [ // ["head" => ["title" => "", "metadescription" => "", "lang" => ""], "is_nav" => true, "is_footer" => true]
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
            $this->makeRetour(false,"echec","(0) Les paramètres fournis ne sont pas corrects");
            return false;
        }

        // On instancie un objet de la pizza
        $objPizza = new pizza($this->parametres["idpizza"]);

        // On gère les ingrédients, si ce n'est pas un tableau on le transforme en tableau
        $ingredients = [];
        if(!is_array($this->parametres["form"]["c_ref_ingredient"]))
            $ingredients[] = $this->parametres["form"]["c_ref_ingredient"];
        else
            $ingredients = $this->parametres["form"]["c_ref_ingredient"];

        // On lance la modification des ingrédients de la pizza
        if($objPizza->update_ingredients($this->parametres["type"],$ingredients,$this->parametres["form"])){
            $this->makeRetour(true,"succes","L'ingrédient de votre pizza a été mise à jour.");
        }
        else {
            $this->makeRetour(false,"echec","(1) Echec dans la modification de la composition de la pizza.");
        }
    }
}