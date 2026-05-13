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
<title>Admin - Modifier le mot de passe</title>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #7c2d12, #fde68a);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        color: #1f1f1f;
    }

    h1 {
        color: #b45309;
        text-align: center;
        margin-bottom: 20px;
        text-shadow: 0 0 10px rgba(251,191,36,0.4);
    }

    form {
        background: rgba(255,255,255,0.8);
        padding: 25px;
        border-radius: 14px;
        border: 1px solid #fcd34d;
        box-shadow: 0 8px 18px rgba(0,0,0,0.15);
        display: flex;
        flex-direction: column;
        gap: 15px;
        width: 300px;
    }

    label {
        font-weight: bold;
        color: #4a2c1d;
    }

    input[type="password"] {
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #c4a484;
        outline: none;
    }

    input[type="password"]:focus {
        border-color: #f59e0b;
    }

    button {
        background: #ea580c;
        border: none;
        color: white;
        padding: 10px;
        border-radius: 10px;
        cursor: pointer;
        font-weight: bold;
        transition: 0.2s;
    }

    button:hover {
        background: #f97316;
        transform: scale(1.05);
    }

    /* 🔥 déco feu */
    body::before {
        content: "🔥";
        position: fixed;
        top: 15px;
        left: 15px;
        font-size: 50px;
        opacity: 0.25;
        transform: rotate(-10deg);
        pointer-events: none;
    }

    body::after {
        content: "🔥";
        position: fixed;
        bottom: 15px;
        right: 15px;
        font-size: 60px;
        opacity: 0.25;
        transform: rotate(10deg);
        pointer-events: none;
    }
</style>
</head>

<body>

<h1>Modifier le mot de passe de <?= htmlspecialchars($_SESSION["username"]) ?></h1>

<form action="traitement_modifier_mdp.php" method="POST">

    <input type="hidden" name="id" value="<?= $id_cible ?>">

    <label for="password">Nouveau mot de passe :</label>
    <input type="password" name="password" placeholder="Mot de passe" required>

    <button type="submit">Modifier</button>

</form>

</body>
</html>