<?php 
require "auth.php";

$id_cible = trim($_GET["id"]);
if ($id_cible == "") {
    die("ID non précisé.");
}

if ($id_cible !== $_SESSION["user_id"]) {
    require 'auth_superadmin.php';
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Modifier le mot de passe de <?= $_SESSION["username"] ?></title>
</head>
<body>
    <h1>Modifier le mot de passe de <?= $_SESSION["username"]  ?></h1>
    <form action="traitement_modifier_mdp.php" method="POST">
        <!-- On transmet l'ID dans un champ caché -->
        <input type="hidden" name="id" value="<?= $id_cible ?>">

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" placeholder="Mot de passe" required>

        <button type="submit">Modifier</button>
    </form>
</body>
</html>