<?php
require 'auth_superadmin.php';
require '../../bdd/db.php';
require '../csrf.php';

$stmt = $pdo->prepare("
    SELECT u.id, u.username, u.superadmin, e.nom AS etablissement 
    FROM Utilisateurs AS u 
    JOIN Etablissement AS e ON u.id_etablissement = e.id 
    ORDER BY u.id_etablissement
");
$stmt->execute();
$utilisateurs = $stmt->fetchAll();

$csrf = csrf_generate();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Utilisateurs</title>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #7c2d12, #fde68a);
        color: #1f1f1f;
        text-align: center;
    }

    h1 {
        margin-top: 20px;
        color: #b45309;
        text-shadow: 0 0 10px rgba(251,191,36,0.4);
    }

    /* ➕ bouton nouvel utilisateur */
    .new-user {
        display: inline-block;
        margin: 15px auto;
        padding: 10px 18px;
        background: #f59e0b;
        color: white;
        border-radius: 10px;
        font-weight: bold;
        text-decoration: none;
        box-shadow: 0 5px 12px rgba(0,0,0,0.15);
        transition: 0.2s;
    }

    .new-user:hover {
        background: #ea580c;
        transform: scale(1.05);
    }

    ul {
        list-style: none;
        padding: 0;
        max-width: 800px;
        margin: 20px auto;
    }

    li {
        background: rgba(255,255,255,0.75);
        margin: 10px 0;
        padding: 12px;
        border-radius: 12px;
        border: 1px solid #fcd34d;
        box-shadow: 0 5px 12px rgba(0,0,0,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    a {
        color: #d97706;
        font-weight: bold;
        text-decoration: none;
        margin: 0 5px;
    }

    a:hover {
        color: #f59e0b;
    }

    button {
        background: #ea580c;
        border: none;
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        cursor: pointer;
    }

    button:hover {
        background: #f97316;
    }

    form {
        display: inline;
    }

    footer {
        text-align: center;
        margin: 30px 0;
    }

    /* 🔥 déco feu coins */
    body::before {
        content: "🔥🔥🔥";
        position: fixed;
        top: 15px;
        left: 15px;
        font-size: 40px;
        opacity: 0.25;
        pointer-events: none;
        transform: rotate(-10deg);
    }

    body::after {
        content: "🔥🔥";
        position: fixed;
        bottom: 15px;
        right: 15px;
        font-size: 50px;
        opacity: 0.25;
        pointer-events: none;
        transform: rotate(10deg);
    }

</style>
</head>

<body>

<h1>Utilisateurs</h1>

<a class="new-user" href="nouveau.php">➕ Nouvel utilisateur</a>

<ul>
    <?php foreach ($utilisateurs as $utilisateur): ?>
    <li>
        <span>
            <?= htmlspecialchars($utilisateur['username']) ?> - 
            <?= $utilisateur['superadmin'] === 0 ? "Admin simple" : "Superadmin" ?> - 
            <?= htmlspecialchars($utilisateur['etablissement']) ?>
        </span>

        <span>
            <a href="modifier_mdp.php?id=<?= $utilisateur["id"] ?>">Modifier mot de passe</a>

            <form action="suppr_utilisateur.php" method="POST">
                <input type="hidden" name="id" value="<?= $utilisateur['id'] ?>">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer ce compte ?')">
                    Supprimer
                </button>
            </form>
        </span>
    </li>
    <?php endforeach; ?>
</ul>

<footer>
    <a href="/tvtest/admin/index.php">Retour au Menu</a>
</footer>

</body>
</html>