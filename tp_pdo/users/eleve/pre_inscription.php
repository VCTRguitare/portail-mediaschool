<?php
require_once('../../connexion.php');

if (session_status() == PHP_SESSION_NONE) { 
    session_start();
}
    
if (empty($_SESSION['user']) || $_SESSION['usertype'] !== "eleve") {
    header("Location: ../../login.php"); exit();
}

if (isset($_GET['id_inscription'])) {
    $id_inscription = $_GET['id_inscription'];
    $sql = "SELECT inscription.etat, inscription.date_inscription, formation.nom as nom_formation, formation.id_formation FROM inscription
    INNER JOIN formation ON inscription.id_formation = formation.id_formation
    WHERE inscription.id_inscription = ? AND inscription.id_eleve = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_inscription, $_SESSION['user'][0]['id_eleve']]);
    $inscription = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$inscription) {
        echo "Candidature introuvable ou accès non autorisé.";
        exit();
    }
}
else {
    $sql = "SELECT inscription.etat, inscription.date_inscription, formation.nom as nom_formation, formation.id_formation FROM inscription
    INNER JOIN formation ON inscription.id_formation = formation.id_formation
    WHERE inscription.id_eleve = ?
    ORDER BY inscription.date_inscription DESC;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user'][0]['id_eleve']]);
    $inscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi des inscriptions</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>

    <?php
        require_once "inc/header.php";
    ?>

    <div>
        <h1>Suivi des inscriptions</h1>
        <?php
        if (isset($_GET['id_inscription'])) {
            if (!$inscription) {
                echo "<p>Inscription introuvable ou accès non autorisé.</p>";
            }
            else {
                echo "<div>";
                echo "<h3><a href='../../formation.php?id_formation=" . urlencode($inscription['id_formation']) . "'>" . htmlspecialchars($candidature['nom_formation']) . "</a></h3>";
                echo "<p>Vous avez postulé le : " . htmlspecialchars($inscript['date_inscription']) . "</p>";
                echo "<p>Etat : " . htmlspecialchars($inscript['etat']) . "</p>";
                echo "</div>";
            }
        }
        else {
            if (count($inscriptions) == 0) {
                echo "<p>Vous n'avez pas de candidatures en cours.</p>";
            }
            else {
                echo "<p><strong>Vous avez postulé aux offres suivantes :</strong></p>";
                foreach ($inscriptions as $inscript) {
                    echo "<div>";
                    echo "<h3><a href='../../formation.php?id_formation=" . urlencode($inscript['id_formation']) . "'>" . htmlspecialchars($inscript['nom_formation']) . "</a></h3>";
                    echo "<p>Vous avez postulé le : " . htmlspecialchars($inscript['date_inscription']) . "</p>";
                    echo "<p>Etat : " . htmlspecialchars($inscript['etat']) . "</p>";
                    echo "</div>";
                }
            }
        }
        ?>
    </div>
    
</body>
</html>