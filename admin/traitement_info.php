<?php
require '../bdd/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération et nettoyage des données
    $titre      = htmlspecialchars(trim($_POST['titre'] ?? ''));
    $contenu    = htmlspecialchars(trim($_POST['contenu'] ?? ''));
    $image      = filter_input(INPUT_POST, 'image', FILTER_VALIDATE_URL);
    $plein_ecran = isset($_POST['plein_ecran']) ? true : false;
    $date_debut = $_POST['date_debut'] ?? '';
    $date_fin   = $_POST['date_fin'] ?? '';

    // Validation des champs obligatoires
    if (empty($titre) || empty($contenu)) {
        die('Erreur : le titre et le contenu sont obligatoires.');
    }

    if ($image === false) {
        die('Erreur : le lien vers l\'image n\'est pas une URL valide.');
    }

    // Validation et conversion des dates
    $debut = DateTimeImmutable::createFromFormat('Y-m-d', $date_debut);
    $fin   = DateTimeImmutable::createFromFormat('Y-m-d', $date_fin);

    if (!$debut || !$fin) {
        die('Erreur : les dates ne sont pas valides.');
    }

    if ($fin <= $debut) {
        die('Erreur : la date de fin doit être postérieure à la date de début.');
    }

    // Affichage / utilisation
    echo '<h1>' . $titre . '</h1>';
    echo '<p>' . $contenu . '</p>';

    echo '<img src="' . $image . '" alt="Image de l\'article">';

    echo '<p>Du ' . $debut->format('d/m/Y') . ' au ' . $fin->format('d/m/Y') . '</p>';
    echo '<p>Plein écran : ' . ($plein_ecran ? 'Oui' : 'Non') . '</p>';

    $stmt = $pdo->prepare("INSERT INTO Information (titre, contenu, lien_image, image_fullscreen, date_debut, date_fin) VALUES (:titre, :contenu, :lien_image, :image_fullscreen, :date_debut, :date_fin)");
    $stmt->execute([
        ':titre'   => $titre,
        ':contenu' => $contenu,
        ':lien_image'   => $image,
        ':image_fullscreen' => $plein_ecran,
        ':date_debut' => $debut->format("Y-m-d"),
        ':date_fin' => $fin->format("Y-m-d")
    ]);

} else {
    die('Accès non autorisé.');
}