<?php
require_once('connexion.php');

if (session_status() == PHP_SESSION_NONE) { 
    session_start();
}

if (isset($_GET['id_formation'])) {
    $id_formation = $_GET['id_formation'];
    $sql = "SELECT formation.*, campus.ville FROM formation
    LEFT JOIN campus ON campus.id_campus = formation.id_campus
    WHERE formation.id_formation = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_formation]);
    $formation = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$formation) {
        echo "Formation introuvable ou accès non autorisé.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formation</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
        require_once "users/" . $_SESSION['usertype'] . "/inc/header.php"
    ?>

    <div>
        <h1>Détails de la formation</h1>
        <?php
        if (!isset($_GET['id_formation']) || empty($formation['id_formation'])) {
            echo "<p>Formation introuvable ou accès non autorisé.</p>";
        }
        else {
            echo "<p><strong>" . htmlspecialchars($formation['nom']) . "</strong></p>";
            echo "<p>Durée de la formation : " . htmlspecialchars($formation['duree']) . "</p>";
            echo "<p>Coût de la formation : " . htmlspecialchars($formation['prix']) . "</p>";
            echo "<p>Lieu de la formation : " . htmlspecialchars($formation['ville']) . "</p>";
        }
        ?>
    </div>
</body>
</html>