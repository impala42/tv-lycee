<?php
require '../utilisateurs/auth_superadmin.php';
require '../../bdd/db.php';
require '../csrf.php';

$csrf = csrf_generate();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Avancés</title>
</head>
<body>
    <h1>⚠️ Avancés ⚠️</h1>
    
    <h2>Supprimer les informations trop vieilles</h2>
    <p>Supprime toutes les informations dont la date de fin est inferieure à la date actuelle (pour tous les établissements).</p>
    <form action="suppr_vieilles_infos.php" method="POST" style="display:inline">
        <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
        <button type="submit"
            onclick="return confirm('Voulez-vous vraiment supprimer ces informations ?')">
            Supprimer ces informations
        </button>
    </form>
</body>
</html>