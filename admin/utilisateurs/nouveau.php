<?php 
require 'auth_superadmin.php';
require '../../bdd/db.php';

$stmt = $pdo->prepare("SELECT * FROM Etablissement");
$stmt->execute();
$etablissements = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Nouveau Compte</title>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #7c2d12, #fde68a);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        color: #1f1f1f;
    }

    form {
        background: rgba(255,255,255,0.85);
        padding: 25px;
        border-radius: 14px;
        border: 1px solid #fcd34d;
        box-shadow: 0 8px 18px rgba(0,0,0,0.15);
        width: 350px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    h1 {
        text-align: center;
        color: #b45309;
        margin-bottom: 10px;
        text-shadow: 0 0 10px rgba(251,191,36,0.4);
    }

    label {
        font-weight: bold;
        color: #4a2c1d;
        margin-top: 5px;
    }

    input[type="text"],
    input[type="password"],
    select {
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #c4a484;
        outline: none;
    }

    input[type="text"]:focus,
    input[type="password"]:focus,
    select:focus {
        border-color: #f59e0b;
    }

    input[type="checkbox"] {
        transform: scale(1.2);
        margin-right: 6px;
    }

    button {
        margin-top: 15px;
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

    /* 🔥 décor feu */
    body::before {
        content: "🔥🔥";
        position: fixed;
        top: 15px;
        left: 15px;
        font-size: 50px;
        opacity: 0.25;
        transform: rotate(-10deg);
        pointer-events: none;
    }

    body::after {
        content: "🔥🔥";
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

<form action="register.php" method="POST">

    <h1>Nouveau compte</h1>

    <label>Nom d'utilisateur :</label>
    <input type="text" name="username" placeholder="Nom d'utilisateur" required>

    <label>Mot de passe :</label>
    <input type="password" name="password" placeholder="Mot de passe" required>

    <label>
        <input type="checkbox" name="superadmin">
        Donner les droits superadmin
    </label>

    <label>Etablissement :</label>
    <select name="etablissement" id="etablissement">
        <?php foreach ($etablissements as $etablissement): ?>
            <option value="<?= $etablissement["id"] ?>">
                <?= htmlspecialchars($etablissement["nom"]) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Inscrire</button>

</form>

</body>
</html>