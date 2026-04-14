<?php
require '../../bdd/db.php';
try {
    $stmt = $pdo->prepare("SELECT * FROM Information");
    $stmt->execute();
    $infos = $stmt->fetchAll();
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erreur' => $e->getMessage()]);
}
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
</body>
</html>