<?php
require 'auth.php';
require '../../bdd/db.php';

$stmt = $pdo->prepare("SELECT username, superadmin FROM Utilisateurs");
$stmt->execute();
$utilisateurs = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Utilisateurs</title>
</head>
<body>
    <h1>Utilisateurs</h1>
    <a href="nouveau.php">Nouvel utilisateur</a>
    <ul>
        <?php foreach ($utilisateurs as $utilisateur): ?>
        <li>
            <?= htmlspecialchars($utilisateur['username']) ?> - grade : <?= htmlspecialchars($utilisateur['superadmin']) ?>
        </li>
    <?php endforeach; ?>
    </ul>
</body>
</html>