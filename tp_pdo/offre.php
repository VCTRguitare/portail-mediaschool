<?php
require_once('connexion.php');

if (session_status() == PHP_SESSION_NONE) { 
    session_start();
}

if (isset($_GET['id_offre'])) {
    $id_offre = $_GET['id_offre'];
    $sql = "SELECT offre.*, entreprise.nom as nom_entreprise FROM offre
    INNER JOIN entreprise ON entreprise.id_entreprise = offre.id_entreprise
    WHERE offre.id_offre = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_offre]);
    $offre = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$offre) {
        echo "Offre introuvable ou accès non autorisé.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offre</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
        require_once "users/" . $_SESSION['usertype'] . "/inc/header.php"
    ?>

    <div>
        <h1>Détails de l'offre</h1>
        <?php
        if (!isset($_GET['id_offre']) || empty($offre['id_offre'])) {
            echo "<p>Offre introuvable.</p>";
        }
        else {
            echo "<p><strong>" . htmlspecialchars($offre['nom']) . "</strong></p>";
            echo "<p>Type de contrat : " . htmlspecialchars($offre['type']) . "</p>";
            if ($offre['type'] !== "CDI") {
                echo "<p>Durée du contrat : " . htmlspecialchars($offre['duree']) . " ";
                if ($offre['unite_duree'] == 'M') {
                    echo "mois";
                }
                elseif ($offre['unite_duree'] === 'A' and $offre['duree'] === 1) {
                    echo "an";
                }
                else {
                    echo "ans";
                }
                echo "</p>";
            }
            echo "<p>Description : " . htmlspecialchars($offre['description']) . "</p>";
            echo "<p>Salaire mensuel : " . htmlspecialchars($offre['salaire']) . " €</p>";
            echo "<p>Postée le " . htmlspecialchars($offre['date_creation']) . " par " . htmlspecialchars($offre['nom_entreprise']) . "</p>";
        }
        ?>
    </div>
</body>
</html>