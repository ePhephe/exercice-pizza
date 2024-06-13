<?php

/**
 * Classe lister_pizzas : classe du controller lister_pizzas
 * @todo
 * Afficher la liste de mes pizzas
 */

class lister_pizzas extends _controller {

    /**
     * Attributs
     */

    // Nom du controller
    protected $name = "lister_pizzas";
    // Liste des objets manipulés par le controller
    protected $objects = ["pizza" => "read"]; // ["objet1" => ["action"1,"action2"...],"objet2" => ["action"1,"action2"...]]
    // Paramètres du controller attendus en entrée
    protected $paramEntree = [ // ["nom_param1"=>["method"=>"POST","required"=>true],"nom_param2"=>["method"=>"POST","required"=>false]]
    ]; 
    // Type de retour
    protected $typeRetour = "pages"; // json, fragments ou pages (défaut)
    // Nom du template
    protected $template = "liste_pizzas";
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
    function verifParams(){
        return parent::verifParams();
    }

    /**
     * Exécution du rôle du controller
     *
     * @return boolean True si tout s'est bien passé, False si une erreur est survenu
     */
    function execute(){
        //On instancie un objet Pizza
        $objPizza = new pizza();
        $this->paramSortie["listePizza"] = $objPizza->list();
    }

}