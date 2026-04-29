<?php
require '../../bdd/db.php';
require '../utilisateurs/auth.php';
require '../csrf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    csrf_verify();

    // Récupération et validation des données
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if (!$id) die('ID invalide.');

    // On supprime l'image
    $stmt = $pdo->prepare('
        SELECT lien_image 
        FROM Information
        WHERE id = ?
    ');
    $stmt->execute([$id]);
    $lien_image = $stmt->fetch()["lien_image"];
    if (!empty($lien_image)) {
        unlink("../../frontend/" . $lien_image);
    }

    // On supprime les liaisons avec les tvs
    $stmt = $pdo->prepare('
        DELETE 
        FROM AffichageInfo
        WHERE id_info = ?
    ');
    $stmt->execute([$id]);

    // On supprime l'info
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