<?php
require '../utilisateurs/auth.php';
require '../../bdd/db.php';

$stmt = $pdo->prepare("SELECT * FROM Information");
$stmt->execute();
$infos = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Informations</title>
</head>
<body>
    <h1>Mes Informations</h1>
    <a href="creer_info.php">nouvelle information</a>
    <ul>
        <?php foreach ($infos as $info): ?>
        <li>
            <?= htmlspecialchars($info['titre']) ?>
            <a href="modifier_info.php?id=<?= $info['id'] ?>">Modifier</a>
            <a href="suppr_infos.php?id=<?= $info['id'] ?>">Supprimer</a>
        </li>
    <?php endforeach; ?>
    </ul>
    <footer><a href="/tvtest/admin/index.php">Retour au Menu</a></footer>
</body>
</html>