<?php
require 'auth_superadmin.php';
require '../../bdd/db.php';

// Récupération des données
$username = $_POST['username'];
$password = $_POST['password'];
$superadmin = isset($_POST['superadmin']) ? 1 : 0;
$id_etablissement = filter_input(INPUT_POST, 'etablissement', FILTER_VALIDATE_INT);

// Hash du mot de passe
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Préparation de la requête
$stmt = $pdo->prepare("INSERT INTO Utilisateurs (username, password, superadmin, id_etablissement) VALUES (?, ?, ?, ?)");
$stmt->execute([$username, $hashedPassword, $superadmin, $id_etablissement]);

header("Location: liste.php");
?>