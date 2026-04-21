<?php
require '../utilisateurs/auth.php';
require '../../bdd/db.php';
require '../csrf.php';

$csrf = csrf_generate();

$stmt = $pdo->prepare("SELECT * FROM Absence");
$stmt->execute();
$absences = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Absences</title>
</head>
<body>
    <h1>Absences</h1>
    <a href="nouvelle.php">Nouvelle Absence</a>
    <ul>
        <?php foreach ($absences as $absence): ?>
        <li>
            <?= htmlspecialchars($absence['professeur']) ?> - du <?= date("d/m H\hi", strtotime($absence['date_debut'])) ?> au <?= date("d/m H\hi", strtotime($absence['date_fin'])) ?>
            <a href="modifier_absence.php?id=<?= $absence['id'] ?>">Modifier</a>
            <!-- Supprimer l'absence -->
            <form action="suppr_absence.php" method="POST" style="display:inline">
                <input type="hidden" name="id"         value="<?= $absence['id'] ?>">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                <button type="submit"
                        onclick="return confirm('Supprimer cette absence ?')">
                    Supprimer
                </button>
            </form>
        </li>
    <?php endforeach; ?>
    </ul>
    <footer><a href="/tvtest/admin/index.php">Retour au Menu</a></footer>
</body>
</html>