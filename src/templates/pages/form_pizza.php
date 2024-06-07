<?php

/**
 * Template : Formulaire de gestion d'une pizza
 * 
 * Paramètres :
 *  @param htmlFormulaire Code HTML du formulaire d'une pizza
 *  @param arrayResult [optionnal] Message de résultat à afficher sur le template
 */

?>

<div class="background_app">

</div>
<main class="container-full flex align-center justify-center direction-column">
    <?php 

        // Formulaire général de la pizza
        echo $parametres["htmlFormulaire"];

        // Liste de la composition s'il y a
        if(!empty($parametres["arrayCompositionPizza"])) echo $parametres["arrayCompositionPizza"];
    
    ?>

    <nav>
        <ul>
            <li><a href="">Taille</a></li>
            <li>></li>
            <li><a href="">Pâte</a></li>
            <li>></li>
            <li><a href="">Base</a></li>
            <li>></li>
            <li><a href="">Ingrédients</a></li>
        </ul>
    </nav>

    <?php

        // Fragment pour l'affichage de message de retour
        include_once("src/templates/fragments/message.php");
    ?>
</main>
