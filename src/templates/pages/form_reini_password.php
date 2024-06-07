<?php

/**
 * Template : Formulaire de réinitialisation du mot de passe
 * 
 * Paramètres :
 *  @param htmlFormulaireReini Code HTML du formulaire de connexion
 *  @param arrayResult [optionnal] Message de résultat à afficher sur le template
 */

?>

<div class="background-image">

</div>
<main class="container-full flex align-center justify-center" id="template_form_connexion">
    <div class="formulaire large-10-12 flex align-center justify-around">
        <img class="large-6-12" src="public/images/logo.png" alt="Logo de l'application Pizz'Artiste">
    <?php 

        echo $parametres["htmlFormulaireReini"];

        // Fragment pour l'affichage de message de retour
        include_once("src/templates/fragments/message.php");
    ?>
    </div>
</main>