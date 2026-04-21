<?php
// Fonction à placer en haut du fichier, avant la transaction
function insererPlat(PDO $pdo, string $nom, int $fm, int $bio, int $cc, int $sv): int {
    $stmt = $pdo->prepare("
        INSERT INTO Plat (nom, fait_maison, bio, circuit_court, sans_viande)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([$nom, $fm, $bio, $cc, $sv]);
    return (int) $pdo->lastInsertId();
}