<?php

/**
 * Template : Formulaire de gestion d'un utilisateur
 * 
 * Paramètres :
 *  @param htmlFormulaire Code HTML du formulaire d'un utilisateur
 *  @param arrayResult [optionnal] Message de résultat à afficher sur le template
 */

?>

<div class="background-image">

</div>
<main class="container-full flex align-center justify-center direction-column" id="page_form_utilisateur">
    <?php 

        echo $parametres["htmlFormulaire"];
     
    ?>

    <?php 
        // Fragment pour l'affichage de message de retour
        include_once("src/templates/fragments/message.php");
    ?>
</main>
