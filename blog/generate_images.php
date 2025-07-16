<?php
// Inclut la fonction resizeImage() (ajuste le chemin si nécessaire)
require_once 'functions_image.php';

// Définit les dossiers de chaque format d’image
$original_dir = __DIR__ . '/uploads/original/';
$large_dir    = __DIR__ . '/uploads/large/';
$medium_dir   = __DIR__ . '/uploads/medium/';
$thumb_dir    = __DIR__ . '/uploads/thumbnail/';

// Liste tous les fichiers du dossier original
$images = scandir($original_dir);

// Extensions d’image autorisées
$allowed_exts = ['jpg', 'jpeg', 'png', 'webp'];

// Parcourt chaque fichier trouvé
foreach ($images as $image) {
    // Récupère et normalise l’extension du fichier
    $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));

    // Si l’extension est valide, on redimensionne
    if (in_array($ext, $allowed_exts)) {
        // Chemin complet du fichier source
        $source = $original_dir . $image;

        // Crée l’image au format large (800×600)
        resizeImage($source, $large_dir . $image, 800, 600);

        // Crée l’image au format medium (400×300)
        resizeImage($source, $medium_dir . $image, 400, 300);

        // Crée l’image au format thumbnail (150×150)
        resizeImage($source, $thumb_dir . $image, 150, 150);

        // Affiche un message de succès pour ce fichier
        echo "✅ $image traité<br>";
    }
}
