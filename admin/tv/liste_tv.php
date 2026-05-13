<?php
require '../utilisateurs/auth.php';
require '../../bdd/db.php';

$stmt = $pdo->prepare("SELECT * FROM TV WHERE id_etablissement = ?");
$stmt->execute([$_SESSION["id_etablissement"]]);
$infos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - TV</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #eaf2ff;
            color: #1e2a44;
        }

        h1, h2 {
            text-align: center;
            color: #1e3a8a;
            margin-top: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
            max-width: 800px;
            margin: auto;
        }

        li {
            background: #dbeafe;
            margin: 10px 0;
            padding: 15px;
            border-radius: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            border: 1px solid #bfdbfe;
        }

        li span:first-child {
            font-weight: 600;
            color: #1e3a8a;
        }

        li a {
            text-decoration: none;
            color: #1e3a8a;
            font-weight: 600;
            margin-left: 10px;
        }

        li a:hover {
            color: #2563eb;
        }

        form {
            max-width: 400px;
            margin: 30px auto;
            background: #dbeafe;
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            border: 1px solid #bfdbfe;
            text-align: center;
        }

        input {
            width: 90%;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #93c5fd;
            margin-bottom: 10px;
            outline: none;
        }

        button {
            background: #93c5fd;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            color: #1e3a8a;
        }

        button:hover {
            background: #60a5fa;
        }

        footer {
            text-align: center;
            margin: 30px 0;
        }

        footer a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* 🐢 TORTUE ORIGINALE */
        .turtle {
            position: fixed;
            bottom: 15px;
            left: 15px;
            font-size: 60px;
            opacity: 0.95;
            pointer-events: none;
        }
    </style>
</head>

<body>

<!-- 🐢 première tortue -->
<div class="turtle">🐢</div>

<h1>Mes TV</h1>

<ul>
<?php foreach ($infos as $info): ?>
    <li>
        <span><?= htmlspecialchars($info['nom']) ?></span>
        <span>
            <a target="_blank" href="../../frontend/index.html?token=<?= htmlspecialchars($info['token']) ?>">Ouvrir</a>
            <a href="modifier_tv.php?id=<?= htmlspecialchars($info["id"]) ?>">Modifier</a>
        </span>
    </li>
<?php endforeach; ?>
</ul>

<h2>Créer une nouvelle TV</h2>

<form action="traitement_creer_tv.php" method="POST">
    <input type="text" name="nom" placeholder="Nom de la TV" required>
    <button type="submit">Créer</button>
</form>

<footer>
    <a href="/tvtest/admin/index.php">Retour au Menu</a>
</footer>

</body>
</html>