<?php require '../utilisateurs/auth.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Ajouter un Menu</title>
    <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #3b2a1f, #f3e2c7);
        color: #2b1b12;
    }

    h1 {
        text-align: center;
        color: #4a2c1d;
        margin-top: 20px;
    }

    form {
        max-width: 800px;
        margin: 20px auto;
        background: rgba(255,255,255,0.75);
        padding: 20px;
        border-radius: 14px;
        border: 1px solid #d6b48a;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    section {
        background: rgba(255,255,255,0.6);
        margin: 15px 0;
        padding: 15px;
        border-radius: 12px;
        border: 1px solid #e2c59a;
    }

    label {
        display: block;
        margin: 5px 0;
        font-weight: bold;
        color: #4a2c1d;
    }

    input[type="text"],
    input[type="date"] {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border-radius: 8px;
        border: 1px solid #c4a484;
    }

    input[type="checkbox"] {
        margin-right: 6px;
    }

    button {
        display: block;
        margin: 20px auto;
        background: #8b5a2b;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 10px;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background: #a16207;
    }

    /* 🍗 poulet rôti décoratif */
    body::after {
        content: "🍗";
        position: fixed;
        bottom: 15px;
        right: 15px;
        font-size: 90px;
        opacity: 0.25;
        transform: rotate(-10deg);
        pointer-events: none;
    }

</style>
</head>
<body>
    <h1>Ajouter un Menu</h1>
    <form action="traitement_creer_menu.php" method="POST">

        <!-- Entrée -->
        <section>
            <label for="entree">Entrée :</label>
            <input type="text" id="entree" name="entree" required>

            <label><input type="checkbox" name="e_fait_maison" value="0">Fait maison</label>
            <label><input type="checkbox" name="e_bio" value="0">Bio</label>
            <label><input type="checkbox" name="e_circuit_court" value="0">Circuit Court</label>
            <label><input type="checkbox" name="e_sans_viande" value="0">Sans Viande</label>
        </section>


        <!-- Plat principal -->
        <section>
            <label for="plat">Plat principal :</label>
            <input type="text" id="plat" name="plat" required>

            <label><input type="checkbox" name="p_fait_maison" value="0">Fait maison</label>
            <label><input type="checkbox" name="p_bio" value="0">Bio</label>
            <label><input type="checkbox" name="p_circuit_court" value="0">Circuit Court</label>
            <label><input type="checkbox" name="p_sans_viande" value="0">Sans Viande</label>
        </section>


        <!-- Laitage -->
        <section>
            <label for="laitage">Laitage :</label>
            <input type="text" id="laitage" name="laitage" required>

            <label><input type="checkbox" name="l_fait_maison" value="0">Fait maison</label>
            <label><input type="checkbox" name="l_bio" value="0">Bio</label>
            <label><input type="checkbox" name="l_circuit_court" value="0">Circuit Court</label>
            <label><input type="checkbox" name="l_sans_viande" value="0">Sans Viande</label>
        </section>


        <!-- Dessert -->
        <section>
            <label for="dessert">Dessert :</label>
            <input type="text" id="dessert" name="dessert" required>

            <label><input type="checkbox" name="d_fait_maison" value="0">Fait maison</label>
            <label><input type="checkbox" name="d_bio" value="0">Bio</label>
            <label><input type="checkbox" name="d_circuit_court" value="0">Circuit Court</label>
            <label><input type="checkbox" name="d_sans_viande" value="0">Sans Viande</label>
        </section>

        <label for="date">Saisir la date :</label>
        <input type="date" id="date" name="date" required>

        <button type="submit">Ajouter le menu</button>
    </form>
</body>
</html>