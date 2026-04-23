<?php require '../utilisateurs/auth.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Ajouter une absence</title>
</head>
<body>

<h1>Ajouter une absence</h2>

<form action="traitement_nouvelle.php" method="POST">
    
    <label>Date de début :</label><br>
    <label for="jour_complet_debut">Jour complet : </label><input type="checkbox" name="jour_complet_debut" id="jour_complet_debut" checked><br>
    <input type="date" name="jour_debut" id="jour_debut" value="<?= date("Y-m-d") ?>" required>
    <input type="hidden" name="heure_debut" id="heure_debut" value="12:00">
    <input type="hidden" name="date_debut" id="date_debut" value="<?= date("Y-m-d") . 'T00:00' ?>" required><br><br>

    <label>Date de fin :</label><br>
    <label for="jour_complet_fin">Jour complet : </label><input type="checkbox" name="jour_complet_fin" id="jour_complet_fin" checked><br>
    <input type="date" name="jour_fin" id="jour_fin" value="<?= date("Y-m-d") ?>" required>
    <input type="hidden" name="heure_fin" id="heure_fin" value="12:00">
    <input type="hidden" name="date_fin" id="date_fin" value="<?= date("Y-m-d") . 'T23:59' ?>" required><br><br>

    <label>Professeur :</label><br>
    <input type="text" name="professeur" required><br><br>

    <label>Matière :</label><br>
    <input type="text" name="matiere" required><br><br>

    <label>Champ libre :</label><br>
    <input type="text" name="champ_libre" value=""><br><br>

    <button type="submit">Ajouter</button>

</form>

<script src="date_absence.js"></script>

</body>
</html>