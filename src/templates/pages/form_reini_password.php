<?php

/**
 * Template : Formulaire de réinitialisation du mot de passe
 * 
 * Paramètres :
 *  @param htmlFormulaireReini Code HTML du formulaire de connexion
 *  @param arrayResult [optionnal] Message de résultat à afficher sur le template
 */

?>

<div class="background_app">

</div>
<main class="container-full flex align-center justify-center direction-column">
    <?php 

        echo $parametres["htmlFormulaireReini"];

        // Fragment pour l'affichage de message de retour
        include_once("src/templates/fragments/message.php");
    ?>
</main>
