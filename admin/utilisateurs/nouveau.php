<?php 
require 'auth.php'; // + gerer superadmin
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Nouveau Compte</title>
</head>
<body>
    <form action="register.php" method="POST">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Inscrire</button>
    </form>
</body>
</html>