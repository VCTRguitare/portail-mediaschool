<?php
require_once('../../connexion.php');

if (session_status() == PHP_SESSION_NONE) { 
    session_start();
}

if (empty($_SESSION['user']) || $_SESSION['usertype'] !== "entreprise") {
    header("Location: ../../login.php"); exit();
}

$offres = "SELECT offre.*, COUNT(candidature.id_candidature) AS nb_candidatures FROM offre LEFT JOIN candidature
ON candidature.id_offre = offre.id_offre WHERE offre.id_entreprise = ? GROUP BY offre.id_offre ORDER BY nb_candidatures DESC;";
$stmt = $pdo->prepare($offres);
$stmt->execute([$_SESSION['user'][0]['id_entreprise']]);
$resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon espace entreprise</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>

    <?php
        require_once "inc/header.php";
    ?>

    <div>
        <h1>Mon espace entreprise</h1>
        <?php
            echo "<div>";
            echo "<h2>Mes offres</h2>";
            if (count($resultat) == 0) {
                echo "<p>Aucune offre publiée.</p>";
            }
            else {
                for ($i = 0; $i < 3; $i++) {
                    if (!isset($resultat[$i])) break;
                    echo "<a href='offre.php?id_offre=" . urlencode($resultat[$i]['id_offre']) . "'>" . $resultat[$i]['nom'] . " - " . $resultat[$i]['nb_candidatures'] . ($resultat[$i]['nb_candidatures'] > 1 ? " candidatures" : " candidature") . "</a><br>";
                }
            }
            echo "</div>";
        ?>
    </div>
    
</body>
</html>