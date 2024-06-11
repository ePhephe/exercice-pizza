<?php

/**
 * 
 * Attributs disponibles
 * @property $table Nom de la table
 * 
 * Méthodes disponibles
 * @method 
 * 
 */

/**
 * Classe composition : classe de gestion des composition
 */

class composition extends _model {

    /**
     * Attributs
     */

    // Nom de la table dans la BDD
    protected $table = "composition";

    /**
     * Méthodes
     */

    /**
     * get_element_form_c_ref_ingredient
     *
     * @param  mixed $infosChamp
     * @param  mixed $acces
     * @return void
     */
    function get_element_form_c_ref_ingredient($infosChamp, $acces){
        // On initialise le template HTML
        $templateHTML = '<div id="div_c_ref_ingredient">';

        // On instancie un nouvel objet de la classe ingrédient
        $objIngredient = new ingredient();
        // On va récupérer la liste des ingrédients en fonction du type souhaité
        $arrayResult = $objIngredient->list([],[
            [
                "champ" => "i_type",
                "valeur" => $infosChamp["autorised_value"],
                "operateur" => "=",
                "table" => "ingredient"
            ]
        ]);

        // On parcourt chaque ingrédient et on le remet en forme
        foreach ($arrayResult as $idIngredient => $objIngredient) {
            $templateHTML .= '<div id="div_c_ref_ingredient_'.$idIngredient.'">';
            
            // Si on est sur les ingrédient alors affichage en checkbox et on demande le dosage
            if($infosChamp["autorised_value"] === "I") {
                $templateHTML .= '<input type="checkbox" id="c_ref_ingredient_'.$idIngredient.'" name="c_ref_ingredient" value="'.$idIngredient.'" />
                    <label for="coding">'.$objIngredient->getValue("i_nom").' <div class="description">'.$objIngredient->getValue("i_description").'</div>
                    <img src="" alt="">';
                $templateHTML .= $this->get("c_dosage_ingredient")->getElementFormulaire();
                $templateHTML .= '</label>';
            }
            // Sinon on est sur de la radiobox
            else {
                $templateHTML .= '<input type="radio" id="c_ref_ingredient_'.$idIngredient.'" name="c_ref_ingredient" value="'.$idIngredient.'" />
                    <label for="coding">'.$objIngredient->getValue("i_nom").' <div class="description">'.$objIngredient->getValue("i_description").'</div>
                    <img src="" alt=""></label>';
            }
            $templateHTML .= '</div>';
        }

        $templateHTML .= '</div>';

        return $templateHTML;
    }
    
}