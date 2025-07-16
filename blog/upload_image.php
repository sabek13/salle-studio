<?php
// Vérifie qu’un fichier a bien été envoyé et qu’il n’y a pas d’erreur
if (!isset($_FILES['file']) || $_FILES['file']['error'] !== 0) {
    // Renvoie un code HTTP 400 (Bad Request)
    http_response_code(400);
    // Retourne un message JSON d’erreur
    echo json_encode(['error' => 'Fichier non valide']);
    exit; // Arrête l’exécution
}

// Liste des extensions autorisées par le nom de fichier
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

// Liste des types MIME autorisés (vérification du contenu)
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

// Ouvre un analyseur MIME pour le fichier temporaire
$finfo = finfo_open(FILEINFO_MIME_TYPE);
// Lit le type MIME réel du fichier
$mimeType = finfo_file($finfo, $_FILES['file']['tmp_name']);
// Ferme l’analyseur MIME
finfo_close($finfo);

// Si le type MIME n’est pas dans la liste autorisée, on bloque
if (!in_array($mimeType, $allowedMimeTypes)) {
    http_response_code(400);
    echo json_encode(['error' => 'Type de fichier non autorisé']);
    exit;
}

// Récupère l’extension du nom original et la passe en minuscules
$extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
// Si l’extension n’est pas dans la liste, on bloque
if (!in_array($extension, $allowedExtensions)) {
    http_response_code(400);
    echo json_encode(['error' => 'Extension non autorisée']);
    exit;
}

// Définit le dossier de destination des uploads
$uploadDir = __DIR__ . '/../blog/uploads/';
// Crée le dossier si nécessaire avec des permissions sécurisées
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Génère un nom de fichier unique pour éviter les collisions
$filename = uniqid('img_', true) . '.' . $extension;
// Construit le chemin complet où stocker le fichier
$filepath = $uploadDir . $filename;

// Déplace le fichier depuis le dossier temporaire vers le dossier cible
if (move_uploaded_file($_FILES['file']['tmp_name'], $filepath)) {
    // Construit l’URL publique pour accéder à l’image
    $url = '/php_le-studio-sport/blog/uploads/' . $filename;
    // Retourne l’URL au format JSON attendu par TinyMCE
    echo json_encode(['location' => $url]);
} else {
    // En cas d’échec de déplacement, on renvoie une erreur 500
    http_response_code(500);
    echo json_encode(['error' => 'Échec de l’envoi']);
}
