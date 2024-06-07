<?php

/**
 * 
 * Attributs disponibles
 * @property $table Nom de la table
 * @property $listIngredients Liste des ingrédients
 * 
 * Méthodes disponibles
 * @method __construct() Constructeur de l'objet
 * 
 */

/**
 * Classe pizza : classe de gestion des pizza
 */

class pizza extends _model {

    /**
     * Attributs
     */
    // Nom de la table dans la BDD
    protected $table = "pizza";
    // Liste des ingrédients qui composent la pizza
    protected $listComposition = [];

    /**
     * Méthodes
     */

    /**
     * Constructeur de l'objet
     *
     * @param  integer $id Identifiant de l'objet à charger
     * @param  boolean $partitionement Si l'objet est soumis au partitionnement de données
     * @return void
     */
    function __construct($id = null, $partitionement = false) {
        // On apppelle la méthode parente
        parent::__construct($id,$partitionement);

        // Puis on construit la liste des ingrédients de la pizza
    }
        
    /**
     * Retourne la liste de la composition de la pizza
     *
     * @return array Liste de la composition de la pizza
     */
    function get_composition(){
        return $this->listComposition;
    }
    
}