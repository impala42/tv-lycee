<?php
require '../../bdd/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération et validation des données
    $id         = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $titre      = htmlspecialchars(trim($_POST['titre'] ?? ''));
    $contenu    = htmlspecialchars(trim($_POST['contenu'] ?? ''));
    $image      = filter_input(INPUT_POST, 'image', FILTER_VALIDATE_URL);
    $plein_ecran = isset($_POST['plein_ecran']) ? 1 : 0;
    $date_debut = $_POST['date_debut'] ?? '';
    $date_fin   = $_POST['date_fin'] ?? '';

    if (!$id) die('ID invalide.');
    if (empty($titre) || empty($contenu)) die('Titre et contenu obligatoires.');
    if ($image === false) die('URL d\'image invalide.');

    $debut = DateTimeImmutable::createFromFormat('Y-m-d', $date_debut);
    $fin   = DateTimeImmutable::createFromFormat('Y-m-d', $date_fin);

    if (!$debut || !$fin) die('Dates invalides.');
    if ($fin <= $debut) die('La date de fin doit être après la date de début.');

    // Mise à jour en BDD
    $stmt = $pdo->prepare('
        UPDATE Information
        SET titre = ?, contenu = ?, lien_image = ?, image_fullscreen = ?, date_debut = ?, date_fin = ?
        WHERE id = ?
    ');
    $stmt->execute([$titre, $contenu, $image, $plein_ecran, $date_debut, $date_fin, $id]);

    // Redirection après succès
    header('Location: liste_infos.php');
    exit;

} else {
    die('Accès non autorisé.');
}