<?php require '../utilisateurs/auth.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Créer une Information</title>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #4c1d95, #e9d5ff);
        color: #2b1b2e;
    }

    h1 {
        text-align: center;
        margin-top: 20px;
        color: #5b21b6;
        text-shadow: 0 0 10px rgba(168,85,247,0.3);
    }

    form {
        max-width: 700px;
        margin: 20px auto;
        background: rgba(255,255,255,0.85);
        padding: 20px;
        border-radius: 14px;
        border: 1px solid #d8b4fe;
        box-shadow: 0 8px 18px rgba(0,0,0,0.15);
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    label {
        font-weight: bold;
        color: #4c1d95;
    }

    input[type="text"],
    input[type="date"],
    textarea {
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #c4b5fd;
        outline: none;
    }

    input:focus,
    textarea:focus {
        border-color: #a855f7;
    }

    textarea {
        resize: vertical;
    }

    fieldset {
        border: 1px solid #c084fc;
        border-radius: 10px;
        padding: 10px;
        background: rgba(243,232,255,0.6);
    }

    legend {
        font-weight: bold;
        color: #6d28d9;
    }

    input[type="checkbox"] {
        transform: scale(1.2);
        margin-right: 6px;
    }

    button {
        background: #7c3aed;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 10px;
        cursor: pointer;
        font-weight: bold;
        transition: 0.2s;
    }

    button:hover {
        background: #a855f7;
        transform: scale(1.05);
    }

    /* 🌸 fleurs décoratives */
    body::before {
        content: "🌸🌸";
        position: fixed;
        top: 15px;
        left: 15px;
        font-size: 50px;
        opacity: 0.25;
        pointer-events: none;
        transform: rotate(-10deg);
    }

    body::after {
        content: "🌸🌸";
        position: fixed;
        bottom: 15px;
        right: 15px;
        font-size: 60px;
        opacity: 0.25;
        pointer-events: none;
        transform: rotate(10deg);
    }
</style>
</head>

<body>

<h1>Créer une Information</h1>

<form action="traitement_info.php" method="POST" enctype="multipart/form-data">

    <label for="titre">Titre :</label>
    <input type="text" id="titre" name="titre" required>

    <label for="contenu">Contenu :</label>
    <textarea id="contenu" name="contenu" rows="5"></textarea>

    <label for="image">Image :</label>
    <input type="file" id="image" name="image">

    <label>
        <input type="checkbox" name="plein_ecran" value="1">
        Afficher l'image en plein écran
    </label>

    <label for="date_debut">Date de début :</label>
    <input type="date" id="date_debut" name="date_debut" required>

    <label for="date_fin">Date de fin :</label>
    <input type="date" id="date_fin" name="date_fin" required>

    <?php
    require '../../bdd/db.php';
    $stmt = $pdo->prepare("SELECT * FROM TV WHERE id_etablissement = ?");
    $stmt->execute([$_SESSION["id_etablissement"]]);
    $tvs  = $stmt->fetchAll();
    ?>

    <fieldset>
        <legend>Afficher sur les TVs :</legend>
        <?php foreach ($tvs as $tv): ?>
            <label>
                <input type="checkbox" name="tvs[]" value="<?= (int)$tv['id'] ?>" checked>
                <?= htmlspecialchars($tv['nom']) ?>
            </label>
        <?php endforeach; ?>
    </fieldset>

    <button type="submit">Créer</button>

</form>

</body>
</html>