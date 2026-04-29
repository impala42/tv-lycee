<?php
require '../utilisateurs/auth_superadmin.php';
require '../../bdd/db.php';
require '../csrf.php';

function supprimer_plats_anciens(PDO $pdo, string $plat) {
    $stmt = $pdo->prepare('
        DELETE FROM Plat JOIN Menu ON Plat.id = Menu.id_' . $plat . ' WHERE Menu.jour <= NOW(); 
    ');
    $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    // On efface tous les plats
    supprimer_plats_anciens($pdo, "entree");
    supprimer_plats_anciens($pdo, "plat_principal");
    supprimer_plats_anciens($pdo, "laitage");
    supprimer_plats_anciens($pdo, "dessert");

    // On efface toutes les menus qui sont anciens
    $stmt = $pdo->prepare('
        DELETE
        FROM Menu
        WHERE date_fin <= NOW()
    ');
    $stmt->execute();

    header('Location: index.php');
    exit;

}