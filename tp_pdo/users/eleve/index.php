<?php
require_once('../../connexion.php');

if (session_status() == PHP_SESSION_NONE) { 
    session_start();
}

if (empty($_SESSION['user']) || $_SESSION['usertype'] !== "eleve") {
    header("Location: ../../login.php"); exit();
}

$inscriptions = "SELECT inscription.*, formation.nom as nom_formation FROM inscription
LEFT JOIN formation ON inscription.id_formation = formation.id_formation
WHERE inscription.id_eleve = ? ORDER BY date_inscription DESC;";
$stmt = $pdo->prepare($inscriptions);
$stmt->execute([$_SESSION['user'][0]['id_eleve']]);
$resultat_inscription = $stmt->fetchAll(PDO::FETCH_ASSOC);

$candidatures = "SELECT candidature.*, offre.nom as nom_offre, entreprise.nom as nom_entreprise FROM candidature
INNER JOIN offre ON offre.id_offre = candidature.id_offre
INNER JOIN entreprise ON offre.id_entreprise = entreprise.id_entreprise
WHERE candidature.id_eleve = ? ORDER BY date_candidature DESC;";
$stmt = $pdo->prepare($candidatures);
$stmt->execute([$_SESSION['user'][0]['id_eleve']]);
$resultat_candidature = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon espace élève</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>

    <?php
        require_once "inc/header.php"
    ?>

    <h1>Mon espace élève</h1>
    <div>
        <?php
        echo "<div><h2>Mes inscriptions :</h2>";
        if (count($resultat_inscription) == 0) {
            echo "<p>Aucune inscription.</p>";
        }
        else {
            for ($i = 0; $i < 3; $i++) {
                if (!isset($resultat_inscription[$i])) break;
                echo "<p>" . $resultat_inscription[$i]['nom_formation'] . " - " . $resultat_inscription[$i]['etat'] . "</p><br>";
            }
        }
        echo "</div>";

        echo "<div><h2>Mes candidatures :</h2>";
        if (count($resultat_candidature) == 0) {
            echo "<p>Aucune candidature.</p>";
        }
        else {
            for ($i = 0; $i < 3; $i++) {
                if (!isset($resultat_candidature[$i])) break;
                echo "<p>" . $resultat_candidature[$i]['nom_offre'] . " chez " . $resultat_candidature[$i]['nom_entreprise'] . " - " . $resultat_candidature[$i]['etat'] . "</p><br>";
            }
        }
        echo "</div>"
        ?>
    </div>
    
</body>
</html>
