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
    <title>Admin - Modifier une absence</title>
</head>
<body>

<h1>Modifier une absence</h1>

<form action="traitement_modifier_absence.php" method="POST">

    <!-- On transmet l'ID dans un champ caché -->
    <input type="hidden" name="id" value="<?= $absence['id'] ?>">
    
    <label>Date de début :</label><br>
    <label for="jour_complet_debut">Jour complet : </label><input type="checkbox" name="jour_complet_debut" id="jour_complet_debut" <?= $date_debut_jour_complet ? "checked" : "" ?> ><br>
    <input type="date" name="jour_debut" id="jour_debut" value="<?= date("Y-m-d", $debut_absence) ?>" required>
    <input type="<?=$date_debut_jour_complet ? "hidden" : "time" ?>" name="heure_debut" id="heure_debut" value="<?= date("H:i", $debut_absence) ?>">
    <input type="hidden" name="date_debut" id="date_debut" value="<?= date("Y-m-d\TH:i", $debut_absence) ?>" required><br><br>

    <label>Date de fin :</label><br>
    <label for="jour_complet_fin">Jour complet : </label><input type="checkbox" name="jour_complet_fin" id="jour_complet_fin" <?= $date_fin_jour_complet == "23:59" ? "checked" : "" ?> ><br>
    <input type="date" name="jour_fin" id="jour_fin" value="<?= date("Y-m-d", $fin_absence) ?>" required>
    <input type="<?=$date_fin_jour_complet ? "hidden" : "time" ?>" name="heure_fin" id="heure_fin" value="<?= date("H:i", $fin_absence) ?>">
    <input type="hidden" name="date_fin" id="date_fin" value="<?= date("Y-m-d\TH:i", $fin_absence) ?>" required><br><br>

    <label>Professeur :</label><br>
    <input type="text" name="professeur" required value="<?= $absence['professeur'] ?>"><br><br>

    <label>Matière :</label><br>
    <input type="text" name="matiere" required value="<?= $absence['matiere'] ?>"><br><br>

    <label>Champ libre :</label><br>
    <input type="text" name="champ_libre" required value="<?= $absence['champ_libre'] ?> "><br><br>

    <button type="submit">Modifier</button>

</form>

<script src="date_absence.js"></script>

</body>
</html>