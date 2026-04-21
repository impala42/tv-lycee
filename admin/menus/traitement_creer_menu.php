<?php
require '../../bdd/db.php';
require '../utilisateurs/auth.php';
require 'inserer_plat.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération et nettoyage des données

    // date
    $date  = $_POST['date'] ?? '';
    $date = DateTimeImmutable::createFromFormat('Y-m-d', $date);
    if(!$date) {
        die("Erreur : date invalide.");
    }
    

    // Entree
    $entree = trim($_POST['entree'] ?? '');
    $e_fm = isset($_POST['e_fait_maison']) ? 1 : 0;
    $e_bio = isset($_POST['e_bio']) ? 1 : 0;
    $e_cc = isset($_POST['e_circuit_court']) ? 1 : 0;
    $e_sv = isset($_POST['e_sans_viande']) ? 1 : 0;

    // Plat
    $plat = trim($_POST['plat'] ?? '');
    $p_fm = isset($_POST['p_fait_maison']) ? 1 : 0;
    $p_bio = isset($_POST['p_bio']) ? 1 : 0;
    $p_cc = isset($_POST['p_circuit_court']) ? 1 : 0;
    $p_sv = isset($_POST['p_sans_viande']) ? 1 : 0;

    // Laitage
    $laitage = trim($_POST['laitage'] ?? '');
    $l_fm = isset($_POST['l_fait_maison']) ? 1 : 0;
    $l_bio = isset($_POST['l_bio']) ? 1 : 0;
    $l_cc = isset($_POST['l_circuit_court']) ? 1 : 0;
    $l_sv = isset($_POST['l_sans_viande']) ? 1 : 0;

    // Dessert
    $dessert = trim($_POST['dessert'] ?? '');
    $d_fm = isset($_POST['d_fait_maison']) ? 1 : 0;
    $d_bio = isset($_POST['d_bio']) ? 1 : 0;
    $d_cc = isset($_POST['d_circuit_court']) ? 1 : 0;
    $d_sv = isset($_POST['d_sans_viande']) ? 1 : 0;

    // Début de la transaction pour garantir la cohérence des insertions
    $pdo->beginTransaction();


    try {
        // Insertion des plats
        $id_entree = insererPlat($pdo, $entree, $e_fm, $e_bio, $e_cc, $e_sv);
        $id_plat = insererPlat($pdo, $plat, $p_fm, $p_bio, $p_cc, $p_sv);
        $id_laitage = insererPlat($pdo, $laitage, $l_fm, $l_bio, $l_cc, $l_sv);
        $id_dessert = insererPlat($pdo, $dessert, $d_fm, $d_bio, $d_cc, $d_sv);
        

        // Et on ajoute le menu finalement
        $stmt = $pdo->prepare("
            INSERT INTO Menu (jour, id_entree, id_plat_principal, id_laitage, id_dessert)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$date->format("Y-m-d"), $id_entree, $id_plat, $id_laitage, $id_dessert]);

        $pdo->commit();

    } catch (Exception $e) {
        $pdo->rollBack();
        die('Erreur lors de l\'enregistrement : ' . $e->getMessage());
    }

    // Redirection après succès
    header('Location: index.php');
    exit;

} else {
    die('Accès non autorisé.');
}