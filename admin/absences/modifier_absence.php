<?php
require '../utilisateurs/auth.php';
require '../../bdd/db.php';

// Récupération de l'article à modifier
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) die('ID invalide.');

$stmt = $pdo->prepare('SELECT * FROM Absence WHERE id = ?');
$stmt->execute([$id]);
$absence = $stmt->fetch();

if (!$absence) die('Absence introuvable.');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Modifier une absence</title>
</head>
<body>

<h1>Modifier une absence</h2>

<form action="traitement_modifier_absence.php" method="POST">

    <!-- On transmet l'ID dans un champ caché -->
    <input type="hidden" name="id" value="<?= $absence['id'] ?>">
    
    <label>Date de début :</label><br>
    <input type="datetime-local" name="date_debut" required value="<?= $absence['date_debut'] ?>"><br><br>

    <label>Date de fin :</label><br>
    <input type="datetime-local" name="date_fin" required value="<?= $absence['date_fin'] ?>"><br><br>

    <label>Professeur :</label><br>
    <input type="text" name="professeur" required value="<?= $absence['professeur'] ?>"><br><br>

    <label>Matière :</label><br>
    <input type="text" name="matiere" required value="<?= $absence['matiere'] ?>"><br><br>

    <label>Champ libre :</label><br>
    <input type="text" name="champ_libre" required value="<?= $absence['champ_libre'] ?>"><br><br>

    <button type="submit">Modifier</button>

</form>

</body>
</html>