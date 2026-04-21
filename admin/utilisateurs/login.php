<?php
require '../../bdd/db.php';
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

// Vérifier si l'utilisateur existe
$stmt = $pdo->prepare("SELECT * FROM Utilisateurs WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['superadmin'] = $user['superadmin'];
    $_SESSION["username"] = $user["username"];
    
    // Redirection après succès
    header('Location: ../index.php');
} else {
    // On ralentit les tentatives pour éviter le brut-force
    sleep(2);
    echo "Nom d'utilisateur ou mot de passe incorrect";
}
?>