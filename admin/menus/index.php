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

    <script>
    const MONTHS = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
    const fmt = d => `${d.getFullYear()}-${String(d.getMonth()+1).padStart(2,'0')}-${String(d.getDate()).padStart(2,'0')}`;

    let year, month;
    let selectedMonday = null, selectedFriday = null;

    function getMonday(d) {
        const c = new Date(d); c.setHours(0,0,0,0);
        const day = c.getDay();
        c.setDate(c.getDate() - (day === 0 ? 6 : day - 1));
        return c;
    }

    function build() {
        document.getElementById('title').textContent = `${MONTHS[month]} ${year}`;
        const grid = document.getElementById('grid');
        grid.innerHTML = '<div class="hd">Lu</div><div class="hd">Ma</div><div class="hd">Me</div><div class="hd">Je</div><div class="hd">Ve</div><div class="hd">Sa</div><div class="hd">Di</div>';

        const today = new Date(); today.setHours(0,0,0,0);
        let cur = getMonday(new Date(year, month, 1));

        for (let r = 0; r < 6; r++) {
        const mon = new Date(cur);
        const fri = new Date(cur); fri.setDate(fri.getDate() + 4);
        if (r > 0 && cur.getMonth() > month) break;

        const row = document.createElement('div');
        row.className = 'week' + (selectedMonday && mon.toDateString() === selectedMonday.toDateString() ? ' selected' : '');
        row.style.cssText = 'display:contents;cursor:pointer';

        for (let d = 0; d < 7; d++) {
            const cell = document.createElement('div');
            cell.className = 'day' + (cur.getMonth() !== month ? ' other' : '') + (cur.toDateString() === today.toDateString() ? ' today' : '');
            cell.textContent = cur.getDate();
            row.appendChild(cell);
            cur.setDate(cur.getDate() + 1);
        }

        row.addEventListener('click', () => {
            selectedMonday = mon; selectedFriday = fri;
            build(); updateOutput();
        });
        grid.appendChild(row);
        }
    }

    function updateOutput() {
        document.getElementById('output').textContent = selectedMonday
        ? `Lundi : ${fmt(selectedMonday)}   —   Vendredi : ${fmt(selectedFriday)}`
        : 'Aucune semaine sélectionnée';
        
        // On redirige vers l'impression
        open(`imprimer/menu_hebdo.php?date_debut=${fmt(selectedMonday)}"&date_fin=${fmt(selectedFriday)}`);
    }

    document.getElementById('prev').onclick = () => { if (--month < 0) { month = 11; year--; } build(); };
    document.getElementById('next').onclick = () => { if (++month > 11) { month = 0; year++; } build(); };

    const now = new Date(); year = now.getFullYear(); month = now.getMonth();
    build();

    window.weekPicker = {
        getMonday: () => selectedMonday ? fmt(selectedMonday) : null,
        getFriday: () => selectedFriday ? fmt(selectedFriday) : null,
    };
    </script>
</body>
</html>