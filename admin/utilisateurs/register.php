<?php
require 'auth_superadmin.php';
require '../../bdd/db.php';

// Récupération des données
$username = $_POST['username'];
$password = $_POST['password'];

// Hash du mot de passe
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Préparation de la requête
$stmt = $pdo->prepare("INSERT INTO Utilisateurs (username, password) VALUES (?, ?)");
$stmt->execute([$username, $hashedPassword]);

header("Location: liste.php");
?>