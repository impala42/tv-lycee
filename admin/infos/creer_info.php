<?php require '../utilisateurs/auth.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une Information</title>
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
                    <input type="checkbox" name="tvs[]" value="<?= (int)$tv['id'] ?>">
                    <?= htmlspecialchars($tv['nom']) ?>
                </label>
            <?php endforeach; ?>
        </fieldset>

        <button type="submit">Créer</button>
    </form>
</body>
</html>
