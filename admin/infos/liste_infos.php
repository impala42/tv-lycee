<?php
require '../utilisateurs/auth.php';
require '../../bdd/db.php';
require '../csrf.php';

$id_etab = $_SESSION['id_etablissement'];

$stmt = $pdo->prepare("
    SELECT titre, id 
    FROM Information 
    WHERE id IN (
        SELECT id_info FROM AffichageInfo WHERE id_tv IN (
            SELECT id FROM TV WHERE id_etablissement = ?
        )
    )
    ORDER BY date_debut DESC;
");

$stmt->execute([$id_etab]);
$infos = $stmt->fetchAll();

$csrf = csrf_generate();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Informations</title>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #2e1065, #4c1d95);
        color: #f5f3ff;
        overflow-x: hidden;
    }

    h1 {
        text-align: center;
        margin-top: 30px;
        color: #ede9fe;
        text-shadow: 0 0 10px rgba(196,181,253,0.5);
    }

    a {
        color: #c4b5fd;
        text-decoration: none;
        font-weight: 600;
    }

    a:hover {
        color: #f5d0fe;
    }

    /* bouton création */
    .create {
        display: block;
        text-align: center;
        margin: 20px auto;
        width: fit-content;
        padding: 10px 18px;
        background: #7c3aed;
        border-radius: 10px;
        color: white;
        box-shadow: 0 0 15px rgba(124,58,237,0.4);
    }

    ul {
        list-style: none;
        padding: 0;
        max-width: 800px;
        margin: auto;
    }

    li {
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(8px);
        margin: 12px 0;
        padding: 15px;
        border-radius: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid rgba(196,181,253,0.3);
        box-shadow: 0 0 15px rgba(124,58,237,0.2);
    }

    button {
        background: #a855f7;
        border: none;
        padding: 8px 12px;
        border-radius: 8px;
        color: white;
        cursor: pointer;
        margin-left: 10px;
    }

    button:hover {
        background: #9333ea;
    }

    form {
        display: inline;
    }

    footer {
        text-align: center;
        margin: 40px 0;
    }

    footer a {
        color: #c4b5fd;
    }

    /* 🌸 fleurs décoratives */
    body::before,
    body::after {
        content: "✿ ❀ ✿";
        position: fixed;
        font-size: 22px;
        color: #d8b4fe;
        opacity: 0.5;
        pointer-events: none;
        animation: float 6s infinite ease-in-out;
    }

    body::before {
        top: 20px;
        left: 20px;
    }

    body::after {
        bottom: 20px;
        right: 20px;
    }


</style>
</head>

<body>

<h1>Mes Informations</h1>

<a class="create" href="creer_info.php">+ Nouvelle information</a>

<ul>
    <?php foreach ($infos as $info): ?>
        <li>
            <span><?= htmlspecialchars($info['titre']) ?></span>

            <span>
                <a href="modifier_info.php?id=<?= $info['id'] ?>">Modifier</a>

                <form action="suppr_info.php" method="POST">
                    <input type="hidden" name="id" value="<?= $info['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                    <button onclick="return confirm('Supprimer cette information ?')">
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