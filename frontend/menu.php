<?php
require '../bdd/db.php';
require 'script.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $token = htmlspecialchars(trim($_GET['token'] ?? ''));
    $id_etab = obtenir_id_etablissement($pdo, $token);

    // On cherche le menu
    $heure = (int)date('H');
    $dateCible = $heure < 13 ? date('Y-m-d') : date('Y-m-d', strtotime('+1 day'));

    $stmt = $pdo->prepare("
        SELECT
           m.jour,

           -- Entrée
           e.nom AS entree_nom,
           e.fait_maison AS entree_fait_maison,
           e.bio AS entree_bio,
           e.circuit_court AS entree_circuit_court,
           e.sans_viande AS entree_sans_viande,

           -- Plat principal
           p.nom AS plat_nom,
           p.fait_maison AS plat_fait_maison,
           p.bio AS plat_bio,
           p.circuit_court AS plat_circuit_court,
           p.sans_viande AS plat_sans_viande,

           -- Laitage
           l.nom AS laitage_nom,
           l.fait_maison AS laitage_fait_maison,
           l.bio AS laitage_bio,
           l.circuit_court AS laitage_circuit_court,
           l.sans_viande AS laitage_sans_viande,

           -- Dessert
           d.nom AS dessert_nom,
           d.fait_maison AS dessert_fait_maison,
           d.bio AS dessert_bio,
           d.circuit_court AS dessert_circuit_court,
           d.sans_viande AS dessert_sans_viande

        FROM Menu m
        LEFT JOIN Plat e ON m.id_entree = e.id
        LEFT JOIN Plat p ON m.id_plat_principal = p.id
        LEFT JOIN Plat l ON m.id_laitage = l.id
        LEFT JOIN Plat d ON m.id_dessert = d.id

        WHERE m.jour = ? AND m.id_etablissement = ?
    ");
    $stmt->execute([$dateCible, $id_etab]);
    $menu = $stmt->fetchAll();

    header('Content-Type: application/json');
    echo json_encode($menu, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}