<?php
require '../../bdd/db.php';
require '../utilisateurs/auth.php';

// Vérification des données
if (
    isset($_POST['date_debut']) &&
    isset($_POST['date_fin']) &&
    isset($_POST['professeur']) &&
    isset($_POST['matiere'])
) {
    // Conversion des dates
    $date_debut_raw = $_POST['date_debut'];
    $date_fin_raw = $_POST['date_fin'];

    // Récupération et formatage
    $date_debut = date('Y-m-d H:i:s', strtotime($date_debut_raw));
    $date_fin = date('Y-m-d H:i:s', strtotime($date_fin_raw));
    $professeur = htmlspecialchars($_POST['professeur']);
    $matiere = htmlspecialchars($_POST['matiere']);

    // Vérification logique
    if (strtotime($date_fin_raw) <= strtotime($date_debut_raw)) {
        die("Erreur : la date de fin doit être après la date de début.");
    }

    $stmt = $pdo->prepare("INSERT INTO Absence (date_debut, date_fin, professeur, matiere) VALUES (:date_debut, :date_fin, :professeur, :matiere)");

    $stmt->execute([
        ':date_debut' => $date_debut,
        ':date_fin' => $date_fin,
        ':professeur' => $professeur,
        ':matiere' => $matiere
    ]);

    header('Location: index.php');
} else {
    echo "Tous les champs sont requis.";
}
?>