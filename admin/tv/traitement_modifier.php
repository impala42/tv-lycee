<?php
require '../utilisateurs/auth.php';
require '../../bdd/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération et validation des données
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $infos = $_POST['infos'] ?? [];

    if (!$id) die('ID invalide.');

    // Validation des IDs des infos
    $infos = array_filter(array_map('intval', $infos));

    // Transaction pour garantir la cohérence
    $pdo->beginTransaction();

    try {
        // Suppression des anciennes associations infos
        $stmtDel = $pdo->prepare('DELETE FROM AffichageInfo WHERE id_tv = ?');
        $stmtDel->execute([$id]);

        // Insertion des nouvelles associations infos
        if (!empty($infos)) {
            $stmtTV = $pdo->prepare('
                INSERT INTO AffichageInfo (id_tv, id_info)
                VALUES (:id_tv, :id_info)
            ');
            foreach ($infos as $id_info) {
                $stmtTV->execute([
                    ':id_tv'   => $id,
                    ':id_info' => $id_info,
                ]);
            }
        }

        $pdo->commit();

    } catch (Exception $e) {
        $pdo->rollBack();
        die('Erreur lors de la mise à jour : ' . $e->getMessage());
    }

    // Redirection après succès
    header('Location: liste_tv.php');
    exit;

} else {
    die('Accès non autorisé.');
}