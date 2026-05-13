<?php 
require '../utilisateurs/auth.php'; 
require '../../bdd/db.php';

// Récupération de l'article à modifier
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) die('ID invalide.');

$stmt = $pdo->prepare("
    SELECT * FROM Menu
    WHERE id = ? "
);
$stmt->execute([$id]);
$menu = $stmt->fetch();

if (!$menu) die ('ID inexistant');

$stmt = $pdo->prepare("
    SELECT * FROM Plat
    WHERE id = ? "
);
$stmt->execute([$menu["id_entree"]]);
$entree = $stmt->fetch();

$stmt = $pdo->prepare("
    SELECT * FROM Plat
    WHERE id = ? "
);
$stmt->execute([$menu["id_plat_principal"]]);
$plat = $stmt->fetch();

$stmt = $pdo->prepare("
    SELECT * FROM Plat
    WHERE id = ? "
);
$stmt->execute([$menu["id_laitage"]]);
$laitage = $stmt->fetch();

$stmt = $pdo->prepare("
    SELECT * FROM Plat
    WHERE id = ? "
);
$stmt->execute([$menu["id_dessert"]]);
$dessert = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Modifier un Menu</title>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #5c3b1e, #b08968);
        color: #fff8f0;
    }

    h1 {
        text-align: center;
        margin-top: 25px;
        color: #ffe0b2;
        text-shadow: 0 0 12px rgba(255, 210, 140, 0.4);
    }

    form {
        max-width: 850px;
        margin: 30px auto;
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(4px);
        padding: 25px;
        border-radius: 20px;
        border: 2px solid rgba(255,255,255,0.15);
        box-shadow: 0 8px 20px rgba(0,0,0,0.25);

        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    section {
        background: rgba(255,255,255,0.08);
        padding: 18px;
        border-radius: 16px;
        border: 1px solid rgba(255,255,255,0.1);

        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    label {
        font-weight: bold;
        color: #fff1dc;
    }

    input[type="text"],
    input[type="date"] {
        padding: 10px;
        border-radius: 10px;
        border: none;
        outline: none;
        font-size: 14px;
        background: rgba(255,255,255,0.9);
        color: #5c3b1e;
    }

    input[type="checkbox"] {
        transform: scale(1.1);
        margin-right: 6px;
    }

    button {
        background: #8b4513;
        color: white;
        border: none;
        padding: 14px;
        border-radius: 12px;
        cursor: pointer;
        font-size: 15px;
        font-weight: bold;
        transition: 0.2s;
    }

    button:hover {
        background: #a65f2d;
        transform: scale(1.02);
    }

    /* 🍗 cuisse de poulet décorative */
    body::after {
        content: "🍗";
        position: fixed;
        bottom: 20px;
        right: 25px;
        font-size: 110px;
        opacity: 0.18;
        pointer-events: none;
    }
</style>
</head>

<body>

<h1>Modifier le Menu</h1>

<form action="traitement_modif_menu.php" method="POST">

    <!-- ID menu -->
    <input type="hidden" name="id" value="<?= $id ?>">

    <!-- Entrée -->
    <section>

        <input type="hidden" name="id_entree" value="<?= $entree['id'] ?>">

        <label for="entree">Entrée :</label>
        <input 
            type="text" 
            id="entree" 
            name="entree"
            required
            value="<?= htmlspecialchars($entree["nom"]) ?>"
        >

        <label><input type="checkbox" name="e_fait_maison" <?= ($entree["fait_maison"] == 1 ) ? "checked" : ""?> >Fait maison</label>

        <label><input type="checkbox" name="e_bio" <?= ($entree["bio"] == 1 ) ? "checked" : ""?> >Bio</label>

        <label><input type="checkbox" name="e_circuit_court" <?= ($entree["circuit_court"] == 1 ) ? "checked" : "" ?> >Circuit Court</label>

        <label><input type="checkbox" name="e_sans_viande" <?= ($entree["sans_viande"] == 1 ) ? "checked" : "" ?> >Sans Viande</label>

    </section>

    <!-- Plat principal -->
    <section>

        <input type="hidden" name="id_plat" value="<?= $plat['id'] ?>">

        <label for="plat">Plat principal :</label>

        <input 
            type="text" 
            id="plat" 
            name="plat"
            required
            value="<?= htmlspecialchars($plat["nom"]) ?>"
        >

        <label><input type="checkbox" name="p_fait_maison" <?= ($plat["fait_maison"] == 1 ) ? "checked" : ""?> >Fait maison</label>

        <label><input type="checkbox" name="p_bio" <?= ($plat["bio"] == 1)  ? "checked" : ""?> >Bio</label>

        <label><input type="checkbox" name="p_circuit_court" <?= ($plat["circuit_court"] == 1 ) ? "checked" : ""?> >Circuit Court</label>

        <label><input type="checkbox" name="p_sans_viande" <?= ($plat["sans_viande"] == 1 ) ? "checked" : ""?> >Sans Viande</label>

    </section>

    <!-- Laitage -->
    <section>

        <input type="hidden" name="id_laitage" value="<?= $laitage['id'] ?>">

        <label for="laitage">Laitage :</label>

        <input 
            type="text" 
            id="laitage" 
            name="laitage"
            value="<?= htmlspecialchars($laitage["nom"]) ?>"
            required
        >

        <label><input type="checkbox" name="l_fait_maison" <?= ($laitage["fait_maison"] == 1) ? "checked" : ""?> >Fait maison</label>

        <label><input type="checkbox" name="l_bio" <?= ($laitage["bio"] == 1 ) ? "checked" : ""?> >Bio</label>

        <label><input type="checkbox" name="l_circuit_court" <?= ($laitage["circuit_court"] == 1 ) ? "checked" : ""?> >Circuit Court</label>

        <label><input type="checkbox" name="l_sans_viande" <?= ($laitage["sans_viande"] == 1 ) ? "checked" : ""?> >Sans Viande</label>

    </section>

    <!-- Dessert -->
    <section>

        <input type="hidden" name="id_dessert" value="<?= $dessert['id'] ?>">

        <label for="dessert">Dessert :</label>

        <input 
            type="text" 
            id="dessert" 
            name="dessert"
            value="<?= htmlspecialchars($dessert["nom"]) ?>"
            required
        >

        <label><input type="checkbox" name="d_fait_maison" <?= ($dessert["fait_maison"] == 1 ) ? "checked" : ""?> >Fait maison</label>

        <label><input type="checkbox" name="d_bio" <?= ($dessert["bio"] == 1 ) ? "checked" : ""?> >Bio</label>

        <label><input type="checkbox" name="d_circuit_court" <?= ($dessert["circuit_court"] == 1 ) ? "checked" : ""?> >Circuit Court</label>

        <label><input type="checkbox" name="d_sans_viande" <?= ($dessert["sans_viande"] == 1 ) ? "checked" : ""?> >Sans Viande</label>

    </section>

    <label for="date">Saisir la date :</label>

    <input 
        type="date" 
        id="date" 
        name="date"
        value="<?= $menu["jour"] ?>"
        required
    >

    <button type="submit">
        Modifier le menu
    </button>

</form>

</body>
</html>