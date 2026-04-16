<?php require '../utilisateurs/auth.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une Information</title>
</head>
<body>
    <h1>Créer une Information</h1>
    <form action="traitement_info.php" method="POST">

        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" required>

        <label for="contenu">Contenu :</label>
        <textarea id="contenu" name="contenu" rows="5" required></textarea>

        <label for="image">Lien vers l'image :</label>
        <input type="url" id="image" name="image" placeholder="Laisser vide si pas d'image">

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
        $stmt = $pdo->query("SELECT * FROM TV");
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

        <button type="submit">Envoyer</button>
    </form>
</body>
</html>
