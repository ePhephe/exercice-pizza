<?php

/**
 * Classe new_password : classe du controller new_password
 * @todo
 * Gestion de la définition du nouveau mot de passe
 */

class new_password extends _controller {

    /**
     * Attributs
     */

    // Nom du controller
    protected $name = "new_password";
    // Liste des objets manipulés par le controller
    protected $objects = []; // ["objet1" => ["action"1,"action2"...],"objet2" => ["action"1,"action2"...]]
    // Paramètres du controller attendus en entrée
    protected $paramEntree = ["login" => ["method" => "POST", "required" => true]]; // ["nom_param1"=>["method"=>"POST","required"=>true],"nom_param2"=>["method"=>"POST","required"=>false]]
    // Type de retour
    protected $typeRetour = "pages"; // json, fragments ou pages (défaut)
    // Nom du template
    protected $template = "form_new_password";
    // Tableau de paramètre du template
    protected $paramTemplate = [ // ["head" => ["title" => "", "metadescription" => "", "lang" => ""], "is_nav" => true, "is_footer" => true]
        "head" => [
            "title" => "Accueil MyPizza", 
            "metadescription" => "", 
            "lang" => "fr"
        ], 
        "is_nav" => false, 
        "is_footer" => false
    ];
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
        return parent::verifParams();
    }

    /**
     * Exécution du rôle du controller
     *
     * @return boolean True si tout s'est bien passé, False si une erreur est survenu
     */
    function execute(){
        // On prépare un objet de la classe user
        $nomObjet = $this->get("session")->getTableUser();
        $objUtilisateur = new $nomObjet();
        // On vérifie que les paramètres nécessaires à lancer la réinitialisation sont présents
        if(!isSet($this->parametres["selector"]) || !isSet($this->parametres["validator"])){
            // Sinon on redirige vers la page de connexion
            header("Location: index.php?redirect=echecnewpassword");
            exit;
        }

        //On récupère les paramètres dans des variables
        $strSelector = $this->parametres["selector"];
        $strToken = $this->parametres["validator"];

        if(!isSet($this->parametres["login"]) || !isSet($this->parametres["password"]) || !isSet($this->parametres["confirmPassword"])){
            //On met en forme une erreur
            $this->paramSortie["arrayResult"]["type_message"] = "erreur";
            $this->paramSortie["arrayResult"]["message"] = "Nous n'avons pas les informations nécessaires à la définition de votre nouveau mot de passe.";
            //On récupère le formulaire de réinitialisation du mot de passe depuis un objet utilisateur
            $this->paramSortie["htmlFormulaireNewPassword"] = $objUtilisateur->formulaireNewPassword(
                $strSelector,
                $strToken
            );

            return false;
        }

        //On récupère les paramètres dans des variables
        $strLogin = $this->parametres["login"];
        $strPassword = $this->parametres["password"];
        $strConfirmPassword = $this->parametres["confirmPassword"];

        //On vérifie que le token est bon
        $resultat = $objUtilisateur->verifTokenReiniPassword($strLogin,$strSelector,$strToken);
        //Si le token n'est pas valide on affiche une erreur
        if($resultat === false){
            //On met en forme une erreur
            $this->paramSortie["arrayResult"]["type_message"] = "erreur";
            $this->paramSortie["arrayResult"]["message"] = "Nous n'avons pas réussi à définir votre nouveau mot de passe, refaites une demande de mot de passe oublié.";
            //On récupère le formulaire de réinitialisation du mot de passe depuis un objet utilisateur
            $this->paramSortie["htmlFormulaireNewPassword"] = $objUtilisateur->formulaireNewPassword(
                $strSelector,
                $strToken
            );

            return false;
        }
        else {
            //On essaye de mettre à jour le mot de passe
            $resultat = $objUtilisateur->updateNewPassword($strPassword,$strConfirmPassword);
            //Si le résultat n'est pas bon
            if($resultat === false){
                //On met en forme une erreur
                $this->paramSortie["arrayResult"]["type_message"] = "erreur";
                $this->paramSortie["arrayResult"]["message"] = "Nous n'avons pas réussi à définir votre nouveau mot de passe.";
                //On récupère le formulaire de réinitialisation du mot de passe depuis un objet utilisateur
                $this->paramSortie["htmlFormulaireNewPassword"] = $objUtilisateur->formulaireNewPassword(
                    $strSelector,
                    $strToken
                );

                return false;
            }
        }

        header("Location: index.php?redirect=password");
    }

}