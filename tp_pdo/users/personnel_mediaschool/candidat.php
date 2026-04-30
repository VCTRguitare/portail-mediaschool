<?php
require_once('../../connexion.php');

if (session_status() == PHP_SESSION_NONE) { 
    session_start();
}

if (empty($_SESSION['user']) || $_SESSION['usertype'] !== "personnel_mediaschool") {
    header("Location: ../../login.php"); exit();
}

if (isset($_GET['id_candidat'])) {
    $id_candidat = $_GET['id_candidat'];
    $sql = "SELECT eleve.id_eleve, eleve.nom, eleve.prenom, TIMESTAMPDIFF(YEAR, eleve.date_naissance, CURDATE()) AS age, eleve.diplome, inscription.id_formation, formation.nom as nom_formation FROM eleve
    LEFT JOIN inscription ON eleve.id_eleve = inscription.id_eleve
    INNER JOIN formation ON inscription.id_formation = formation.id_formation
    INNER JOIN personnel_mediaschool ON inscription.id_personnel = personnel_mediaschool.id_personnel
    WHERE personnel_mediaschool.id_personnel = ? AND eleve.id_eleve = ?
    GROUP BY inscription.id_formation
    ORDER BY inscription.id_formation ASC;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user'][0]['id_personnel'], $id_candidat]);
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
            echo "<p><a href='../../formation.php?id_formation=" . urlencode($candid['id_formation']) . "'>" . htmlspecialchars($candid['nom_formation']) . "</a></p>";
        }
    }
    ?>
    
</body>
</html>