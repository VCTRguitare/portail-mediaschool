<?php
require_once('../../connexion.php');

if (session_status() == PHP_SESSION_NONE) { 
    session_start();
}

if (empty($_SESSION['user']) || $_SESSION['usertype'] !== "eleve") {
    header("Location: ../../login.php"); exit();
}

$profil = "SELECT * FROM eleve WHERE id_eleve = ?;";
$stmt = $pdo->prepare($profil);
$stmt->execute([$_SESSION['user'][0]['id_eleve']]);
$eleve = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon profil</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>

    <?php
        require_once "inc/header.php";
    ?>

    <div>
        <h1>Mon profil</h1>
        <?php
            if (count($eleve) == 0) {
                echo "<p>Aucune eleve trouvée.</p>";
            }
            else {
                echo "<div><h2>" . htmlspecialchars($eleve[0]['civilite']) . " " . htmlspecialchars($eleve[0]['prenom']) . " " . htmlspecialchars($eleve[0]['nom']) . "</h2>";
                echo "<p>Email : " . htmlspecialchars($eleve[0]['email']) . "</p>";
                echo "<p>Numéro de téléphone : " . htmlspecialchars($eleve[0]['telephone']) . "</p>";
                echo "<p>Date de naissance : " . htmlspecialchars($eleve[0]['date_naissance']) . "</p>";
                echo "<p>Adresse : " . htmlspecialchars($eleve[0]['numero_rue']) . " " . htmlspecialchars($eleve[0]['rue']). " " . htmlspecialchars($eleve[0]['code_postal']) . " " . htmlspecialchars($eleve[0]['ville']) . "</p></div>";
            }
        ?>
    </div>
    
</body>
</html>