<?php
require '../utilisateurs/auth.php';
require '../../bdd/db.php';

// Récupération de l'article à modifier
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) die('ID invalide.');

$stmt = $pdo->prepare('SELECT * FROM TV WHERE id = ?');
$stmt->execute([$id]);
$tv = $stmt->fetch();

if (!$tv) die('TV introuvable.');

// Récupération de tous les infos
$stmtInfos = $pdo->prepare('
    SELECT * FROM Information 
    WHERE id IN (
        SELECT id_info FROM AffichageInfo WHERE id_tv IN (
            SELECT id FROM TV WHERE id_etablissement = ?
        )
    ) AND date_fin >= NOW()
');
$stmtInfos->execute([$_SESSION["id_etablissement"]]);
$infos = $stmtInfos->fetchAll();

// Récupération des infos déjà associées à cette TV
$stmtAssoc = $pdo->prepare('SELECT id_info FROM AffichageInfo WHERE id_tv = ?');
$stmtAssoc->execute([$id]);
$infosAssociees = array_column($stmtAssoc->fetchAll(), 'id_info');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier la TV</title>
</head>
<body>
    <h1>Modifier la TV : <?= $tv["nom"] ?></h1>
    <form action="traitement_modifier.php" method="POST">

        <!-- On transmet l'ID dans un champ caché -->
        <input type="hidden" name="id" value="<?= $tv['id'] ?>"> 

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom"
               value="<?= htmlspecialchars($tv['nom']) ?>" required>

        <fieldset>
            <legend>Afficher les infos sur cette TV</legend>
            <?php foreach ($infos as $info): ?>
                <label>
                    <input type="checkbox" name="infos[]" value="<?= (int)$info['id'] ?>"
                        <?= in_array($info['id'], $infosAssociees) ? 'checked' : '' ?>>
                    <?= htmlspecialchars($info['titre']) ?>
                </label>
            <?php endforeach; ?>
        </fieldset>

        <button type="submit">Enregistrer les modifications</button>
    </form>
</body>
</html>