<?php
require '../../bdd/db.php';
require '../utilisateurs/auth.php';

// Vérification des données
if (
    isset($_POST['date_debut']) &&
    isset($_POST['date_fin']) &&
    isset($_POST['professeur']) &&
    isset($_POST['matiere']) &&
    isset($_POST['id']) &&
    isset($_POST['champ_libre'])
) {
    // Conversion des dates
    $date_debut_raw = $_POST['date_debut'];
    $date_fin_raw = $_POST['date_fin'];

    // Récupération et formatage
    $date_debut = date('Y-m-d H:i:s', strtotime($date_debut_raw));
    $date_fin = date('Y-m-d H:i:s', strtotime($date_fin_raw));
    $professeur = htmlspecialchars($_POST['professeur']);
    $matiere = htmlspecialchars($_POST['matiere']);
    $id = htmlspecialchars($_POST['id']);
    $champ_libre = $_POST['champ_libre'];

    // Vérification logique
    if (strtotime($date_fin_raw) <= strtotime($date_debut_raw)) {
        die("Erreur : la date de fin doit être après la date de début.");
    }

    // Mise à jour de l'information
    $stmt = $pdo->prepare('
        UPDATE Absence
        SET date_debut = ?, date_fin = ?, professeur = ?, matiere = ?, champ_libre = ?
        WHERE id = ?
    ');
    $stmt->execute([$date_debut, $date_fin, $professeur, $matiere, $champ_libre, $id]);

    header('Location: index.php');
} else {
    echo "Tous les champs sont requis.";
}
?>