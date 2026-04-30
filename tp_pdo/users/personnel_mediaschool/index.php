<?php
require_once('../../connexion.php');

if (session_status() == PHP_SESSION_NONE) { 
    session_start();
}

if (empty($_SESSION['user']) || $_SESSION['usertype'] !== "personnel_mediaschool") {
    header("Location: ../../login.php"); exit();
}

$inscriptions = "SELECT formation.*, COUNT(inscription.id_inscription) AS nb_inscriptions FROM formation
LEFT JOIN inscription ON inscription.id_formation = formation.id_formation
WHERE inscription.id_personnel = ? GROUP BY formation.id_formation ORDER BY nb_inscriptions DESC;";
$stmt = $pdo->prepare($inscriptions);
$stmt->execute([$_SESSION['user'][0]['id_personnel']]);
$resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon espace personnel</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>
    
    <?php
        require_once "inc/header.php";
        echo "<h1>Mon espace personnel</h1>";
        echo "<div>";
        echo "<h2>Mes inscriptions à valider</h2>";
        if (count($resultat) == 0) {
            echo "<p>Aucune offre publiée.</p>";
        }
        else {
            for ($i = 0; $i < 3; $i++) {
                if (!isset($resultat[$i])) break;
                echo "<a href='inscriptions.php?id_formation=" . urlencode($resultat[$i]['id_formation']) . "'>" . $resultat[$i]['nom'] . " - " . $resultat[$i]['nb_inscriptions'] . ($resultat[$i]['nb_inscriptions'] > 1 ? " inscriptions" : " inscription") . "</a><br>";
            }
        }
        echo "</div>";
    ?>
    
</body>
</html>