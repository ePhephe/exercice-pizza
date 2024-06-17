<?php

/**
 * 
 * Attributs disponibles
 * @property $table Nom de la table
 * 
 * Méthodes disponibles
 * @method get_element_form_c_ref_ingredient() Retourne le formulaire pour ajouter des ingrédients
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
     * Retourne le formulaire pour ajouter des ingrédients
     *
     * @param  array $infosChamp Informations sur le champ
     * @param  string $acces Accès aux champs
     * @param  array $others Autres informations du formulaire à utiliser
     * @return string Code HTML correspondant
     */
    function get_element_form_c_ref_ingredient($infosChamp, $acces, $others){
        // On initialise le template HTML
        $templateHTML = '<div id="div_c_ref_ingredient">';

        // On récupère un objet de la pizza en cours
        $objPizza = new pizza($others["idpizza"]);

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

            $checked = "";
            foreach ($objPizza->get_composition() as $key => $compo) {
                if($idIngredient == $compo->get("c_ref_ingredient")->getValue()) {
                    $checked = "checked";
                    $dosage = $compo->get("c_dosage_ingredient")->getValue();
                }
            }

            // Si on est sur les ingrédient alors affichage en checkbox et on demande le dosage
            if($infosChamp["autorised_value"] === "I") {
                $templateHTML .= '<input data-type="'.$infosChamp["autorised_value"].'" type="checkbox" id="c_ref_ingredient_'.$idIngredient.'" name="c_ref_ingredient[]" value="'.$idIngredient.'" '.$checked.' />
                    <label for="c_ref_ingredient_'.$idIngredient.'"><img src="'.$objIngredient->get("i_ref_piecejointe_photo")->getObjet()->get_url().'" alt="">
                    '.$objIngredient->getValue("i_nom").' <div class="description">'.$objIngredient->getValue("i_description").'</div>';
                    if($checked != "") {
                        $this->get("c_dosage_ingredient")->setValue($dosage);
                        $templateHTML .= $this->get("c_dosage_ingredient")->getElementFormulaire(["prefix_name" => "c_ref_ingredient_".$idIngredient]);
                    }
                    else {
                        $this->get("c_dosage_ingredient")->setValue("");
                        $templateHTML .= $this->get("c_dosage_ingredient")->getElementFormulaire(["prefix_name" => "c_ref_ingredient_".$idIngredient],"disabled");
                    }
                        
                $templateHTML .= '</label>';
            }
            // Sinon on est sur de la radiobox
            else {
                $templateHTML .= '<input data-type="'.$infosChamp["autorised_value"].'" type="radio" id="c_ref_ingredient_'.$idIngredient.'" name="c_ref_ingredient" value="'.$idIngredient.'"  '.$checked.' />
                    <label for="c_ref_ingredient_'.$idIngredient.'"><img src="'.$objIngredient->get("i_ref_piecejointe_photo")->getObjet()->get_url().'" alt="">
                    '.$objIngredient->getValue("i_nom").' <div class="description">'.$objIngredient->getValue("i_description").'</div>
                    </label>';
            }
            $templateHTML .= '</div>';
        }

        $templateHTML .= '</div>';

        return $templateHTML;
    }
}