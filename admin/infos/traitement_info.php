<?php
require '../../bdd/db.php';
require '../utilisateurs/auth.php';
require 'upload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération et nettoyage des données
    $titre       = trim($_POST['titre'] ?? '');
    $contenu     = trim($_POST['contenu'] ?? '');
    $plein_ecran = isset($_POST['plein_ecran']) ? 1 : 0;
    $date_debut  = $_POST['date_debut'] ?? '';
    $date_fin    = $_POST['date_fin'] ?? '';
    $tvs         = $_POST['tvs'] ?? [];

    // Image
    $result = uploadFichier(
        $_FILES['image'],
        "../../frontend/uploads/",
        ['jpg', 'jpeg', 'png'],
        ['image/jpeg', 'image/png']
    );

    if ($result['success']) {
        $lien_image = 'uploads/' . $result["filename"];
    } else {
        $lien_image = "";
    }

    // Validation des champs obligatoires
    if (empty($titre)) {
        die('Erreur : le titre est obligatoire.');
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

    // Validation des IDs de TVs (s'assurer que ce sont bien des entiers)
    $tvs = array_filter(array_map('intval', $tvs));

    // Début de la transaction pour garantir la cohérence des insertions
    $pdo->beginTransaction();

    try {
        // Insertion de l'information
        $stmt = $pdo->prepare("
            INSERT INTO Information (titre, contenu, lien_image, image_fullscreen, date_debut, date_fin)
            VALUES (:titre, :contenu, :lien_image, :image_fullscreen, :date_debut, :date_fin)
        ");
        $stmt->execute([
            ':titre'            => $titre,
            ':contenu'          => $contenu,
            ':lien_image'       => $lien_image,
            ':image_fullscreen' => $plein_ecran,
            ':date_debut'       => $debut->format('Y-m-d'),
            ':date_fin'         => $fin->format('Y-m-d'),
        ]);

        $id_info = $pdo->lastInsertId();

        // Insertion des liaisons TV
        if (!empty($tvs)) {
            $stmtTV = $pdo->prepare("
                INSERT INTO AffichageInfo (id_tv, id_info)
                VALUES (:id_tv, :id_info)
            ");
            foreach ($tvs as $id_tv) {
                $stmtTV->execute([
                    ':id_tv'   => $id_tv,
                    ':id_info' => $id_info,
                ]);
            }
        }

        $pdo->commit();

    } catch (Exception $e) {
        $pdo->rollBack();
        die('Erreur lors de l\'enregistrement : ' . $e->getMessage());
    }

    // Redirection après succès
    header('Location: liste_infos.php');
    exit;

} else {
    die('Accès non autorisé.');
}