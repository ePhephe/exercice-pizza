<header>
    <!-- Affichage du logo -->
    <img src="" alt="">

    <!-- Menu de navigation principale -->
    <nav>
        <ul>
            <li><a href="">Créer une nouvelle pizza</a></li>
            <li><a href="">Mes pizzas</a></li>
        </ul>
    </nav>

    <!-- Menu lié au compte -->
    <nav>
        <ul>
            <li><a href="afficher_form_utilisateur.php?id=<?= _session::getSession()->id() ?>&action=update">Compte</a></li>
            <li><a href="se_deconnecter.php">Déconnexion</a></li>
        </ul>
    </nav>
</header>