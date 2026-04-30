<?php
require_once('connexion.php');

$mail = "";
$usertype = "";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['usertype'])) {
    
    $mail = $_POST['mail'];
    $mdp = $_POST['password'];
    $target_table = $_POST['usertype'];
    
    $sql = "SELECT * FROM $target_table WHERE email = ? AND mdp = ?";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([$mail, md5($mdp)]);
    $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $nb = count($resultat);

    $sql_user = "SELECT * FROM $target_table WHERE email = ?";
    $stmt = $pdo->prepare($sql_user);
    $stmt->execute([$mail]);
    $_users_info = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['user'] = $_users_info;

    if ($nb == 1) {
        switch ($_POST['usertype']) {
            case "eleve":
                $_SESSION['usertype'] = "eleve";
                header("Location: users/eleve/index.php");
                exit();
                break;
            case "entreprise":
                $_SESSION['usertype'] = "entreprise";
                header("Location: users/entreprise/index.php");
                exit();
                break;
            case "personnel_mediaschool":
                $_SESSION['usertype'] = "personnel_mediaschool";
                header("Location: users/personnel_mediaschool/index.php"); 
                exit();
                break;
        }
    }
    else {
        echo "Échec de la connexion.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    
    <div class="login-container">
        <img src="tabler_lock-filled.svg" alt="cadenas">
        <form method="POST">
            <input type="email" id="mail" name="mail" placeholder="Login" value="<?php echo $mail?>" required>

            <input type="password" id="password" name="password" placeholder="Mot de passe" required>

            <select id="usertype" name="usertype" placeholder="Type" value="<?php echo $usertype?>" required>
                <option value="eleve">Elève</option>
                <option value="entreprise">Entreprise</option>
                <option value="personnel_mediaschool">Personnel</option>
            </select>

            <button type="submit">Connexion</button>
            <a href="">Mot de passe oublié ?</a>
        </form>
    </div>

</body>

</html>