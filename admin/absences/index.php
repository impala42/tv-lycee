<?php
require '../utilisateurs/auth.php';
require '../../bdd/db.php';
require '../csrf.php';

$csrf = csrf_generate();

$stmt = $pdo->prepare("SELECT * FROM Absence WHERE id_etablissement = ? ORDER BY date_debut DESC");
$stmt->execute([$_SESSION["id_etablissement"]]);
$absences = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Absences</title>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #7f1d1d, #fef2f2);
        color: #1f1f1f;
        overflow-x: hidden;
    }

    h1 {
        text-align: center;
        margin-top: 30px;
        color: #7f1d1d;
        text-shadow: 0 0 10px rgba(239,68,68,0.2);
    }

    a {
        color: #b91c1c;
        font-weight: 600;
        text-decoration: none;
    }

    a:hover {
        color: #ef4444;
    }

    ul {
        list-style: none;
        padding: 0;
        max-width: 850px;
        margin: auto;
    }

    li {
        background: rgba(255,255,255,0.7);
        margin: 12px 0;
        padding: 15px;
        border-radius: 14px;
        border: 1px solid #fecaca;
        box-shadow: 0 5px 15px rgba(185,28,28,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        backdrop-filter: blur(6px);
    }

    li:hover {
        transform: translateY(-2px);
    }

    button {
        background: #dc2626;
        border: none;
        padding: 8px 12px;
        border-radius: 8px;
        color: white;
        cursor: pointer;
    }

    button:hover {
        background: #b91c1c;
    }

    form {
        display: inline;
    }

    footer {
        text-align: center;
        margin: 40px 0;
    }

    footer a {
        color: #7f1d1d;
    }

    /* 🌞 gros soleils diagonaux */
    body::before,
    body::after {
        content: "☀";
        position: fixed;
        font-size: 120px;
        color: rgba(255, 204, 0, 0.25);
        pointer-events: none;
        z-index: 0;
    }

    body::before {
        top: 10px;
        left: 10px;
        transform: rotate(-15deg);
    }

    body::after {
        bottom: 10px;
        right: 10px;
        transform: rotate(15deg);
    }

</style>
</head>

<body>

<h1>Absences</h1>

<div style="text-align:center; margin-bottom:20px;">
    <a href="nouvelle.php">+ Nouvelle absence</a>
</div>

<ul>
<?php foreach ($absences as $absence): ?>
    <li>
        <span>
            <?= htmlspecialchars($absence['professeur']) ?> - 
            <?= htmlspecialchars($absence['matiere']) ?> - 
            du <?= date("d/m H\hi", strtotime($absence['date_debut'])) ?> 
            au <?= date("d/m H\hi", strtotime($absence['date_fin'])) ?>
        </span>

        <span>
            <a href="modifier_absence.php?id=<?= $absence['id'] ?>">Modifier</a>

            <form action="suppr_absence.php" method="POST">
                <input type="hidden" name="id" value="<?= $absence['id'] ?>">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                <button onclick="return confirm('Supprimer cette absence ?')">
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