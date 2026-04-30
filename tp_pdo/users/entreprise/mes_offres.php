<?php
require_once('../../connexion.php');

if (session_status() == PHP_SESSION_NONE) { 
    session_start();
}

if (empty($_SESSION['user']) || $_SESSION['usertype'] !== "entreprise") {
    header("Location: ../../login.php"); exit();
}

$offres = "SELECT offre.*, COUNT(candidature.id_candidature) AS nb_candidatures FROM offre
LEFT JOIN candidature
ON candidature.id_offre = offre.id_offre
WHERE offre.id_entreprise = ?
GROUP BY offre.id_offre;";
$stmt = $pdo->prepare($offres);
$stmt->execute([$_SESSION['user'][0]['id_entreprise']]);
$resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Mes offres</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>

    <?php
        require_once "inc/header.php";
    ?>

    <div>
        <h1>Mes offres</h1>
        <?php
            if (count($resultat) == 0) {
                echo "<p>Aucune offre publiée.</p>";
            }
            else {
                foreach ($resultat as $offre) {;
                    echo "<div><a href='offre.php?id_offre=" . urlencode($offre['id_offre']) . "'>" . htmlspecialchars($offre['nom']) . "</a> - <a href='suivi_candidatures.php?id_offre=" . urlencode($offre['id_offre']) . "'>" . $offre['nb_candidatures'] . " candidatures</a></p><br>";
                    if ($offre['nb_candidatures'] == 0) {
                        echo "<form method='post'>
                        <input type='hidden' name='id_offre' value='" . htmlspecialchars($offre['id_offre']) . "'>
                        <button type='submit' name='delete'>Supprimer l'offre</button>
                        </form>";
                    }
                    echo "</div>";
                }
            }
        ?>
    </div>
    
</body>
</html>