<?php
require '../bdd/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $token = htmlspecialchars(trim($_GET['token'] ?? ''));

    if (empty($token)) {
        die('Erreur : le token est obligatoire.');
    }

    $stmt = $pdo->prepare("SELECT * FROM Information AS i WHERE i.date_debut <= NOW() AND i.date_fin >= NOW() AND id IN (SELECT id_info FROM AffichageInfo WHERE id_tv = (SELECT id FROM TV WHERE token = :token))");
    $stmt->execute([
        ':token' => $token,
    ]);
    $rows = $stmt->fetchAll();

    header('Content-Type: application/json');
    echo json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}