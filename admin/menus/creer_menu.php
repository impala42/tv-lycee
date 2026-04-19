<?php require '../utilisateurs/auth.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Ajouter un Menu</title>
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