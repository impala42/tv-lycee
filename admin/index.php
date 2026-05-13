<?php
require "utilisateurs/auth.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Menu</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #fff1f7;
            color: #2b2b2b;
        }

        header {
            background: #ffe4ef;
            padding: 35px 20px 20px 20px;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            color: #9d174d;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            padding: 30px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: #fbcfe8;
            padding: 20px;
            border-radius: 16px;
            text-align: center;
            transition: 0.25s ease;
            box-shadow: 0 6px 14px rgba(0,0,0,0.05);
            border: 1px solid #f9a8d4;
        }

        .card:hover {
            transform: translateY(-5px);
            background: #f9a8d4;
        }

        .card a {
            color: #831843;
            text-decoration: none;
            font-size: 16px;
            display: block;
            font-weight: 600;
        }

        .card a:hover {
            color: #5b0f2a;
        }

        .badge {
            display: inline-block;
            margin-top: 10px;
            font-size: 12px;
            padding: 4px 10px;
            background: #ffe4ef;
            border-radius: 8px;
            color: #9d174d;
        }

        footer {
            text-align: center;
            padding: 20px;
            margin-top: 30px;
        }

        footer a {
            color: #db2777;
            text-decoration: none;
            font-weight: 500;
        }

        footer a:hover {
            color: #9d174d;
            text-decoration: underline;
        }

        /* admin identique aux autres cartes */
        .admin-inline {
            background: #fbcfe8;
        }
        body::before,
body::after {
    content: "✦ ✧ ✦";
    position: fixed;
    font-size: 18px;
    color: #f472b6;
    opacity: 0.8;
    animation: sparkle 2.5s infinite ease-in-out;
    pointer-events: none;
    z-index: 999;
}

/* coin haut gauche */
body::before {
    top: 10px;
    left: 10px;
}

/* coin bas droit */
body::after {
    bottom: 10px;
    right: 10px;
}

    </style>
</head>

<body>

<header>
    Administration - Menu principal
</header>

<div class="container">

    <div class="card">
        <a href="utilisateurs/mon_compte.php">Votre Compte</a>
        <div class="badge">Profil</div>
    </div>

    <div class="card">
        <a href="infos/liste_infos.php">Informations</a>
        <div class="badge">Actualités</div>
    </div>

    <div class="card">
        <a href="tv/liste_tv.php">TVs</a>
        <div class="badge">Affichage</div>
    </div>

    <div class="card">
        <a href="absences/index.php">Absences</a>
        <div class="badge">Gestion élèves</div>
    </div>

    <div class="card">
        <a href="menus/index.php">Menus</a>
        <div class="badge">Cantine</div>
    </div>

    <?php if ($_SESSION["superadmin"] == 1) : ?> 

        <!-- 📌 sous les autres cartes, côte à côte -->
        <div class="card admin-inline">
            <a href="utilisateurs/liste.php">Compte</a>
            <div class="badge">SuperAdmin</div>
        </div>

        <div class="card admin-inline">
            <a href="avances/index.php">Avancés</a>
            <div class="badge">SuperAdmin</div>
        </div>

    <?php endif; ?>

</div>

<footer>
    <a href="/tvtest/admin/index.php">Retour au Menu principal</a>
</footer>

</body>
</html>