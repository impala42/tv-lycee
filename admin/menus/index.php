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
    <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #3b2a1f, #f3e2c7);
        color: #2b1b12;
        text-align: center;
    }

    h1 {
        color: #4a2c1d;
        margin-top: 20px;
    }

    h2 {
        color: #5a3824;
    }

    a {
        color: #7a4b2a;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        color: #b45309;
    }

    ul {
        list-style: none;
        padding: 0;
        max-width: 500px;
        margin: 20px auto;
    }

    li {
        background: rgba(255,255,255,0.75);
        margin: 8px 0;
        padding: 10px;
        border-radius: 10px;
        border: 1px solid #d6b48a;
    }

    input[type="date"] {
        display: block;
        margin: 10px auto;
        padding: 6px;
        border-radius: 8px;
        border: 1px solid #c4a484;
    }

    button {
        background: #8b5a2b;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 8px;
        cursor: pointer;
    }

    button:hover {
        background: #a16207;
    }

    footer {
        text-align: center;
        margin: 30px 0;
    }

    /* 🍗 cuisse de poulet */
    body::after {
        content: "🍗";
        position: fixed;
        bottom: 15px;
        right: 15px;
        font-size: 80px;
        opacity: 0.25;
        transform: rotate(-15deg);
        pointer-events: none;
    }

    /* 📅 IMPORTANT : on NE TOUCHE PAS structure, juste centrage visuel */
    .cal {
        margin: 20px auto;
        display: inline-block;
    }

    .nav {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 15px;
        margin: 10px 0;
    }

    #output {
        margin-top: 10px;
    }
</style>
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