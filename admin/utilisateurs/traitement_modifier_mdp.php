<?php 
require "auth.php";
require '../../bdd/db.php';

// Récupération des données
$id = trim($_POST['id']);
$password = trim($_POST['password']);

// Si c'est l'id de l'utilisateur actif c'est bon sinon il faut qu'il soit superadmin
if ($id !== $_SESSION["user_id"]) {
    require "auth_superadmin.php";
}

// Hash du mot de passe
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Préparation de la requête
$stmt = $pdo->prepare("
    UPDATE Utilisateurs
    SET password = ?
    WHERE id = ?
");
$stmt->execute([$hashedPassword, $id]);



header("Location: liste.php");
?>
