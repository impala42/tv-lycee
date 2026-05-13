<?php
require '../utilisateurs/auth.php';
require '../../bdd/db.php';

// Récupération de l'article à modifier
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) die('ID invalide.');

$stmt = $pdo->prepare('SELECT * FROM Information WHERE id = ?');
$stmt->execute([$id]);
$article = $stmt->fetch();

if (!$article) die('Article introuvable.');

// Récupération de toutes les TVs
$stmtTVs = $pdo->prepare('SELECT * FROM TV WHERE id_etablissement = ?');
$stmtTVs->execute([$_SESSION["id_etablissement"]]);
$tvs = $stmtTVs->fetchAll();

// Récupération des TVs déjà associées à cette information
$stmtAssoc = $pdo->prepare('SELECT id_tv FROM AffichageInfo WHERE id_info = ?');
$stmtAssoc->execute([$id]);
$tvsAssociees = array_column($stmtAssoc->fetchAll(), 'id_tv');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modifier l'article</title>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #5b21b6, #e9d5ff);
        color: #2e1065;
    }

    h1 {
        text-align: center;
        margin-top: 25px;
        color: #6d28d9;
        text-shadow: 0 0 10px rgba(192,132,252,0.4);
    }

    form {
        max-width: 750px;
        margin: 25px auto;
        background: rgba(255,255,255,0.88);
        padding: 25px;
        border-radius: 18px;
        border: 2px solid #d8b4fe;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);

        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    label {
        font-weight: bold;
        color: #5b21b6;
    }

    input[type="text"],
    input[type="date"],
    textarea,
    input[type="file"] {
        padding: 10px;
        border-radius: 10px;
        border: 1px solid #c4b5fd;
        outline: none;
        font-size: 14px;
    }

    textarea {
        resize: vertical;
        min-height: 120px;
    }

    input:focus,
    textarea:focus {
        border-color: #9333ea;
        box-shadow: 0 0 8px rgba(168,85,247,0.3);
    }

    fieldset {
        border: 2px solid #d8b4fe;
        border-radius: 12px;
        padding: 15px;
        background: rgba(243,232,255,0.6);
    }

    legend {
        padding: 0 10px;
        font-weight: bold;
        color: #7e22ce;
    }

    fieldset label {
        display: block;
        margin-bottom: 8px;
    }

    input[type="checkbox"] {
        transform: scale(1.15);
        margin-right: 6px;
    }

    button {
        background: #7c3aed;
        color: white;
        border: none;
        padding: 12px;
        border-radius: 12px;
        cursor: pointer;
        font-weight: bold;
        font-size: 15px;
        transition: 0.2s;
    }

    button:hover {
        background: #9333ea;
        transform: scale(1.03);
    }

    /* 🌸 fleurs décoratives */
    body::before {
        content: "🌸🌸";
        position: fixed;
        top: 15px;
        left: 15px;
        font-size: 55px;
        opacity: 0.25;
        transform: rotate(-10deg);
        pointer-events: none;
    }

    body::after {
        content: "🌸🌸";
        position: fixed;
        bottom: 15px;
        right: 15px;
        font-size: 65px;
        opacity: 0.25;
        transform: rotate(10deg);
        pointer-events: none;
    }
</style>
</head>

<body>

<h1>Modifier l'article</h1>

<form action="traitement_modif_info.php" method="POST" enctype="multipart/form-data">

    <!-- ID caché -->
    <input type="hidden" name="id" value="<?= $article['id'] ?>">

    <label for="titre">Titre :</label>
    <input 
        type="text" 
        id="titre" 
        name="titre"
        value="<?= htmlspecialchars($article['titre']) ?>" 
        required
    >

    <label for="contenu">Contenu :</label>
    <textarea 
        id="contenu" 
        name="contenu" 
        rows="5"
    ><?= htmlspecialchars(trim($article['contenu'])) ?></textarea>

    <label for="image">Image :</label>
    <input type="file" id="image" name="image">

    <label>
        <input 
            type="checkbox" 
            name="plein_ecran" 
            value="1"
            <?= $article['image_fullscreen'] ? 'checked' : '' ?>
        >
        Afficher l'image en plein écran
    </label>

    <label for="date_debut">Date de début :</label>
    <input 
        type="date" 
        id="date_debut" 
        name="date_debut"
        value="<?= $article['date_debut'] ?>" 
        required
    >

    <label for="date_fin">Date de fin :</label>
    <input 
        type="date" 
        id="date_fin" 
        name="date_fin"
        value="<?= $article['date_fin'] ?>" 
        required
    >

    <fieldset>
        <legend>Afficher sur les TVs :</legend>

        <?php foreach ($tvs as $tv): ?>
            <label>
                <input 
                    type="checkbox" 
                    name="tvs[]" 
                    value="<?= (int)$tv['id'] ?>"
                    <?= in_array($tv['id'], $tvsAssociees) ? 'checked' : '' ?>
                >

                <?= htmlspecialchars($tv['nom']) ?>
            </label>
        <?php endforeach; ?>
    </fieldset>

    <button type="submit">
        Enregistrer les modifications
    </button>

</form>

</body>
</html>