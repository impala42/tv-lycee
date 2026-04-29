<?php
require '../utilisateurs/auth_superadmin.php';
require '../../bdd/db.php';
require '../csrf.php';
require '../infos/tools.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    // On cherche tous les ids d'infos qui sont anciennes
    $stmt = $pdo->prepare('
        SELECT id 
        FROM Information
        WHERE date_fin <= NOW()
    ');
    $stmt->execute();
    $infos = $stmt->fetchAll();
    
    foreach ($infos as $info) { // Et on les suppriment toutes
        supprimer_info($pdo, $info["id"]);
    }

    header('Location: index.php');
    exit;

}