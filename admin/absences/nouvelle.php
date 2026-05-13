<?php require '../utilisateurs/auth.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Admin - Ajouter une absence</title>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #7f1d1d, #fef2f2);
        color: #1f1f1f;
    }

    h1 {
        text-align: center;
        margin-top: 30px;
        color: #7f1d1d;
        text-shadow: 0 0 10px rgba(239,68,68,0.2);
    }

    form {
        max-width: 650px;
        margin: 30px auto;
        background: rgba(255,255,255,0.75);
        padding: 25px;
        border-radius: 16px;
        border: 1px solid #fecaca;
        box-shadow: 0 10px 25px rgba(185,28,28,0.15);
        backdrop-filter: blur(6px);
    }

    label {
        font-weight: 600;
        color: #7f1d1d;
    }

    input[type="text"],
    input[type="date"] {
        width: 100%;
        padding: 10px;
        margin-top: 6px;
        margin-bottom: 15px;
        border-radius: 10px;
        border: 1px solid #fca5a5;
        outline: none;
        background: #fff;
    }

    input[type="checkbox"] {
        transform: scale(1.1);
        margin-right: 6px;
    }

    button {
        width: 100%;
        padding: 12px;
        background: linear-gradient(90deg, #dc2626, #ef4444);
        border: none;
        border-radius: 12px;
        color: white;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(220,38,38,0.3);
        transition: 0.2s;
    }

    button:hover {
        transform: scale(1.02);
        background: linear-gradient(90deg, #b91c1c, #dc2626);
    }

    .section {
        margin-bottom: 15px;
    }

    /* 🌞 soleils décoratifs comme page liste */
    body::before,
    body::after {
        content: "☀";
        position: fixed;
        font-size: 120px;
        color: rgba(255, 200, 0, 0.20);
        pointer-events: none;
    }

    body::before {
        top: 10px;
        left: 10px;
        transform: rotate(-10deg);
    }

    body::after {
        bottom: 10px;
        right: 10px;
        transform: rotate(10deg);
    }

</style>
</head>

<body>

<h1>Ajouter une absence</h1>

<form action="traitement_nouvelle.php" method="POST">

    <div class="section">
        <label>Date de début :</label><br>

        <label for="jour_complet_debut">
            <input type="checkbox" name="jour_complet_debut" id="jour_complet_debut" checked>
            Jour complet
        </label><br>

        <input type="date" name="jour_debut" id="jour_debut" value="<?= date("Y-m-d") ?>" required>
        <input type="hidden" name="heure_debut" id="heure_debut" value="12:00">
        <input type="hidden" name="date_debut" id="date_debut" value="<?= date("Y-m-d") . 'T00:00' ?>" required>
    </div>

    <div class="section">
        <label>Date de fin :</label><br>

        <label for="jour_complet_fin">
            <input type="checkbox" name="jour_complet_fin" id="jour_complet_fin" checked>
            Jour complet
        </label><br>

        <input type="date" name="jour_fin" id="jour_fin" value="<?= date("Y-m-d") ?>" required>
        <input type="hidden" name="heure_fin" id="heure_fin" value="12:00">
        <input type="hidden" name="date_fin" id="date_fin" value="<?= date("Y-m-d") . 'T23:59' ?>" required>
    </div>

    <div class="section">
        <label>Professeur :</label><br>
        <input type="text" name="professeur" required>
    </div>

    <div class="section">
        <label>Matière :</label><br>
        <input type="text" name="matiere" required>
    </div>

    <div class="section">
        <label>Champ libre :</label><br>
        <input type="text" name="champ_libre">
    </div>

    <button type="submit">Ajouter l'absence</button>

</form>

<script src="date_absence.js"></script>

</body>
</html>