<?php
require '../utilisateurs/auth_superadmin.php';
require '../../bdd/db.php';
require '../csrf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    // On efface toutes les absences qui sont anciennes
    $stmt = $pdo->prepare('
        DELETE
        FROM Absence
        WHERE date_fin <= NOW()
    ');
    $stmt->execute();

    header('Location: index.php');
    exit;

}