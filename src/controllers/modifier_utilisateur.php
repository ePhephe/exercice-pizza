<?php

/**
 * Classe modifier_utilisateur : classe du controller modifier_utilisateur
 * @todo
 * Gestion de la modification d'un compte utilisateur
 */

class modifier_utilisateur extends _controller {

    /**
     * Attributs
     */

    // Nom du controller
    protected $name = "modifier_utilisateur";
    // Liste des objets manipulés par le controller
    protected $objects = ["utilisateur" => ["update"]]; // ["objet1" => ["action"1,"action2"...],"objet2" => ["action"1,"action2"...]]
    // Paramètres du controller attendus en entrée
    protected $paramEntree = [ // ["nom_param1"=>["method"=>"POST","required"=>true],"nom_param2"=>["method"=>"POST","required"=>false]]
        "id" => ["method" => "_GET", "required" => true],
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
            $this->makeRetour(false,"param","(1) Les paramètres fournis ne sont pas corrects.");
        }
        // On instancie l'objet de l'utilisateur passé en paramètre
        $nomObjet = $this->session->getTableUser();
        $objUtilisateur = new $nomObjet($this->parametres["id"]);
        // On commence par appeler la vérification des paramètres
        if($objUtilisateur->verifParamsFormulaire($this->parametres["form"])){
            // On réalise la mise à jour dans la base de données
            $resultat = $objUtilisateur->update();
            // Si la modification a fonctionné
            if($resultat === true) {
                // On prépare le retour
                $this->makeRetour(true,"succes","L'utilisateur a été mise à jour avec succès !");
            }
            else {
                // Sinon on formate une erreur
                $this->makeRetour(false,"echec","La mise à jour n'a pas pu être effectuée.");
            }
        }
        else {
            $this->makeRetour(false,"param","(2) Les paramètres fournis ne sont pas corrects.");
        }
    }
}