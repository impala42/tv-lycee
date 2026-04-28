<?php

function obtenir_id_etablissement($pdo, $token): int {

    if (empty($token)) {
        die('Erreur : le token est obligatoire.');
    }

    // On vérifie que la TV existe
    $stmt = $pdo->prepare("SELECT COUNT(id) AS count, id_etablissement FROM TV WHERE token = :token");
    $stmt->execute([
        ':token' => $token,
    ]);
    $tv = $stmt->fetch();
    $count = $tv["count"];
    $id_etab = $tv["id_etablissement"];
    
    if ($count != 1) {
        die("TV inexistante.");
    }

    return $id_etab;
}