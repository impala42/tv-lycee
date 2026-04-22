<?php
require '../bdd/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $token = htmlspecialchars(trim($_GET['token'] ?? ''));

    if (empty($token)) {
        die('Erreur : le token est obligatoire.');
    }

    // On vérifie que la TV existe
    $stmt = $pdo->prepare("SELECT COUNT(id) AS count FROM TV WHERE token = :token");
    $stmt->execute([
        ':token' => $token,
    ]);
    $count = $stmt->fetch()["count"];
    
    if ($count != 1) {
        die("TV inexistante.");
    }

    // On cherche les absences

    $stmt = $pdo->prepare("SELECT professeur, matiere, date_debut, date_fin, champ_libre FROM Absence WHERE date_fin >= NOW() ORDER BY date_debut");
    $stmt->execute();
    $rows = $stmt->fetchAll();

    header('Content-Type: application/json');
    echo json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}