<?php

/**
 * 
 * Attributs disponibles
 * @property
 * 
 * Méthodes disponibles
 * @method 
 * 
 */

/**
 * Classe pizza : classe de gestion des pizza
 */

class pizza extends _model {

    /**
     * Attributs
     */
    // Liste des ingrédients qui composent la pizza
    protected $listIngredients = [];

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
    
}