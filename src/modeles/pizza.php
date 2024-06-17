<?php

/**
 * 
 * Attributs disponibles
 * @property $table Nom de la table
 * @property $listComposition Liste de la composition de la pizza
 * @property $nbIngredients Nombre d'ingrédients autorisés dans la pizza
 * @property $prixTotal Prix total calculé de la pizza
 * 
 * Méthodes disponibles
 * @method __construct() Constructeur de l'objet
 * @method get_composition() Retourne la liste de la composition de la pizza
 * @method get_prix_total() Retourne le prix total de la pizza
 * @method load_composition() Charge les ingrédients composants la pizza
 * @method update_ingredients() Met à jour les ingrédients
 * @method verif_completion() Vérifie que la pizza est suffisament complète et met à jour son statut
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
    // Prix total de la pizza
    protected $prixTotal = 0.00;

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
     * Retourne le prix total de la pizza
     *
     * @return float Prix de la pizza
     */
    function get_prix_total(){
        if($this->prixTotal == 0) {
            $this->load_composition();
        }

        return $this->prixTotal;
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

        $this->prixTotal = 0;
        foreach ($this->listComposition as $composition) {
            $this->prixTotal += $composition->get("c_prix_ingredient_pizza")->getValue();
        }
    }
    
    /**
     * Met à jour les ingrédients
     *
     * @param  string $type Type de l'ingrédient à mettre à jour
     * @param  mixed $ingredients Ingrédient à mettre à jour ou tableau d'ingrédients
     * @param  array $infosForm Informations du formulaire d'ingrédients (utile pour récupérer les dosages)
     * @return boolean True si tout s'est bien passé sinon False
     */
    function update_ingredients($type = "all",$ingredients, $infosForm = []) {
        // On contrôle la limite en fonction du type d'ingrédient (sauf si on est sur type = "all")
        if($type != "all") {
            // Si le nombre d'ingrédient passé en paramètre est supérieur au maximum, on retourne une erreur
            if($this->nbIngredient[$type]["max"] < count($ingredients)) return false;
        }

        // On va vérifier s'il y a déjà une composition pour ce type d'ingrédient
        foreach ($this->listComposition as $idCompo => $composition) {
            // Si on a une correspondance, on vide la composition avant d'entrer la nouvelle
            if($composition->get("c_ref_ingredient")->getObjet()->get("i_type")->getValue() === $type) {
                $composition->delete();
            }
        }

        // On parcourt maintenant les options d'ingrédient qu'on a reçu
        foreach ($ingredients as $ingredient) {
            // On instancie l'objet ingrédient correspondant
            $objIngredient = new ingredient($ingredient);

            // On instancie ausi un objet compostion
            $objComposition = new composition();

            // On prépare les variables dosage et prix
            $dosage = (isSet($infosForm["c_ref_ingredient_".$ingredient."_c_dosage_ingredient"])) ? $infosForm["c_ref_ingredient_".$ingredient."_c_dosage_ingredient"] : 1;
            $prix = $objIngredient->get("i_prix")->getValue()*$dosage;

            // On set tous nos paramètres
            $objComposition->set("c_ref_ingredient",$ingredient);
            $objComposition->set("c_ref_pizza",$this->id());
            $objComposition->set("c_prix_ingredient_pizza",$prix);
            $objComposition->set("c_dosage_ingredient",$dosage);
            
            // On ajoute la composition dans la base
            $objComposition->insert();
        }
        
        // On recharge la composition complète de la pizza
        $this->load_composition();

        // On va vérifier si elle est complète
        $this->verif_completion();

        return true;
    }
    
    /**
     * Vérifie que la pizza est suffisament complète et met à jour son statut
     *
     * @return void
     */
    function verif_completion(){
        // On initialise un tableau où on va compter les ingrédient
        $arrayVerifCompo = ["T" => 0,"B" => 0,"P" => 0,"I" => 0];

        // On parcourt les compositions et on compte
        foreach ($this->listComposition as $key => $composition) {
            $arrayVerifCompo[$composition->get("c_ref_ingredient")->getObjet()->get("i_type")->getValue()]++;
        }

        $complete = true;
        foreach ($this->nbIngredient as $key => $contraintes) {
            if($arrayVerifCompo[$key] > $contraintes["max"] || $contraintes["min"] > $arrayVerifCompo[$key])
                $complete = false;
        }

        if($complete === true)
            $this->get("p_statut")->setValue("T");
        else
            $this->get("p_statut")->setValue("EC");


        $this->update();
    }
    
}