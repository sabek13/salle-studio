<?php
session_start(); // Démarre la session utilisateur

// Vérifie que l’utilisateur est connecté et a un rôle autorisé
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['administrateur', 'moderateur'])) {
    die('⛔ Accès refusé.'); // Bloque l’accès si non autorisé
}

// Connexion à la base de données
require_once '../config/database.php';

// Vérifie que l’ID de l’article est passé et bien numérique
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die('ID d\'article invalide.'); // Stoppe le script si l’ID est incorrect
}

$id = (int)$_GET['id']; // Convertit l’ID en entier pour plus de sécurité

// Prépare une requête pour récupérer le titre de l’article
$stmt = $pdo->prepare("SELECT titre FROM articles WHERE id_article = :id");
$stmt->execute([':id' => $id]); // Exécute avec l’ID
$article = $stmt->fetch(PDO::FETCH_ASSOC); // Récupère le titre

// Si l’article n’existe pas, affiche une erreur
if (!$article) die('Article introuvable.');

// Si le formulaire est soumis (POST), on supprime l’article
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("DELETE FROM articles WHERE id_article = :id"); // Prépare la suppression
    $stmt->execute([':id' => $id]); // Exécute la requête
    header('Location: ../admin.php?tab=blog&success=delete'); // Redirige vers le dashboard avec un message
    exit(); // Stoppe le script après redirection
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer l'article</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/custom-theme.css" rel="stylesheet">
    <style>
        body {
            background: #f8f8f8;
        }

        .delete-container {
            max-width: 500px;
            margin: 60px auto;
            background: #fff;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-soft);
            padding: 2.5rem 2rem 2rem 2rem;
            text-align: center;
        }

        .section-title {
            font-size: 2rem;
            font-family: 'Bebas Neue', sans-serif;
            text-transform: uppercase;
            color: var(--danger-color);
            position: relative;
            margin-bottom: 0.5rem;
        }

        .section-title:after {
            content: '';
            display: block;
            width: 3rem;
            height: 0.3rem;
            background: var(--primary-color);
            border-radius: 2rem;
            margin: 0.5rem 0 0 0;
        }

        .btn-gold {
            background: var(--primary-color);
            color: #fff;
            border-radius: var(--radius-sm);
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.1rem;
            letter-spacing: 1px;
            border: none;
            padding: 0.6rem 1.5rem;
            transition: background 0.2s;
        }

        .btn-gold:hover {
            background: var(--primary-color-hover);
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="delete-container"> <!-- Boîte principale -->

        <!-- Titre de la section -->
        <div class="section-title mb-3">
            <i class="fas fa-trash me-2"></i>Supprimer l'article
        </div>

        <!-- Message de confirmation avec nom de l’article -->
        <p class="mb-4">
            Voulez-vous vraiment supprimer l'article
            <strong><?= htmlspecialchars($article['titre']) ?></strong> ?
            <br>
            <span class="text-danger">Cette action est irréversible.</span>
        </p>

        <!-- Formulaire de suppression -->
        <form method="POST">
            <!-- Bouton de validation -->
            <button type="submit" class="btn btn-gold me-2">
                <i class="fas fa-trash me-1"></i> Supprimer
            </button>

            <!-- Lien pour annuler -->
            <a href="admin_blog.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>

</html>