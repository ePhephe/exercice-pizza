<header class="flex align-center justify-between">
    <div class="flex align-center justify-between gap">
        <!-- Affichage du logo -->
        <div class="logo">
            <img src="public/images/logo.png" alt="Logo de l'application Pizz'Artist">
        </div>

        <!-- Menu de navigation principale -->
        <nav class="menu">
            <ul class="large-12-12 flex align-center justify-between gap">
                <li><a href="afficher_form_pizza.php?action=create">Créer une nouvelle pizza</a></li>
                <li><a href="lister_pizzas.php">Mes pizzas</a></li>
            </ul>
        </nav>
    </div>

    <!-- Menu lié au compte -->
    <nav class="compte">
        <ul class="large-12-12 flex align-center gap">
            <li><a href="afficher_form_utilisateur.php?id=<?= _session::getSession()->id() ?>&action=update">Mon Compte</a></li>
            <li><a href="se_deconnecter.php">Déconnexion</a></li>
            <li><div class="photo_profil"><img src="<?= $session->userConnected()->get("u_ref_piecejointe_photo")->getObjet()->get_url() ?>" alt="Photo de profil"></div></li>
        </ul>
    </nav>
</header>
<div class="header_height">

</div>