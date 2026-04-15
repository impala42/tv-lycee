<?php
require '../../bdd/db.php';
require '../utilisateurs/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // Récupération et validation des données
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if (!$id) die('ID invalide.');

    // Mise à jour en BDD
    $stmt = $pdo->prepare('
        DELETE 
        FROM Information
        WHERE id = ?
    ');
    $stmt->execute([$id]);

    // Redirection après succès
    header('Location: liste_infos.php');
    exit;

} else {
    die('Accès non autorisé.');
}