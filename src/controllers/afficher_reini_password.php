<?php

/**
 * Classe afficher_reini_password : classe du controller afficher_reini_password
 * @todo
 * Affiche le formulaire de réinitialisation du mot de passe
 */

class afficher_reini_password extends _controller {

    /**
     * Attributs
     */

    // Nom du controller
    protected $name = "afficher_reini_password";
    // Liste des objets manipulés par le controller
    protected $objects = []; // ["objet1" => ["action"1,"action2"...],"objet2" => ["action"1,"action2"...]]
    // Paramètres du controller attendus en entrée
    protected $paramEntree = []; // ["nom_param1"=>["method"=>"POST","required"=>true],"nom_param2"=>["method"=>"POST","required"=>false]]
    // Type de retour
    protected $typeRetour = "pages"; // json, fragments ou pages (défaut)
    // Nom du template
    protected $template = "form_reini_password";
    // Paramètres en sortie du controller
    protected $paramSortie = []; // ["nom_param1"=>["required"=>true],"nom_param2"=>["required"=>false]]
    // Besoin d'être connecté
    protected $connected = false; // True par défaut

    /**
     * Vérifie que les paramètres du controller sont bien présents et/ou leur cohérence
     *
     * @return boolean True si tout s'est bien passé, False si une erreur est survenu
     */
    function verifParams(){
        
        return true;
    }

    /**
     * Exécution du rôle du controller
     *
     * @return boolean True si tout s'est bien passé, False si une erreur est survenu
     */
    function execute(){
        //On récupère le formulaire de réinitialisation du mot de passe depuis un objet utilisateur
        $nomObjet = $this->get("session")->getTableUser();
        $objUtilisateur = new $nomObjet();
        $this->paramSortie["htmlFormulaireReini"] = $objUtilisateur->formulaireReiniPassword();

        return true;
    }

}