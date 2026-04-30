<?php
require_once('../../connexion.php');

if (session_status() == PHP_SESSION_NONE) { 
    session_start();
}

if (empty($_SESSION['user']) || $_SESSION['usertype'] !== "entreprise") {
    header("Location: ../../login.php"); exit();
}

$profil = "SELECT * FROM entreprise WHERE id_entreprise = ?;";
$stmt = $pdo->prepare($profil);
$stmt->execute([$_SESSION['user'][0]['id_entreprise']]);
$entreprise = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de l'entreprise</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>

    <?php
        require_once "inc/header.php";
    ?>

    <div>
        <h1>Profil de l'entreprise</h1>
        <?php
            if (count($entreprise) == 0) {
                echo "<p>Aucune entreprise trouvée.</p>";
            }
            else {
                echo "<div><h2>" . htmlspecialchars($entreprise[0]['nom']) . "</h2>";
                echo "<p>Siret : " . htmlspecialchars($entreprise[0]['siret']) . "</p>";
                echo "<p>Email : " . htmlspecialchars($entreprise[0]['email']) . "</p>";
                echo "<p>Numéro de téléphone : " . htmlspecialchars($entreprise[0]['telephone']) . "</p>";
                echo "<p>Secteur d'activité : " . htmlspecialchars($entreprise[0]['secteur_activite']) . "</p>";
                echo "<p>Adresse : " . htmlspecialchars($entreprise[0]['numero_rue']) . " " . htmlspecialchars($entreprise[0]['rue']). " " . htmlspecialchars($entreprise[0]['code_postal']) . " " . htmlspecialchars($entreprise[0]['ville']) . "</p></div>";
            }
        ?>
    </div>
    
</body>
</html>