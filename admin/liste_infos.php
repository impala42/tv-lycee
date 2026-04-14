<?php
require '../bdd/db.php';
try {
    $stmt = $pdo->prepare("SELECT * FROM Information WHERE date_debut <= NOW() AND date_fin >= NOW();");
    $stmt->execute();
    $infos = $stmt->fetchAll();
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erreur' => $e->getMessage()]);
}
?>

<h1>Mes Informations</h1>
<ul>
    <?php foreach ($infos as $info): ?>
        <li>
            <?= htmlspecialchars($info['titre']) ?>
            <a href="modifier_info.php?id=<?= $info['id'] ?>">Modifier</a>
        </li>
    <?php endforeach; ?>
</ul>