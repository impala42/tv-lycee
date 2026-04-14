<?php
require '../bdd/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $token = htmlspecialchars(trim($_GET['token'] ?? ''));

    if (empty($token)) {
        die('Erreur : le token est obligatoire.');
    }

    $stmt = $pdo->prepare("SELECT * FROM Information AS i JOIN AffichageInfo AS a ON i.id = a.id_info JOIN TV AS t ON t.id = a.id_tv WHERE i.date_debut <= NOW() AND i.date_fin >= NOW() AND t.token = :token");
    $stmt->execute([
        ':token' => $token,
    ]);
    $rows = $stmt->fetchAll();

    header('Content-Type: application/json');
    echo json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}