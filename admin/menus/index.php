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
$stmt = $pdo->prepare("
    SELECT m.id, e.nom AS entree, p.nom AS plat, l.nom AS laitage, d.nom AS dessert FROM Menu AS m 
    JOIN Plat AS e ON m.id_entree = e.id 
    JOIN Plat AS p ON m.id_plat_principal = p.id
    JOIN Plat AS l ON m.id_laitage = l.id
    JOIN Plat AS d ON m.id_dessert = d.id
    WHERE m.jour = ? "
);
$stmt->execute([$date->format("Y-m-d")]);
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
        <a href="modifier_menu.php?id=<?= $menu["id"] ?>">Modifier ce menu</a>
    <?php endif ?>

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
</body>
</html>