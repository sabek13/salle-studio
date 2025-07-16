<?php
// Définit le titre de la page (affiché dans l'onglet du navigateur)
$pageTitle = "Articles Studio Sport";

// Meta-description pour le référencement SEO
$metaDescription = "Articles du blog du Studio Sport : découvrez nos conseils, actualités et astuces pour un mode de vie sain.";

// Inclusion de fonctions personnalisées
include_once "../functions/functions.php";

// Inclusion de données communes ou statiques
include_once "../includes/data.php";

// Inclusion de la connexion PDO à la base de données
include_once '../config/database.php';

// Démarre la session si elle n'est pas déjà active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inclut l'en-tête HTML du site (header, menu, etc.)
include "../includes/header.php";

// Vérifie que l'ID est bien présent en URL et est un nombre entier
if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("ID d'article invalide."); // Stoppe l'exécution si l'ID est invalide
}

// Convertit l’ID en entier pour éviter les injections
$id_article = (int)$_GET['id'];

try {
    // Prépare une requête SQL sécurisée pour récupérer l'article publié
    $stmt = $pdo->prepare("SELECT titre, contenu, image_large, image_originale, date_creation FROM articles WHERE id_article = :id AND statut = 'publie'");

    // Exécute la requête avec l'ID d'article
    $stmt->execute([':id' => $id_article]);

    // Récupère les données de l'article dans un tableau associatif
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si aucun article trouvé, on affiche un message d'erreur
    if (!$article) {
        die("Article introuvable.");
    }
} catch (PDOException $e) {
    // En cas d'erreur SQL, affiche un message avec l'erreur capturée
    die("Erreur SQL : " . $e->getMessage());
}
?>
<style>
    /* Bannière image */
    .article-banner {
        background-image: url('/php_le-studio-sport/blog/header-bastien.jpg');
        background-size: cover;
        background-position: center;
        height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .container-article {
        max-width: 1300px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .back-btn {
        display: inline-block;
        margin-bottom: 30px;
        padding: 10px 18px;
        border: 1px solid #333;
        border-radius: 6px;
        color: #333;
        background-color: #fff;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .back-btn:hover {
        background-color: #333;
        color: #fff;
    }

    .article-layout {
        display: flex;
        flex-wrap: wrap;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .article-img {
        flex: 1 1 55%;
        min-width: 300px;
        max-height: 100%;
        overflow: hidden;
    }

    .article-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .article-img img:hover {
        transform: scale(1.03);
    }

    .article-text {
        flex: 1 1 45%;
        padding: 30px;
        font-family: 'Segoe UI', sans-serif;
    }

    .article-text h2 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: #000;
    }

    .article-text .date {
        font-size: 0.9rem;
        color: #888;
        margin-bottom: 15px;
    }

    .article-text .content {
        line-height: 1.7;
        color: #444;
        font-size: 1rem;
    }

    @media (max-width: 768px) {
        .article-layout {
            flex-direction: column;
        }

        .article-text {
            padding: 20px;
        }
    }

    .espace-bas-section {
        height: 120px;
        /* ou 150px selon ce que tu veux */
    }

    @media (max-width: 768px) {
        .espace-bas-section {
            height: 80px;
            /* espace plus petit sur mobile */
        }
    }
</style>

<!-- Bannière visuelle en haut de la page -->
<div class="article-banner"></div>
<!-- Affiche une grande image fixe en haut (via CSS) -->

<!-- Conteneur principal centré pour le contenu de l’article -->
<div class="container-article">

    <!-- Bouton de retour vers la liste des articles -->
    <a href="blog.php" class="back-btn">&larr; Retour au blog</a>

    <!-- Structure de l’article : image à gauche, texte à droite -->
    <div class="article-layout">

        <!-- Bloc image de l’article -->
        <div class="article-img">
            <!-- Affiche l’image d’origine avec protection XSS -->
            <img src="<?= htmlspecialchars($article['image_originale']) ?>" alt="Image de l'article">
        </div>

        <!-- Bloc contenant le texte de l’article -->
        <div class="article-text">
            <!-- Titre de l’article -->
            <h2><?= htmlspecialchars($article['titre']) ?></h2>

            <!-- Date de publication formatée -->
            <p class="date">Publié le <?= date('d/m/Y', strtotime($article['date_creation'])) ?></p>

            <!-- Contenu riche de l’article (issu de TinyMCE) -->
            <div class="content">
                <?= htmlspecialchars_decode($article['contenu']) ?>
            </div>
        </div>
    </div>
</div>
<!-- Espace visuel sous la section -->
<div class="espace-bas-section"></div>
<!-- Pied de page du site -->
<?php include '../includes/footer.php'; ?>