<?php
require_once('../../connexion.php');

if (session_status() == PHP_SESSION_NONE) { 
    session_start();
}
    
if (empty($_SESSION['user']) || $_SESSION['usertype'] !== "eleve") {
    header("Location: ../../login.php"); exit();
}

if (isset($_GET['id_candidature'])) {
    $id_candidature = $_GET['id_candidature'];
    $sql = "SELECT candidature.etat, candidature.date_candidature, offre.nom as nom_offre, offre.id_offre, entreprise.nom as nom_entreprise FROM candidature
    INNER JOIN offre ON offre.id_offre = candidature.id_offre
    INNER JOIN entreprise ON offre.id_entreprise = entreprise.id_entreprise
    WHERE candidature.id_candidature = ? AND candidature.id_eleve = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_candidature, $_SESSION['user'][0]['id_eleve']]);
    $candidature = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$candidature) {
        echo "Candidature introuvable ou accès non autorisé.";
        exit();
    }
}
else {
    $sql = "SELECT candidature.etat, candidature.date_candidature, offre.nom as nom_offre, offre.id_offre, entreprise.nom as nom_entreprise FROM candidature
    INNER JOIN offre ON offre.id_offre = candidature.id_offre
    INNER JOIN entreprise ON offre.id_entreprise = entreprise.id_entreprise
    WHERE candidature.id_eleve = ?
    ORDER BY candidature.date_candidature DESC;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user'][0]['id_eleve']]);
    $candidatures = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi des candidatures</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>

    <?php
        require_once "inc/header.php";
    ?>

    <div>
        <h1>Suivi des candidatures</h1>
        <?php
        if (isset($_GET['id_candidature'])) {
            if (!$candidature) {
                echo "<p>Candidature introuvable ou accès non autorisé.</p>";
            }
            else {
                echo "<div>";
                echo "<h3><a href='../../offre.php?id_offre=" . urlencode($candidature['id_offre']) . "'>" . htmlspecialchars($candidature['nom_offre']) . "</a></h3>";
                echo "<p>" . htmlspecialchars($candidature['nom_entreprise']) . "</p>";
                echo "</div>";
            }
        }
        else {
            if (count($candidatures) == 0) {
                echo "<p>Vous n'avez pas de candidatures en cours.</p>";
            }
            else {
                echo "<p><strong>Vous avez postulé aux offres suivantes :</strong></p>";
                foreach ($candidatures as $candidatur) {
                    echo "<div>";
                    echo "<h3><a href='../../offre.php?id_offre=" . urlencode($candidatur['id_offre']) . "'>" . htmlspecialchars($candidatur['nom_offre']) . "</a></h3>";
                    echo "<p>Posté par : " . htmlspecialchars($candidatur['nom_entreprise']) . "</p>";
                    echo "<p>Vous avez postulé le : " . htmlspecialchars($candidatur['date_candidature']) . "</p>";
                    echo "<p>Etat : " . htmlspecialchars($candidatur['etat']) . "</p>";
                    echo "</div>";
                }
            }
        }
        ?>
    </div>
    
</body>
</html>