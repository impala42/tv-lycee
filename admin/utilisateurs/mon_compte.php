<?php
require 'auth.php';
require '../../bdd/db.php';

$stmt = $pdo->prepare("
    SELECT u.id, superadmin, username, u.id_etablissement, nom AS etablissement 
    FROM Utilisateurs AS u 
    JOIN Etablissement AS e ON u.id_etablissement = e.id 
    WHERE u.id = ?
");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$_SESSION['user_id'] = $user['id'];
$_SESSION['superadmin'] = $user['superadmin'];
$_SESSION["username"] = $user["username"];
$_SESSION["id_etablissement"] = $user["id_etablissement"];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mon Compte - <?= htmlspecialchars($user["username"]) ?></title>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #064e3b, #a7f3d0);
        color: #052e16;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        text-align: center;
    }

    h1 {
        color: #065f46;
        margin-bottom: 10px;
        text-shadow: 0 0 10px rgba(16,185,129,0.3);
    }

    .card {
        background: rgba(255,255,255,0.85);
        border: 2px solid #6ee7b7;
        border-radius: 14px;
        padding: 25px;
        box-shadow: 0 8px 18px rgba(0,0,0,0.15);
        width: 320px;
    }

    p {
        margin: 10px 0;
        font-size: 16px;
    }

    a {
        display: inline-block;
        margin-top: 10px;
        color: #059669;
        font-weight: bold;
        text-decoration: none;
    }

    a:hover {
        color: #10b981;
    }

    footer {
        margin-top: 20px;
    }

    footer a {
        color: #047857;
    }

    footer a:hover {
        color: #10b981;
    }

    /* 🌿 déco feuilles coins */
    body::before {
        content: "🌿";
        position: fixed;
        top: 15px;
        left: 15px;
        font-size: 50px;
        opacity: 0.25;
        transform: rotate(-10deg);
        pointer-events: none;
    }

    body::after {
        content: "🌿";
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

<div class="card">

    <h1>Mon Compte</h1>

    <p><strong><?= htmlspecialchars($user["username"]) ?></strong></p>

    <p>Vous êtes :
        <strong>
            <?= $user['superadmin'] === 1 ? "Superadmin" : "Admin" ?>
        </strong>
    </p>

    <p>
        Établissement : 
        <strong><?= htmlspecialchars($user["etablissement"]) ?></strong>
    </p>

    <a href="modifier_mdp.php?id=<?= $user["id"] ?>">
        Modifier votre mot de passe
    </a>

</div>

<footer>
    <a href="/tvtest/admin/index.php">Retour au Menu</a>
</footer>

</body>
</html>