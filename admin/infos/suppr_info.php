<?php
require '../../bdd/db.php';
require '../utilisateurs/auth.php';
require '../csrf.php';
require 'tools.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    csrf_verify();

    // Récupération et validation des données
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    
    supprimer_info($pdo, $id);

    // Redirection après succès
    header('Location: liste_infos.php');
    exit;

} else {
    die('Accès non autorisé.');
}