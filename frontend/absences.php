<?php
require '../bdd/db.php';
require 'script.php';
    
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $token = htmlspecialchars(trim($_GET['token'] ?? ''));
    $id_etab = obtenir_id_etablissement($pdo, $token);

    // On cherche les absences
    $stmt = $pdo->prepare("SELECT professeur, matiere, date_debut, date_fin, champ_libre FROM Absence WHERE date_fin >= NOW() AND id_etablissement = ? ORDER BY date_debut");
    $stmt->execute([$id_etab]);
    $rows = $stmt->fetchAll();

    header('Content-Type: application/json');
    echo json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}