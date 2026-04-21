<?php
require '../../bdd/db.php';
require '../utilisateurs/auth.php';
require '../csrf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    csrf_verify();

    // Récupération et validation des données
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if (!$id) die('ID invalide.');

    // Mise à jour en BDD
    $stmt = $pdo->prepare('
        DELETE 
        FROM Absence
        WHERE id = ?
    ');
    $stmt->execute([$id]);

    // Redirection après succès
    header('Location: index.php');
    exit;

} else {
    die('Accès non autorisé.');
}