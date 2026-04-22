<?php
require '../../bdd/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération et nettoyage des données
    $nom = htmlspecialchars(trim($_POST['nom'] ?? ''));

    // Validation des champs obligatoires
    if (empty($nom)) {
        die('Erreur : le nom est obligatoire.');
    }

    // créer le token aléatoirement
    $token = bin2hex(random_bytes(10));

    $stmt = $pdo->prepare("INSERT INTO TV (nom, token) VALUES (:nom, :token)");
    $stmt->execute([
        ':nom'   => $nom,
        ':token' => $token
    ]);

    // Redirection après succès
    header('Location: liste_tv.php');
    exit;
} else {
    die('Accès non autorisé.');
}