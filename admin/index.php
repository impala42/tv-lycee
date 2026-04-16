<?php
require "utilisateurs/auth.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Menu</title>
</head>
<body>
    <a href="infos/liste_infos.php">Informations</a>
    <a href="tv/liste_tv.php">TVs</a>
    <a href="absences/index.php">Absences</a>
    <?php if ($_SESSION["superadmin"] == 1) { echo '<a href="utilisateurs/liste.php">Comptes</a>'; } // afficher seulement s'il a les droits ?>
</body>
</html>