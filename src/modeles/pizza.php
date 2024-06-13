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
    // Nombres possible par type
    protected $nbIngredient = [
        "T" => ["min" => 1, "max" => 1],
        "P" => ["min" => 1, "max" => 1],
        "B" => ["min" => 1, "max" => 1],
        "I" => ["min" => 2, "max" => 5]
    ];

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
        $this->load_composition();
    }
        
    /**
     * Retourne la liste de la composition de la pizza
     *
     * @return array Liste de la composition de la pizza
     */
    function get_composition(){
        return $this->listComposition;
    }

    /**
     * Charge les ingrédients composants la pizza
     *
     * @return void
     */
    function load_composition(){
        // On instancie un objet composition
        $objComposition = new composition();

        // On appelle la liste avec le paramètre sur l'id de la pizza
        $this->listComposition = $objComposition->list([],[
                [
                    "champ" => "c_ref_pizza",
                    "valeur" => $this->id(),
                    "operateur" => "=",
                    "table" => "composition"
                ]
            ]
        );
    }
    
    /**
     * Met à jours les ingrédients
     *
     * @param  string $type Type de l'ingrédient à mettre à jour
     * @param  mixed $ingredients Tableau des ingrédients transmis ou identifiant d'un ingrédient s'il est seul
     * @return boolean True si tout s'est bien passé sinon False
     */
    function update_ingredients($type = "all",$ingredients) {
        // Si le tableau est vide, on réalise un insert
        if(empty($this->listComposition)) {
            // On vérifie si on est sur un ingrédient unique ou un tableau d'ingrédients
            if(!is_array($ingredients)) {
                // On instancie notre composition
                $objComposition = new composition();

                // On va chercher les informations de l'ingrédient
                $objIngredient = new ingredient($ingredients);

                // On paramètre la composition
                $objComposition->set("c_ref_ingredient",$objIngredient->id());
                $objComposition->set("c_ref_pizza",$this->id());
                $objComposition->set("c_prix_ingredient_pizza",$objIngredient->get("i_prix")->getValue());

                // On lance l'insert
                return $objComposition->insert();
            }
            else {
                // On vérifie qu'on a le bon nombre d'ingrédient
                if($this->nbIngredient[$type]["max"] > count($ingredients)) {
                    // On parcourt les ingrédient et on les ajoute
                }
            }
        }
        else {
            // On vérifie si on est sur un ingrédient unique ou un tableau d'ingrédients
            if(!is_array($ingredients)) {
                // On parcourt la composition jusqu'à tomber sur le bon ingrédient
                foreach ($this->listComposition as $id => $composition) {
                    if($composition->get("c_ref_ingredient")->getObjet()->get("i_type")->getValue() === $type){
                        // On récupère la composition correspondante
                        $objComposition = $composition;
                    }
                }

                // On va chercher les informations de l'ingrédient
                $objIngredient = new ingredient($ingredients);

                if(isSet($objComposition)) {
                    // On paramètre la composition
                    $objComposition->set("c_ref_ingredient",$objIngredient->id());
                    $objComposition->set("c_prix_ingredient_pizza",$objIngredient->get("i_prix")->getValue());

                    // On lance l'update
                    return $objComposition->update();
                }
                else {
                    // On instancie notre composition
                    $objComposition = new composition();
                    // On paramètre la composition
                    $objComposition->set("c_ref_ingredient",$objIngredient->id());
                    $objComposition->set("c_ref_pizza",$this->id());
                    $objComposition->set("c_prix_ingredient_pizza",$objIngredient->get("i_prix")->getValue());
                    // On lance l'insert
                    return $objComposition->insert();
                }
            }
            else {
                // On vérifie qu'on a le bon nombre d'ingrédient
                if($this->nbIngredient[$type]["max"] > count($ingredients)) {
                    // On parcourt les ingrédient et on les ajoute
                }
            }
        }

        // Si on est supérieur ou égal au max soit :
        // On update dans le cas d'un ingrédient unique (Taille, Pâte, Base)
        // On retourne une erreur en cas d'ingrédient multipe (ingrédients)
    }
    
}