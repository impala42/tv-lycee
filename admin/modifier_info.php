<?php
require '../bdd/db.php';

// Récupération de l'article à modifier
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) die('ID invalide.');

$stmt = $pdo->prepare('SELECT * FROM Information WHERE id = ?');
$stmt->execute([$id]);
$article = $stmt->fetch();

if (!$article) die('Article introuvable.');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'article</title>
</head>
<body>
    <h1>Modifier l'article</h1>
    <form action="traitement_modif_info.php" method="POST">

        <!-- On transmet l'ID dans un champ caché -->
        <input type="hidden" name="id" value="<?= $article['id'] ?>">

        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre"
               value="<?= htmlspecialchars($article['titre']) ?>" required>

        <label for="contenu">Contenu :</label>
        <textarea id="contenu" name="contenu" rows="5" required>
            <?= htmlspecialchars($article['contenu']) ?>
        </textarea>

        <label for="image">Lien vers l'image :</label>
        <input type="url" id="image" name="image"
               value="<?= htmlspecialchars($article['lien_image']) ?>">

        <label>
            <input type="checkbox" name="plein_ecran" value="1"
                <?= $article['image_fullscreen'] ? 'checked' : '' ?>>
            Afficher l'image en plein écran
        </label>

        <label for="date_debut">Date de début :</label>
        <input type="date" id="date_debut" name="date_debut"
               value="<?= $article['date_debut'] ?>" required>

        <label for="date_fin">Date de fin :</label>
        <input type="date" id="date_fin" name="date_fin"
               value="<?= $article['date_fin'] ?>" required>

        <button type="submit">Enregistrer les modifications</button>
    </form>
</body>
</html>