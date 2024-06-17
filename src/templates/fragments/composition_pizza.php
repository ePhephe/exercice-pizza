<?php

/**
 * Fragment qui gère l'affichage de la composition d'une pizza
 * 
 */

?>

<table>
    <tbody>
        <?php foreach ($parametres["arrayCompositionPizza"] as $key => $composition) { ?>
            <tr>
                <td><div><img src="<?= $composition->get("c_ref_ingredient")->getObjet()->get("i_ref_piecejointe_photo")->getObjet()->get_url() ?>" alt=""><div></td>
                <td><?= $composition->get("c_ref_ingredient")->getObjet()->get("i_type")->getListLibelle() ?></td>
                <td><?= $composition->get("c_ref_ingredient")->getObjet()->get("i_nom")->getValue() ?></td>
                <td class="dosage"><?= $composition->get("c_dosage_ingredient")->getListLibelle() ?></td>
                <td><?= $composition->get("c_prix_ingredient_pizza")->getValue() ?> €</td>
            </tr>

        <?php }  ?>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><?= $parametres["prixPizza"] ?> €</td>
        </tr>
    </tbody>
</table>

