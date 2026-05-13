<?php
require '../utilisateurs/auth.php';
require '../../bdd/db.php';

// Récupération de l'article à modifier
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) die('ID invalide.');

$stmt = $pdo->prepare('SELECT * FROM Absence WHERE id = ?');
$stmt->execute([$id]);
$absence = $stmt->fetch();

$debut_absence = strtotime($absence["date_debut"]);
$fin_absence = strtotime($absence["date_fin"]);

$date_debut_jour_complet = date("H:i", $debut_absence) == "00:00";
$date_fin_jour_complet = date("H:i", $fin_absence) == "23:59";

if (!$absence) die('Absence introuvable.');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Modifier une absence</title>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #ea580c, #fde68a);
        color: #3b1d0f;
    }

    h1 {
        text-align: center;
        margin-top: 25px;
        color: #b45309;
        text-shadow: 0 0 12px rgba(251,191,36,0.4);
    }

    form {
        max-width: 700px;
        margin: 25px auto;
        background: rgba(255,255,255,0.88);
        padding: 25px;
        border-radius: 18px;
        border: 2px solid #fdba74;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);

        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    label {
        font-weight: bold;
        color: #9a3412;
    }

    input[type="text"],
    input[type="date"],
    input[type="time"] {
        padding: 10px;
        border-radius: 10px;
        border: 1px solid #fdba74;
        outline: none;
        font-size: 14px;
    }

    input:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 8px rgba(251,191,36,0.4);
    }

    input[type="checkbox"] {
        transform: scale(1.15);
        margin-left: 6px;
    }

    button {
        background: #ea580c;
        color: white;
        border: none;
        padding: 12px;
        border-radius: 12px;
        cursor: pointer;
        font-weight: bold;
        font-size: 15px;
        transition: 0.2s;
    }

    button:hover {
        background: #f59e0b;
        transform: scale(1.03);
    }

    /* ☀️ soleils décoratifs */
    body::before {
        content: "☀️";
        position: fixed;
        top: 20px;
        left: 20px;
        font-size: 70px;
        opacity: 0.25;
        pointer-events: none;
    }

    body::after {
        content: "☀️";
        position: fixed;
        bottom: 20px;
        right: 20px;
        font-size: 80px;
        opacity: 0.25;
        pointer-events: none;
    }
</style>
</head>

<body>

<h1>Modifier une absence</h1>

<form action="traitement_modifier_absence.php" method="POST">

    <!-- ID caché -->
    <input type="hidden" name="id" value="<?= $absence['id'] ?>">

    <label>Date de début :</label>

    <label for="jour_complet_debut">
        Jour complet :
        <input 
            type="checkbox" 
            name="jour_complet_debut" 
            id="jour_complet_debut"
            <?= $date_debut_jour_complet ? "checked" : "" ?>
        >
    </label>

    <input 
        type="date" 
        name="jour_debut" 
        id="jour_debut"
        value="<?= date("Y-m-d", $debut_absence) ?>" 
        required
    >

    <input 
        type="<?= $date_debut_jour_complet ? "hidden" : "time" ?>"
        name="heure_debut" 
        id="heure_debut"
        value="<?= date("H:i", $debut_absence) ?>"
    >

    <input 
        type="hidden" 
        name="date_debut" 
        id="date_debut"
        value="<?= date("Y-m-d\TH:i", $debut_absence) ?>" 
        required
    >

    <label>Date de fin :</label>

    <label for="jour_complet_fin">
        Jour complet :
        <input 
            type="checkbox" 
            name="jour_complet_fin" 
            id="jour_complet_fin"
            <?= $date_fin_jour_complet ? "checked" : "" ?>
        >
    </label>

    <input 
        type="date" 
        name="jour_fin" 
        id="jour_fin"
        value="<?= date("Y-m-d", $fin_absence) ?>" 
        required
    >

    <input 
        type="<?= $date_fin_jour_complet ? "hidden" : "time" ?>"
        name="heure_fin" 
        id="heure_fin"
        value="<?= date("H:i", $fin_absence) ?>"
    >

    <input 
        type="hidden" 
        name="date_fin" 
        id="date_fin"
        value="<?= date("Y-m-d\TH:i", $fin_absence) ?>" 
        required
    >

    <label>Professeur :</label>
    <input 
        type="text" 
        name="professeur"
        required
        value="<?= htmlspecialchars($absence['professeur']) ?>"
    >

    <label>Matière :</label>
    <input 
        type="text" 
        name="matiere"
        required
        value="<?= htmlspecialchars($absence['matiere']) ?>"
    >

    <label>Champ libre :</label>
    <input 
        type="text" 
        name="champ_libre"
        value="<?= htmlspecialchars($absence['champ_libre']) ?>"
    >

    <button type="submit">
        Modifier
    </button>

</form>

<script src="date_absence.js"></script>

</body>
</html>