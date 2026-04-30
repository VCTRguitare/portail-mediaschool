<?php
require_once('../../connexion.php');

if (session_status() == PHP_SESSION_NONE) { 
    session_start();
}

if (empty($_SESSION['user']) || $_SESSION['usertype'] !== "personnel_mediaschool") {
    header("Location: ../../login.php"); exit();
}

if (isset($_GET['id_formation'])) {
    $id_formation = $_GET['id_formation'];
    $sql = "SELECT inscription.*, formation.nom as nom_formation, eleve.prenom, eleve.nom as nom_eleve, eleve.id_eleve as id_eleve FROM inscription
    INNER JOIN formation ON inscription.id_formation = formation.id_formation
    INNER JOIN eleve ON inscription.id_eleve = eleve.id_eleve
    WHERE inscription.id_personnel = ? AND inscription.id_formation = ?
    ORDER BY inscription.date_inscription DESC;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user'][0]['id_personnel'], $id_formation]);
    $inscription = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$inscription) {
        echo "formation introuvable ou accès non autorisé ou aucune inscription.";
        exit();
    }
}
else {
    $sql = "SELECT inscription.*, formation.nom as nom_formation, formation.id_formation, eleve.prenom, eleve.nom as nom_eleve, eleve.id_eleve as id_eleve FROM inscription
    INNER JOIN formation ON inscription.id_formation = formation.id_formation
    INNER JOIN eleve ON inscription.id_eleve = eleve.id_eleve
    WHERE inscription.id_personnel = ?
    ORDER BY inscription.id_formation ASC, inscription.date_inscription DESC;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user'][0]['id_personnel']]);
    $inscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$inscriptions) {
        echo "accès non autorisé ou aucune inscription.";
        exit();
    }
}

if (isset($_POST['valider'])) {
    $id_inscription = $_POST['id_inscription'];
    $sql = "UPDATE inscription SET etat = 'Acceptée' WHERE id_inscription = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_inscription]);
    header("Location: inscriptions.php"); exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi des inscriptions</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>

    <?php
    require_once "inc/header.php";
    echo "<h1>Suivi des inscriptions</h1>";
    if (isset($_GET['id_formation'])) {
        echo "<div><h2><a href='../../formation.php?id_formation=" . urlencode($_GET['id_formation']) . "'>" . $inscription[0]['nom_formation'] . "</a></h2>";
        foreach ($inscription as $inscript) {
            echo "<p><a href='candidat.php?id_candidat=" . urlencode($inscript['id_eleve']) . "'>" . $inscript['prenom'] . " " . $inscript['nom_eleve'] . "</a> s'est inscrit le " . $inscript['date_inscription'] . "</p>";
            echo "<p>Etat : " . $inscript['etat'] . "</p>";
            if ($inscript['etat'] === 'En attente') {
                echo "<form method='post'><input type='hidden' name='id_inscription' value='" . $inscript['id_inscription'] . "'>";
                echo "<button type='submit' name='valider'>Valider l'inscription</button></form>";
            }
        }
        echo "</div>";
    }
    else {
        $total = count($inscriptions);
        for ($i = 0; $i < $total; $i++) {
            if ($i-1 < 0) {
                echo "<div><h2><a href='inscriptions.php?id_formation=" . urlencode($inscriptions[$i]['id_formation']) . "'>" . $inscriptions[$i]['nom_formation'] . "</a></h2>";
                echo "<a href='../../formation.php?id_formation=" . urlencode($inscriptions[$i]['id_formation']) . "'>accéder aux détails de la formation</a>";
                echo "<p><a href='candidat.php?id_candidat=" . urlencode($inscriptions[$i]['id_eleve']) . "'>" . $inscriptions[$i]['prenom'] . " " . $inscriptions[$i]['nom_eleve'] . "</a> s'est inscrit le " . $inscriptions[$i]['date_inscription'] . "</p>";
                echo "<p>Etat : " . $inscriptions[$i]['etat'] . "</p>";
                if ($inscriptions[$i]['etat'] === 'En attente') {
                    echo "<form method='post'><input type='hidden' name='id_inscription' value='" . $inscriptions[$i]['id_inscription'] . "'>";
                    echo "<button type='submit' name='valider'>Valider l'inscription</button></form>";
                }
                if ($i+1 > $total) {
                    echo "</div>";
                }
                elseif ($inscriptions[$i]['nom_formation'] !== $inscriptions[$i+1]['nom_formation'] || !$inscriptions[$i+1]['nom_formation']) {
                    echo "</div>";
                }
            }
            elseif ($inscriptions[$i]['nom_formation'] !== $inscriptions[$i-1]['nom_formation']) {
                echo "<div><h2><a href='inscriptions.php?id_formation=" . urlencode($inscriptions[$i]['id_formation']) . "'>" . $inscriptions[$i]['nom_formation'] . "</a></h2>";
                echo "<a href='../../formation.php?id_formation=" . urlencode($inscriptions[$i]['id_formation']) . "'>accéder aux détails de la formation</a>";
                echo "<p><a href='candidat.php?id_candidat=" . urlencode($inscriptions[$i]['id_eleve']) . "'>" . $inscriptions[$i]['prenom'] . " " . $inscriptions[$i]['nom_eleve'] . "</a> s'est inscrit le " . $inscriptions[$i]['date_inscription'] . "</p>";
                echo "<p>Etat : " . $inscriptions[$i]['etat'] . "</p>";
                if ($inscriptions[$i]['etat'] === 'En attente') {
                    echo "<form method='post'><input type='hidden' name='id_inscription' value='" . $inscriptions[$i]['id_inscription'] . "'>";
                    echo "<button type='submit' name='valider'>Valider l'inscription</button></form>";
                }
                if ($i+1 >= $total) {
                    echo "</div>";
                }
                elseif ($inscriptions[$i]['nom_formation'] !== $inscriptions[$i+1]['nom_formation']) {
                    echo "</div>";
                }
            }
            else {
                echo "<p><a href='candidat.php?id_candidat=" . urlencode($inscriptions[$i]['id_eleve']) . "'>" . $inscriptions[$i]['prenom'] . " " . $inscriptions[$i]['nom_eleve'] . "</a> s'est inscrit le " . $inscriptions[$i]['date_inscription'] . "</p>";
                echo "<p>Etat : " . $inscriptions[$i]['etat'] . "</p>";
                if ($inscriptions[$i]['etat'] === 'En attente') {
                    echo "<form method='post'><input type='hidden' name='id_inscription' value='" . $inscriptions[$i]['id_inscription'] . "'>";
                    echo "<button type='submit' name='valider'>Valider l'inscription</button></form>";
                }
                if ($i+1 > $total) {
                    echo "</div>";
                }
                elseif ($inscriptions[$i]['nom_formation'] !== $inscriptions[$i+1]['nom_formation']) {
                    echo "</div>";
                }
            }
        }
    }
    ?>
    
</body>
</html>