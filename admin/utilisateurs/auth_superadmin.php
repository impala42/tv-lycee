<?php
session_start();

// Si l'utilisateur est pas connecté on le redirige vers le login
if (!isset($_SESSION['user_id'])) {
    header("Location: /tvtest/admin/utilisateurs/login.html");
    exit();
}

if ($_SESSION['superadmin'] != 1) {
    echo "Vous n'avez pas les droits d'accès à ceci.";
    exit();
}

?>