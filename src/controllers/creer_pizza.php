<?php

/**
 * Classe creer_pizza : classe du controller creer_pizza
 * @todo
 * Gestion de la création d'une pizza
 */

class creer_pizza extends _controller {

    /**
     * Attributs
     */

    // Nom du controller
    protected $name = "creer_pizza";
    // Liste des objets manipulés par le controller
    protected $objects = ["pizza" => ["create"]]; // ["objet1" => ["action"1,"action2"...],"objet2" => ["action"1,"action2"...]]
    // Paramètres du controller attendus en entrée
    protected $paramEntree = [ // ["nom_param1"=>["method"=>"POST","required"=>true],"nom_param2"=>["method"=>"POST","required"=>false]]
        "form" => ["method" => "_POST", "required" => true]
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
        // On teste le verifParams parent, si c'est OK on continue
        if(parent::verifParams()) {
            // On vérifie que l'on a au moins le nom de la pizza
            if(empty($this->parametres["form"]["p_nom"]) || empty($this->parametres["form"]["p_description"]) )
                return false;
            else
                return true;
        }
        else {
            return false;
        }
    }

    /**
     * Exécution du rôle du controller
     *
     * @return boolean True si tout s'est bien passé, False si une erreur est survenu
     */
    function execute(){
        // On commence par appeler la vérification des paramètres
        if($this->verifParams()) {
            $objPizza = new pizza();
            if($objPizza->verifParamsFormulaire($this->parametres["form"])){
                // On met le bon statut et l'utilisateur créateur
                $objPizza->set("p_statut","C");
                $dateCreation = new DateTime();
                $objPizza->set("p_date_creation",$dateCreation->format("Y-m-d H:i:s"));
                $objPizza->set("p_ref_utilisateur_createur",$this->session->id());
                // On réalise la mise à jour dans la base de données
                $resultat = $objPizza->insert();
                // Si la modification a fonctionné
                if($resultat === true) {
                    // On prépare le retour
                    $this->paramSortie["id"] = $objPizza->id();
                    $this->makeRetour(true,"succes","La pizza a été créée avec succès !");
                }
                else {
                    // Sinon on formate une erreur
                    $this->makeRetour(false,"echec","(3) La pizza n'a pas pu être créée ! ");
                }
            }
            else {
                $this->makeRetour(false,"param","(2) Les paramètres fournis ne sont pas corrects.");
            }
        }
        else {
            $this->makeRetour(false,"param","(1) Les paramètres fournis ne sont pas corrects.");
        }
    }
}