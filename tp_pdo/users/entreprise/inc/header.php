<header>
    <a href="index.php"><img src="/tp_pdo/images/MSG_logo.png" alt="logo"></a>
    <ul>
        <li><a href="/tp_pdo/users/entreprise/index.php">Tableau de bord</a></li>
        <li><a href="/tp_pdo/users/entreprise/mes_offres.php">Mes offres</a></li>
        <li><a href="/tp_pdo/users/entreprise/suivi_candidatures.php">Suivi des candidatures</a></li>
    </ul>
    <div>
        <a href="/tp_pdo/users/entreprise/profil.php"><?php echo $_SESSION['user'][0]['nom']; ?></a>
        <a href="/tp_pdo/logout.php">Déconnexion</a>
    </div>
</header>