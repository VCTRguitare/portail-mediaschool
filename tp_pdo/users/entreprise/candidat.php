<?php
require_once('../../connexion.php');

if (session_status() == PHP_SESSION_NONE) { 
    session_start();
}

if (empty($_SESSION['user']) || $_SESSION['usertype'] !== "entreprise") {
    header("Location: ../../login.php"); exit();
}

if (isset($_GET['id_candidat'])) {
    $id_candidat = $_GET['id_candidat'];
    $sql = "SELECT eleve.id_eleve, eleve.nom, eleve.prenom, TIMESTAMPDIFF(YEAR, eleve.date_naissance, CURDATE()) AS age, eleve.diplome, candidature.id_offre, offre.nom as offre_nom FROM eleve
    LEFT JOIN candidature ON eleve.id_eleve = candidature.id_eleve
    INNER JOIN offre ON candidature.id_offre = offre.id_offre
    INNER JOIN entreprise ON offre.id_entreprise = entreprise.id_entreprise
    WHERE entreprise.id_entreprise = ? AND eleve.id_eleve = ?
    GROUP BY candidature.id_offre
    ORDER BY candidature.id_offre ASC;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user'][0]['id_entreprise'], $id_candidat]);
    $candidat = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$candidat) {
        echo "Candidat introuvable ou accès non autorisé.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil du candidat</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>

    <?php
    if (!isset($_GET['id_candidat']) || empty($candidat[0]['id_eleve'])) {
        echo "<p>Candidat introuvable ou accès non autorisé.</p>";
        header("Location: index.php"); exit();
    }

    else {
        require_once "inc/header.php";
        if (!$candidat) {
            echo "<p>Candidat introuvable ou accès non autorisé.</p>";
        }
        echo "<div><h1>Fiche candidat</h1>";        
        echo "<p>Nom : " . htmlspecialchars($candidat[0]['nom']) . " " . htmlspecialchars($candidat[0]['prenom']) . "</p>";
        echo "<p>Age : " . htmlspecialchars($candidat[0]['age']) . " ans</p>";
        echo "<p>Diplôme : " . htmlspecialchars($candidat[0]['diplome']) . "</p>";
        echo "<p>Nombre de candidatures : " . count($candidat) . "</p></div>";
        foreach ($candidat as $candid) {
            echo "<p><a href='offre.php?id_offre=" . urlencode($candid['id_offre']) . "'>" . htmlspecialchars($candid['offre_nom']) . "</a></p>";
        }
    }
    ?>
    
</body>
</html>