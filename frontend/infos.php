<?php
require '../../bdd/db.php';
header('Content-Type: application/json');

try {
    // Requête sur la table souhaitée
    $stmt = $pdo->prepare("SELECT * FROM Information WHERE date_debut <= NOW() AND date_fin >= NOW();");
    $stmt->execute();
    $rows = $stmt->fetchAll();

    echo json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erreur' => $e->getMessage()]);
}