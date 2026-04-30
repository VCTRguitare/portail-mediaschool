<?php
require_once('../../connexion.php');

if (session_status() == PHP_SESSION_NONE) { 
    session_start();
}
    
if (empty($_SESSION['user']) || $_SESSION['usertype'] !== "entreprise") {
    header("Location: ../../login.php"); exit();
}

if (isset($_GET['id_offre'])) {
    $id_offre = $_GET['id_offre'];
    $sql = "SELECT offre.nom as nom_offre, offre.id_offre, eleve.id_eleve, eleve.nom as nom_eleve, eleve.prenom as prenom_eleve FROM offre
    LEFT JOIN candidature ON offre.id_offre = candidature.id_offre
    LEFT JOIN eleve ON candidature.id_eleve = eleve.id_eleve
    WHERE offre.id_offre = ? AND offre.id_entreprise = ?
    ORDER BY offre.id_offre ASC;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_offre, $_SESSION['user'][0]['id_entreprise']]);
    $offre = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$offre) {
        echo "Offre introuvable ou accès non autorisé.";
        exit();
    }
}
else {
    $sql = "SELECT offre.nom as nom_offre, offre.id_offre, eleve.id_eleve, eleve.nom as nom_eleve, eleve.prenom as prenom_eleve FROM offre
    LEFT JOIN candidature ON offre.id_offre = candidature.id_offre
    LEFT JOIN eleve ON candidature.id_eleve = eleve.id_eleve
    WHERE offre.id_entreprise = ?
    GROUP BY eleve.id_eleve
    ORDER BY offre.id_offre ASC;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user'][0]['id_entreprise']]);
    $offres = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        echo "<div>";
        if (isset($_GET['id_offre'])) {
            if (!$offre) {
                echo "<p>Offre introuvable ou accès non autorisé.</p>";
            }
            else {
                if (!isset($offre[0]['id_eleve'])) {
                    echo "<p>Aucun candidat n'a postulé à cette <a href='offre.php?id_offre=" . urlencode($offre[0]['id_offre']) . "'>offre</a>.</p>";
                }
                else {
                    echo "<p><strong>Les candidats suivants ont postulé à l'offre <a href='offre.php?id_offre=" . urlencode($offre[0]['id_offre']) . "'>" . htmlspecialchars($offre[0]['nom_offre']) . "</a>.</strong></p>";
                    foreach ($offre as $offr) {
                        echo "<p><a href='candidat.php?id_candidat=" . urlencode($offr['id_eleve']) . "'>" . htmlspecialchars($offr['prenom_eleve']) . " " . htmlspecialchars($offr['nom_eleve']) . "</a></p>";
                    }
                }
            }
        }
        else {
            if (count($offres) == 0) {
                echo "<p>Vous n'avez pas d'offres en cours.</p>";
            }
            else {
                echo "<p><strong>Les candidats suivants ont postulé à une offre :</strong></p>";
                foreach ($offres as $offrs) {
                    if (isset($offrs['prenom_eleve'])) {
                        echo "<p><a href='candidat.php?id_candidat=" . urlencode($offrs['id_eleve']) . "'>" . htmlspecialchars($offrs['prenom_eleve']) . " " . htmlspecialchars($offrs['nom_eleve']) . "</a></p>";
                    }
                }
            }
        }
        echo "</div>"
        ?>
    </div>
    
</body>
</html>