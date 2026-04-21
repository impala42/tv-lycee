<?php
require 'auth.php';
require '../../bdd/db.php';

$stmt = $pdo->prepare("SELECT * FROM Utilisateurs WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$_SESSION['user_id'] = $user['id'];
$_SESSION['superadmin'] = $user['superadmin'];
$_SESSION["username"] = $user["username"];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte - <?= $user["username"] ?></title>
</head>
<body>
    <h1>Mon Compte - <?= $user["username"] ?></h1>
    <p>Vous êtes <?= $user['superadmin'] === 1 ? "Superadmin" : "Admin" ?>.</p>

    <a href="modifier_mdp.php?id=<?= $user["id"] ?>">Modifier votre mot de passe.</a>
</body>
</html>