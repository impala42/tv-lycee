<?php 
require 'auth_superadmin.php';
require '../../bdd/db.php';

$stmt = $pdo->prepare("SELECT * FROM Etablissement");
$stmt->execute();
$etablissements = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Nouveau Compte</title>
</head>
<body>
    <form action="register.php" method="POST">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" placeholder="Mot de passe" required>

        <label for="superadmin">Donner les droits maximaux à cet utilisateur :</label>
        <input type="checkbox" name="superadmin" placeholder="Superadmin">

        <label for="etablissement">Etablissement : </label>
        <select name="etablissement" id="etablissement">
        <?php foreach ($etablissements as $etablissement): ?>
            <option value="<?= $etablissement["id"] ?>"><?= $etablissement["nom"] ?></option>
        <?php endforeach; ?>
        </select>

        <button type="submit">Inscrire</button>
    </form>
</body>
</html>