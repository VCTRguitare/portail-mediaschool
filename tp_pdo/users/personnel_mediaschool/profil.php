<?php
require_once('../../connexion.php');

if (session_status() == PHP_SESSION_NONE) { 
    session_start();
}

if (empty($_SESSION['user']) || $_SESSION['usertype'] !== "personnel_mediaschool") {
    header("Location: ../../login.php"); exit();
}

$profil = "SELECT * FROM personnel_mediaschool WHERE id_personnel = ?;";
$stmt = $pdo->prepare($profil);
$stmt->execute([$_SESSION['user'][0]['id_personnel']]);
$personnel = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            if (count($personnel) == 0) {
                echo "<p>Aucune entreprise trouvée.</p>";
            }
            else {
                echo "<div><h2>" . htmlspecialchars($personnel[0]['civilite']) . " " . htmlspecialchars($personnel[0]['prenom']) . " " . htmlspecialchars($personnel[0]['nom']) . "</h2>";
                echo "<p>Email : " . htmlspecialchars($personnel[0]['email']) . "</p>";
                echo "<p>Numéro de téléphone : " . htmlspecialchars($personnel[0]['telephone']) . "</p>";
                echo "<p>Date de naissance : " . htmlspecialchars($personnel[0]['date_naissance']) . "</p>";
                echo "<p>Adresse : " . htmlspecialchars($personnel[0]['numero_rue']) . " " . htmlspecialchars($personnel[0]['rue']). " " . htmlspecialchars($personnel[0]['code_postal']) . " " . htmlspecialchars($personnel[0]['ville']) . "</p></div>";
            }
        ?>
    </div>
    
</body>
</html>