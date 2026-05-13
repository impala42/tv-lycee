<?php
require '../utilisateurs/auth_superadmin.php';
require '../../bdd/db.php';
require '../csrf.php';

$csrf = csrf_generate();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Avancés</title>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #f5f5dc, #e7d8c9);
        color: #2b1b12;
        text-align: center;
    }

    h1 {
        margin-top: 20px;
        color: #7c2d12;
        font-size: 28px;
    }

    /* panneaux */
    .panel {
        max-width: 700px;
        margin: 20px auto;
        background: rgba(255,255,255,0.85);
        border: 2px solid #d6b48a;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }

    .panel h2 {
        color: #92400e;
        margin-bottom: 10px;
    }

    .warning {
        font-size: 30px;
        margin-bottom: 10px;
        /* ❌ plus d’animation */
    }

    p {
        color: #3b2a1f;
        font-size: 14px;
        margin-bottom: 15px;
    }

    button {
        background: #b45309;
        border: none;
        color: white;
        padding: 10px 14px;
        border-radius: 10px;
        cursor: pointer;
        font-weight: bold;
        transition: 0.2s;
    }

    button:hover {
        background: #f59e0b;
        transform: scale(1.05);
    }

    form {
        display: inline;
    }

    /* coins décoratifs (fixes) */
    body::before {
        content: "⚠️";
        position: fixed;
        top: 15px;
        left: 15px;
        font-size: 50px;
        opacity: 0.25;
        transform: rotate(-10deg);
        pointer-events: none;
    }

    body::after {
        content: "⚠️";
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

<h1>⚠️ Avancés ⚠️</h1>

<!-- Infos -->
<div class="panel">
    <div class="warning">⚠️</div>
    <h2>Supprimer les informations trop vieilles</h2>
    <p>Supprime toutes les informations dont la date de fin est inférieure à la date actuelle (tous établissements).</p>

    <form action="suppr_vieilles_infos.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
        <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer ces informations ?')">
            Supprimer les informations
        </button>
    </form>
</div>

<!-- Absences -->
<div class="panel">
    <div class="warning">⚠️</div>
    <h2>Supprimer les absences trop vieilles</h2>
    <p>Supprime toutes les absences dont la date de fin est inférieure à la date actuelle.</p>

    <form action="suppr_vieilles_absences.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
        <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer ces absences ?')">
            Supprimer les absences
        </button>
    </form>
</div>

<!-- Menus -->
<div class="panel">
    <div class="warning">⚠️</div>
    <h2>Supprimer les menus trop vieux</h2>
    <p>Supprime tous les menus dont la date est dépassée.</p>

    <form action="suppr_vieilles_absences.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
        <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer ces menus ?')">
            Supprimer les menus
        </button>
    </form>
</div>

</body>
</html>