<?php
require 'auth.php';
require '../../bdd/db.php';

$stmt = $pdo->prepare("SELECT u.id, superadmin, username, u.id_etablissement, nom AS etablissement FROM Utilisateurs AS u JOIN Etablissement AS e ON u.id_etablissement = e.id WHERE u.id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$_SESSION['user_id'] = $user['id'];
$_SESSION['superadmin'] = $user['superadmin'];
$_SESSION["username"] = $user["username"];
$_SESSION["id_etablissement"] = $user["id_etablissement"];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte - <?= htmlspecialchars($user["username"]) ?></title>
</head>
<body>
    <h1>Mon Compte - <?= htmlspecialchars($user["username"]) ?></h1>
    <p>Vous êtes <?= $user['superadmin'] === 1 ? "Superadmin" : "Admin" ?>.</p>
    <p>Votre établissement : <?= htmlspecialchars($user["etablissement"]) ?></p>

    <a href="modifier_mdp.php?id=<?= $user["id"] ?>">Modifier votre mot de passe.</a>
    <footer><a href="/tvtest/admin/index.php">Retour au Menu</a></footer>
</body>
</html>