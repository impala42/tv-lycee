<?php
session_start();

// Si l'utilisateur est pas connecté on le redirige vers le login
if (!isset($_SESSION['user_id'])) {
    header("Location: /tvtest/admin/utilisateurs/login.html");
    exit();
}
?>