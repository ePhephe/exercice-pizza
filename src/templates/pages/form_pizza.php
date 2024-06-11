<?php

/**
 * Template : Formulaire de gestion d'une pizza
 * 
 * Paramètres :
 *  @param htmlFormulaire Code HTML du formulaire d'une pizza
 *  @param arrayResult [optionnal] Message de résultat à afficher sur le template
 */

?>

<div class="background-image">

</div>
<main class="container-full flex align-center justify-center direction-column" id="page_form_pizza">
    <?php 

        // Formulaire général de la pizza
        echo $parametres["htmlFormulaire"];

        // Liste de la composition s'il y a
        if(!empty($parametres["arrayCompositionPizza"])) echo $parametres["arrayCompositionPizza"];
    
    ?>

    <nav class="large-12-12" id="liensComposition">
        <ul class="flex justify-between align-center">
            <li class="large-3-12 flex justify-center"><a data-type="T" href="">1. Taille</a></li>
            <li class="separateur_etapes_pizza">></li>
            <li class="large-3-12 flex justify-center"><a data-type="P" href="">2. Pâte</a></li>
            <li class="separateur_etapes_pizza">></li>
            <li class="large-3-12 flex justify-center"><a data-type="B" href="">3. Base</a></li>
            <li class="separateur_etapes_pizza">></li>
            <li class="large-3-12 flex justify-center"><a data-type="I" href="">4. Ingrédients</a></li>
        </ul>
    </nav>

    <div id="formComposition">

    </div>

    <?php

        // Fragment pour l'affichage de message de retour
        include_once("src/templates/fragments/message.php");
    ?>
</main>
<script src="public/js/form_pizza.js"></script>
