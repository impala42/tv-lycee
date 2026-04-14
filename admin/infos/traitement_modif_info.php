<?php
require '../../bdd/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération et validation des données
    $id          = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $titre       = trim($_POST['titre'] ?? '');
    $contenu     = trim($_POST['contenu'] ?? '');
    $image       = filter_input(INPUT_POST, 'image', FILTER_VALIDATE_URL);
    $plein_ecran = isset($_POST['plein_ecran']) ? 1 : 0;
    $date_debut  = $_POST['date_debut'] ?? '';
    $date_fin    = $_POST['date_fin'] ?? '';
    $tvs         = $_POST['tvs'] ?? [];

    if (!$id) die('ID invalide.');
    if (empty($titre) || empty($contenu)) die('Titre et contenu obligatoires.');
    if ($image === false) die('URL d\'image invalide.');

    $debut = DateTimeImmutable::createFromFormat('Y-m-d', $date_debut);
    $fin   = DateTimeImmutable::createFromFormat('Y-m-d', $date_fin);

    if (!$debut || !$fin) die('Dates invalides.');
    if ($fin <= $debut) die('La date de fin doit être après la date de début.');

    // Validation des IDs de TVs
    $tvs = array_filter(array_map('intval', $tvs));

    // Transaction pour garantir la cohérence
    $pdo->beginTransaction();

    try {
        // Mise à jour de l'information
        $stmt = $pdo->prepare('
            UPDATE Information
            SET titre = ?, contenu = ?, lien_image = ?, image_fullscreen = ?, date_debut = ?, date_fin = ?
            WHERE id = ?
        ');
        $stmt->execute([$titre, $contenu, $image, $plein_ecran, $date_debut, $date_fin, $id]);

        // Suppression des anciennes associations TV
        $stmtDel = $pdo->prepare('DELETE FROM AffichageInfo WHERE id_info = ?');
        $stmtDel->execute([$id]);

        // Insertion des nouvelles associations TV
        if (!empty($tvs)) {
            $stmtTV = $pdo->prepare('
                INSERT INTO AffichageInfo (id_tv, id_info)
                VALUES (:id_tv, :id_info)
            ');
            foreach ($tvs as $id_tv) {
                $stmtTV->execute([
                    ':id_tv'   => $id_tv,
                    ':id_info' => $id,
                ]);
            }
        }

        $pdo->commit();

    } catch (Exception $e) {
        $pdo->rollBack();
        die('Erreur lors de la mise à jour : ' . $e->getMessage());
    }

    // Redirection après succès
    header('Location: liste_infos.php');
    exit;

} else {
    die('Accès non autorisé.');
}