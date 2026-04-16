<?php
require '../../bdd/db.php';

$stmt = $pdo->prepare("SELECT * FROM TV");
$stmt->execute();
$infos = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - TV</title>
</head>
<body>
    <h1>Mes TV</h1>
    <ul>
    <?php foreach ($infos as $info): ?>
        <li>
            <a target="_blank" href="../../frontend/index.html?token=<?= htmlspecialchars($info['token']) ?>"><?= htmlspecialchars($info['nom']) ?></a>
        </li>
    <?php endforeach; ?>
    </ul>

    <h2>Créer une nouvelle TV</h2>
    <form action="traitement_creer_tv.php" method="POST">

        <label for="nom">Nom : </label>
        <input type="text" id="nom" name="nom" required>

        <button type="submit">Créer</button>
    </form>
    <footer><a href="/tvtest/admin/index.php">Retour au Menu</a></footer>
</body>
</html>