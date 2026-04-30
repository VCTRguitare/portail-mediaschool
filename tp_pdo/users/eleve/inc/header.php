<header>
    <a href="index.php"><img src="/tp_pdo/images/MSG_logo.png" alt="logo"></a>
    <ul>
        <li><a href="/tp_pdo/users/eleve/index.php">Tableau de bord</a></li>
        <li><a href="/tp_pdo/users/eleve/pre_inscription">Pré-inscription</a></li>
        <li><a href="/tp_pdo/users/eleve/candidatures">Candidatures</a></li>
    </ul>
    <div>
        <a href="/tp_pdo/users/eleve/profil.php"><span><?php echo $_SESSION['user'][0]['prenom'] . " " . $_SESSION['user'][0]['nom']; ?></span></a>
        <a href="/tp_pdo/logout.php">Déconnexion</a>
    </div>
</header>