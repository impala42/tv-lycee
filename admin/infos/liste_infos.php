<?php
require '../utilisateurs/auth.php';
require '../../bdd/db.php';
require '../csrf.php';

$stmt = $pdo->prepare("SELECT * FROM Information");
$stmt->execute();
$infos = $stmt->fetchAll();

$csrf = csrf_generate();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Informations</title>
</head>
<body>
    <h1>Mes Informations</h1>
    <a href="creer_info.php">nouvelle information</a>
    <ul>
        <?php foreach ($infos as $info): ?>
        <li>
            <?= htmlspecialchars($info['titre']) ?>
            <a href="modifier_info.php?id=<?= $info['id'] ?>">Modifier</a>
            
        <!-- Supprimer l'info -->
        <form action="suppr_info.php" method="POST" style="display:inline">
            <input type="hidden" name="id"         value="<?= $info['id'] ?>">
            <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
            <button type="submit"
                    onclick="return confirm('Voulez-vous vraiment supprimer cette information ?')">
                Supprimer
            </button>
        </form>
        </li>
    <?php endforeach; ?>
    </ul>
    <footer><a href="/tvtest/admin/index.php">Retour au Menu</a></footer>
</body>
</html>