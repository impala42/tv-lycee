<?php
require '../utilisateurs/auth.php';
require '../../bdd/db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) die('ID invalide.');

$stmt = $pdo->prepare('SELECT * FROM TV WHERE id = ?');
$stmt->execute([$id]);
$tv = $stmt->fetch();

if (!$tv) die('TV introuvable.');

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

$stmtAssoc = $pdo->prepare('SELECT id_info FROM AffichageInfo WHERE id_tv = ?');
$stmtAssoc->execute([$id]);
$infosAssociees = array_column($stmtAssoc->fetchAll(), 'id_info');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier TV</title>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #e0f2fe; /* bleu ciel */
        color: #0f172a;
    }

    h1 {
        text-align: center;
        color: #075985;
        margin-top: 30px;
    }

    form {
        max-width: 700px;
        margin: 30px auto;
        background: #ffffff;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(2, 132, 199, 0.15);
        border: 1px solid #bae6fd;
    }

    label {
        font-weight: 600;
        color: #0c4a6e;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        margin-bottom: 20px;
        border-radius: 10px;
        border: 1px solid #7dd3fc;
        outline: none;
    }

    fieldset {
        border: 1px solid #7dd3fc;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 20px;
        background: #f0f9ff;
    }

    legend {
        font-weight: bold;
        color: #0369a1;
    }

    fieldset label {
        display: block;
        margin: 8px 0;
        font-weight: normal;
        color: #0f172a;
    }

    input[type="checkbox"] {
        margin-right: 8px;
        transform: scale(1.1);
    }

    button {
        background: #38bdf8;
        border: none;
        padding: 12px 20px;
        border-radius: 10px;
        font-weight: bold;
        cursor: pointer;
        color: white;
        width: 100%;
        font-size: 16px;
        transition: 0.2s;
    }

    button:hover {
        background: #0ea5e9;
    }

</style>
</head>

<body>

<h1>Modifier la TV : <?= htmlspecialchars($tv["nom"]) ?></h1>

<form action="traitement_modifier.php" method="POST">

    <input type="hidden" name="id" value="<?= $tv['id'] ?>">

    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom"
           value="<?= htmlspecialchars($tv['nom']) ?>" required>

    <fieldset>
        <legend>Informations affichées sur cette TV</legend>

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