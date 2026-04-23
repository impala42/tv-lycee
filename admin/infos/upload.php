<?php

function uploadFichier(array $file, string $uploadDir, array $allowedExtensions = [], array $allowedMimes = [], int $maxSize = 2097152): array
{
    // Vérification erreur upload
    if (!isset($file) || $file['error'] !== 0) {
        return ['success' => false, 'message' => "Erreur lors de l'upload."];
    }

    // Vérification taille
    if ($file['size'] > $maxSize) {
        return ['success' => false, 'message' => "Fichier trop volumineux."];
    }

    // Extension
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!empty($allowedExtensions) && !in_array($extension, $allowedExtensions)) {
        return ['success' => false, 'message' => "Extension non autorisée."];
    }

    // MIME réel (sécurisé)
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);

    if (!empty($allowedMimes) && !in_array($mime, $allowedMimes)) {
        return ['success' => false, 'message' => "Type MIME non autorisé."];
    }

    // Nom sécurisé unique
    $newName = bin2hex(random_bytes(16)) . "." . $extension;

    // Sécurisation du dossier
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $destination = rtrim($uploadDir, '/') . '/' . $newName;

    // Déplacement
    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        return ['success' => false, 'message' => "Impossible de déplacer le fichier."];
    }

    return [
        'success' => true,
        'message' => "Upload réussi",
        'filename' => $newName,
        'mime' => $mime,
        'size' => $file['size']
    ];
}