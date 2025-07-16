<?php
session_start(); // Démarre la session pour accéder à $_SESSION

// Vérifie que l’utilisateur est connecté et a le rôle admin ou modérateur
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['administrateur', 'moderateur'])) {
    die('⛔ Accès refusé.'); // Bloque l’accès si l’utilisateur n’est pas autorisé
}
require_once '../config/database.php'; // Connexion à la base de données
require_once 'functions_image.php'; // Fichier contenant la fonction resizeImage()

// Vérifie que tous les champs nécessaires ont bien été envoyés
if (!isset($_POST['titre'], $_POST['contenu'], $_POST['statut'], $_POST['auteur_id'], $_FILES['image'])) {
    die('⛔ Champs requis manquants'); // Si un champ manque, on arrête
}
$titre = htmlspecialchars($_POST['titre']); // Protège le titre contre les failles XSS
$contenu = $_POST['contenu']; // Le contenu est autorisé à contenir du HTML (via TinyMCE)
$statut = $_POST['statut']; // Statut de l’article (ex : "publie", "brouillon")
$auteur_id = (int) $_POST['auteur_id']; // Force l’ID en entier pour éviter les injections

// Vérifie que l’ID de l’auteur est positif
if ($auteur_id <= 0) {
    die('⛔ ID auteur invalide');
}

$image_name = $_FILES['image']['name']; // Nom original du fichier
$image_tmp = $_FILES['image']['tmp_name']; // Chemin temporaire du fichier
$image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION)); // Extension en minuscule
$allowed_exts = ['jpg', 'jpeg', 'png', 'webp']; // Extensions autorisées

// Si l'extension ne fait pas partie de la liste, on bloque l'upload
if (!in_array($image_ext, $allowed_exts)) {
    die('⛔ Format d’image non autorisé');
}

// 📁 Création des dossiers si besoin
$base_path = __DIR__ . '/uploads'; // Dossier de base pour les images

// Si le dossier de base n’existe pas, on le crée
if (!is_dir($base_path)) mkdir($base_path);

// Liste des sous-dossiers à créer pour les différentes tailles d’images
$folders = ['original', 'large', 'medium', 'thumbnail'];

foreach ($folders as $folder) {
    // Crée chaque dossier s'il n'existe pas encore
    if (!is_dir("$base_path/$folder")) {
        mkdir("$base_path/$folder", 0755, true);
    }
}

// 📌 Génère un nom de fichier unique
$new_filename = uniqid() . '.' . $image_ext; // Génère un nom unique pour l’image

$original_path = "$base_path/original/$new_filename"; // Chemin de l’image originale

// Déplace l’image envoyée vers le dossier 'original'
if (!move_uploaded_file($image_tmp, $original_path)) {
    die('⛔ Échec de l’upload de l’image'); // Si le déplacement échoue, on bloque
}
// 📏 Redimensionnement des images
$large_path = "$base_path/large/$new_filename"; // Destination de l’image large
$medium_path = "$base_path/medium/$new_filename"; // Destination image moyenne
$thumb_path = "$base_path/thumbnail/$new_filename"; // Destination miniature

// Redimensionne l’image d’origine en 3 tailles différentes
resizeImage($original_path, $large_path, 800, 600);   // Grande
resizeImage($original_path, $medium_path, 400, 300);  // Moyenne
resizeImage($original_path, $thumb_path, 150, 150);   // Miniature;

// 💾 Insertion en base de données
try {
    // Prépare la requête d’insertion avec les chemins d’image
    $stmt = $pdo->prepare("INSERT INTO articles (
        titre, contenu, auteur_id, statut,
        image_originale, image_large, image_medium, image_thumbnail
    ) VALUES (
        :titre, :contenu, :auteur_id, :statut,
        :img_o, :img_l, :img_m, :img_t
    )");

    // Exécute la requête avec les valeurs
    $stmt->execute([
        ':titre'   => $titre,
        ':contenu' => $contenu,
        ':auteur_id' => $auteur_id,
        ':statut' => $statut,
        ':img_o'  => 'uploads/original/' . $new_filename,
        ':img_l'  => 'uploads/large/' . $new_filename,
        ':img_m'  => 'uploads/medium/' . $new_filename,
        ':img_t'  => 'uploads/thumbnail/' . $new_filename
    ]);

    // Si tout se passe bien, redirige vers la page admin avec succès
    header('Location: admin_blog.php?success=1');
    exit();
} catch (PDOException $e) {
    // Affiche l’erreur SQL en cas de problème
    echo "❌ Erreur SQL : " . $e->getMessage();
    exit;
}
