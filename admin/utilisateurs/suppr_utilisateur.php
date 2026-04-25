<?php
require '../../bdd/db.php';
require 'auth_superadmin.php';
require '../csrf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    csrf_verify();

    // Récupération et validation des données
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if (!$id) die('ID invalide.');

    // Mise à jour en BDD
    $stmt = $pdo->prepare('
        DELETE 
        FROM Utilisateurs
        WHERE id = ?
    ');
    $stmt->execute([$id]);

    // Redirection après succès
    header('Location: liste.php');
    exit;

} else {
    die('Accès non autorisé.');
}