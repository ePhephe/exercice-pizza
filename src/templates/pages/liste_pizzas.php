<?php

/**
 * Template : Listing des pizzas d'un utilisateur 
 * 
 * Paramètres :
 *  Néant
 */

?>

<div class="background-image">

</div>
<main class="container-full flex align-center justify-center" id="page_liste_pizza">
    <h1>Mes créations</h1>
    <section class="flex justify-around">
    <?php 
        foreach ($parametres["listePizza"] as $id => $pizza) {
    ?>
        <article>
            <a class="icon-delete" href="afficher_form_pizza.php?id=<?= $pizza->id() ?>&action=delete"><img src="public/images/icon_delete.png" alt=""></a>
            <img class="photo-pizza" src="<?= $pizza->get("p_ref_piecejointe_photo")->getObjet()->get_url() ?>" alt="">
            <div class="flex direction-column justify-between">
                <h2><?= $pizza->get("p_nom")->getValue() ?></h2>
                <p><?= $pizza->get("p_description")->getValue() ?></p>
                <div class="flex justify-center gap">
                    <a href="afficher_form_pizza.php?id=<?= $pizza->id() ?>&action=update">Modifier</a>
                    <?php if($pizza->get("p_statut")->getValue() === "T"){ ?>
                    <a href="finaliser_commande.php?id=<?= $pizza->id() ?>">Commander</a>
                    <?php } ?>
                </div>
            <div>
        </article>
    <?php
        }
    ?>
    </section>
</main>
