<?php
require 'auth_superadmin.php';
require '../../bdd/db.php';
require '../csrf.php';

$stmt = $pdo->prepare("SELECT id, username, superadmin FROM Utilisateurs");
$stmt->execute();
$utilisateurs = $stmt->fetchAll();

$csrf = csrf_generate();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Utilisateurs</title>
</head>
<body>
    <h1>Utilisateurs</h1>
    <a href="nouveau.php">Nouvel utilisateur</a>
    <ul>
        <?php foreach ($utilisateurs as $utilisateur): ?>
        <li>
            <?= htmlspecialchars($utilisateur['username']) ?> - <?= $utilisateur['superadmin'] === 1 ? "Admin simple" : "Superadmin" ?>
            <a href="modifier_mdp.php?id=<?= $utilisateur["id"] ?>">Modifier le mot de passe</a>
            
            <!-- Supprimer le compte -->
            <form action="suppr_utilisateur.php" method="POST" style="display:inline">
                <input type="hidden" name="id"         value="<?= $utilisateur['id'] ?>">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                <button type="submit"
                        onclick="return confirm('Voulez-vous vraiment supprimer ce compte ?')">
                    Supprimer
                </button>
            </form>
        </li>
    <?php endforeach; ?>
    </ul>
    <footer><a href="/tvtest/admin/index.php">Retour au Menu</a></footer>
</body>
</html>