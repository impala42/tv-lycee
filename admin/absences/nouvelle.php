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
    <input type="datetime-local" name="date_debut" required><br><br>

    <label>Date de fin :</label><br>
    <input type="datetime-local" name="date_fin" required><br><br>

    <label>Professeur :</label><br>
    <input type="text" name="professeur" required><br><br>

    <label>Matière :</label><br>
    <input type="text" name="matiere" required><br><br>

    <button type="submit">Ajouter</button>

</form>

</body>
</html>