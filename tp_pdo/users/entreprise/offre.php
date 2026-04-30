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
    $sql = "SELECT offre.*, COUNT(candidature.id_candidature) AS nb_candidatures FROM offre
    LEFT JOIN candidature ON offre.id_offre = candidature.id_offre
    WHERE offre.id_offre = ? AND offre.id_entreprise = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_offre, $_SESSION['user'][0]['id_entreprise']]);
    $offre = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$offre) {
        echo "Offre introuvable ou accès non autorisé.";
        exit();
    }
}

if (isset($_POST['delete'])) {
    $id_offre = $_POST['id_offre'];
    $sql = "DELETE FROM offre WHERE id_offre = ? AND id_entreprise = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_offre, $_SESSION['user'][0]['id_entreprise']]);
    header("Location: mes_offres.php"); exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offre</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>
    <?php
        require_once "inc/header.php"
    ?>

    <div>
        <h1>Détails de l'offre</h1>
        <?php
        if (!isset($_GET['id_offre']) || empty($offre['id_offre'])) {
            echo "<p>Offre introuvable ou accès non autorisé.</p>";
        }
        else {
            echo "<p><strong>Nom :</strong> " . htmlspecialchars($offre['nom']) . "</p>";
            echo "<p><strong>Description :</strong> " . htmlspecialchars($offre['description']) . "</p>";
            echo "<p><strong><a href='suivi_candidatures.php?id_offre=" . urlencode($offre['id_offre']) . "'>Nombre de candidatures</a> :</strong> " . htmlspecialchars($offre['nb_candidatures']) . "</p>";
            if ($offre['nb_candidatures'] == 0) {
                echo "<form method='post'>
                <input type='hidden' name='id_offre' value='" . htmlspecialchars($offre['id_offre']) . "'>
                <button type='submit' name='delete'>Supprimer l'offre</button>
                </form>";
            }
            echo "<p><strong><a href='mes_offres.php'>Retour à la liste des offres</a></strong></p>";
        }
        ?>
    </div>
</body>
</html>