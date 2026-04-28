<?php 
require '../utilisateurs/auth.php'; 
require '../../bdd/db.php';

$date  = $_GET['date'] ?? '';
$date = DateTimeImmutable::createFromFormat('Y-m-d', $date);

// Si pas de date précisée on prend l'actuel
if (!$date) {
    header('Location: index.php?date='.date("Y-m-d"));
    exit;
}

// Chercher les menus
$id_etab = $_SESSION["id_etablissement"];
$stmt = $pdo->prepare("
    SELECT m.id, e.nom AS entree, p.nom AS plat, l.nom AS laitage, d.nom AS dessert FROM Menu AS m 
    JOIN Plat AS e ON m.id_entree = e.id 
    JOIN Plat AS p ON m.id_plat_principal = p.id
    JOIN Plat AS l ON m.id_laitage = l.id
    JOIN Plat AS d ON m.id_dessert = d.id
    WHERE m.jour = ? AND m.id_etablissement = ?"
);
$stmt->execute([$date->format("Y-m-d"), $id_etab]);
$menu = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Menus</title>
    <link rel="stylesheet" href="style/choix_semaine.css">
</head>
<body>
    <h1>Menus</h1>
    <a href="creer_menu.php">Nouveau Menu</a>
    <h2>
        <a href="index.php?date=<?= $date->modify("-1 day")->format("Y-m-d") ?>"> < </a> 
         Menu du <?= $date->format("d/m") ?> 
        <a href="index.php?date=<?= $date->modify("+1 day")->format("Y-m-d") ?>"> > </a>
    </h2>
    
    <?php if (!$menu) : ?>
        <p>Pas de menu défini pour ce jour.</p>
    <?php else : ?>
        <ul>
            <li> <?= htmlspecialchars($menu['entree']) ?> </li>
            <li> <?= htmlspecialchars($menu['plat']) ?> </li>
            <li> <?= htmlspecialchars($menu['laitage']) ?> </li>
            <li> <?= htmlspecialchars($menu['dessert']) ?> </li>
        </ul>
        <a href="modifier_menu.php?id=<?= $menu["id"] ?>">Modifier ce menu</a><br>
    <?php endif ?>
    
    <label for="datePicker">Voir le menu du  </label>
    <input type="date" id="datePicker" onchange="redirectToDate(this.value)">
    <script>
        function redirectToDate(date) {
            if (date) {
            window.location.href = `index.php?date=${date}`;
            }
        }
    </script>
    
    <?php if ($_SESSION["id_etablissement"] == 1) : // Si c'est au lycée Rudloff ?>
    <h2>Imprimer le menu d'une semaine</h2>
    
    <div class="cal">
    <div class="nav">
        <button id="prev">&#8592;</button>
        <span id="title"></span>
        <button id="next">&#8594;</button>
    </div>
    <div class="grid" id="grid"></div>
    </div>

    <div class="output" id="output">Aucune semaine sélectionnée</div>

    <script src="script/choix_semaine.js"></script>
    <?php endif ?>
    
    <footer><a href="/tvtest/admin/index.php">Retour au Menu</a></footer>
</body>
</html>