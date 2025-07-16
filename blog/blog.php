<?php
// Définit l'URL de base pour les liens ou images
$base_url = "http://localhost:8888/php_le-studio-sport";

// Constante utilisée pour les chemins relatifs
define('BASE_URL', '/php_le-studio-sport/');

// Titre affiché dans l’onglet navigateur
$pageTitle = "Blog Studio Sport";

// Meta description pour le référencement
$metaDescription = "Blog du Studio Sport : découvrez nos articles sur le sport, la nutrition et le bien-être.";

// Connexion à la base de données avec PDO
require_once '../config/database.php';

// Inclusion de fonctions PHP personnalisées
include_once "../functions/functions.php";

// Inclusion de données (config, variables, etc.)
include_once "../includes/data.php";

// Démarre la session si elle n’est pas encore active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inclut le header (menu, titre, balises head, etc.)
include "../includes/header.php";

// Récupère le mot-clé tapé dans la barre de recherche (s'il existe)
$keyword = isset($_GET['q']) ? trim($_GET['q']) : '';

// PAGINATION
// Nombre d’articles à afficher par page
$articlesPerPage = 6;

// Récupère le numéro de page depuis l'URL, sinon 1 par défaut
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

// Calcule le point de départ pour la requête SQL (OFFSET)
$offset = ($page - 1) * $articlesPerPage;
// Requête de sélection des articles publiés + total trouvé
$sql = "SELECT SQL_CALC_FOUND_ROWS id_article, titre, image_thumbnail, date_creation
        FROM articles
        WHERE statut = 'publie'";

// Si un mot-clé est présent, ajoute un filtre sur le titre
if (!empty($keyword)) {
    $sql .= " AND titre LIKE :keyword";
}

// Ajoute le tri par date décroissante + pagination
$sql .= " ORDER BY date_creation DESC LIMIT :offset, :limit";

// Prépare la requête PDO
$stmt = $pdo->prepare($sql);

// Lie le mot-clé s’il existe
if (!empty($keyword)) {
    $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
}

// Lie l’offset pour paginer les résultats
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

// Lie la limite du nombre d’articles par page
$stmt->bindValue(':limit', $articlesPerPage, PDO::PARAM_INT);
// Exécute la requête SQL
$stmt->execute();

// Récupère tous les articles dans un tableau associatif
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupère le nombre total d'articles trouvés (pour la pagination)
$total = $pdo->query("SELECT FOUND_ROWS()")->fetchColumn();

// Calcule le nombre total de pages à afficher
$totalPages = ceil($total / $articlesPerPage);
?>

<style>
    .banner-blog {
        background-image: url('/php_le-studio-sport/blog/header-blog.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 400px;
        position: relative;
    }

    .banner-blog::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1;
    }

    .banner-blog h1 {
        position: relative;
        z-index: 2;
        color: white;
    }

    .card {
        height: 100%;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease;
    }

    .card:hover {
        transform: scale(1.02);
    }

    .card-img-top {
        height: 180px;
        object-fit: cover;
    }

    .btn-gold {
        background-color: #C9A659;
        border: none;
        color: white;
        padding: 6px 20px;
        font-size: 0.85rem;
        border-radius: 4px;
        text-transform: uppercase;
        transition: background-color 0.2s;
    }

    .btn-gold:hover {
        background-color: #b18e47;
        color: #fff;
    }

    .search-bar {
        max-width: 400px;
        margin-bottom: 30px;
        position: relative;
        float: right;
    }

    .search-bar input {
        border: 2px solid #C9A659;
        border-radius: 25px;
        padding: 8px 40px 8px 20px;
        width: 100%;
        font-size: 0.9rem;
        color: #6B655A;
    }

    .search-bar i {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #C9A659;
    }

    .py-section {
        padding-top: 150px;
        padding-bottom: 180px;


    }

    .pagination {
        margin-top: 30px;
    }

    .pagination a {
        color: #C9A659;
        padding: 8px 12px;
        border: 1px solid #C9A659;
        border-radius: 4px;
        margin: 0 4px;
        text-decoration: none;
    }

    .pagination a.active {
        background-color: #C9A659;
        color: white;
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

<!-- Bannière du blog avec un titre centré et stylisé -->
<div class="banner-blog d-flex align-items-center justify-content-center">
    <h1 class="text-white display-4 fw-bold text-center">Le Blog</h1>
</div>
<!-- Conteneur pour la barre de recherche, avec marge en haut -->
<div class="container mt-5">
    <!-- Formulaire GET pour rechercher des articles par mot-clé -->
    <form method="GET" class="search-bar mx-auto">
        <!-- Champ de recherche prérempli avec la valeur précédente -->
        <input type="text" name="q" class="form-control" placeholder="Retrouver un article parmi nos actualités..." value="<?php echo htmlspecialchars($keyword); ?>">
        <!-- Icône loupe (décorative) -->
        <i class="fas fa-search"></i>
    </form>
</div>

<!-- Section contenant tous les articles avec un titre -->
<section class="blog-wrapper py-section">
    <div class="container">
        <!-- Titre principal de la section -->
        <h2 class="text-center fw-bold display-5 mb-5">LES ARTICLES DU BLOG</h2>

        <!-- Ligne de grilles Bootstrap pour disposer les cartes -->
        <div class="row">
            <?php if (empty($articles)): ?>
                <!-- Message si aucun article trouvé -->
                <p>Aucun article trouvé.</p>
            <?php else: ?>
                <!-- Boucle sur chaque article récupéré -->
                <?php foreach ($articles as $article): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100"> <!-- Carte avec hauteur fixe -->
                            <!-- Affiche l’image si disponible -->
                            <?php if (!empty($article['image_thumbnail'])): ?>
                                <img src="<?php echo htmlspecialchars($article['image_thumbnail']); ?>" class="card-img-top" alt="Image">
                            <?php endif; ?>
                            <!-- Corps de la carte avec titre, date et bouton -->
                            <div class="card-body">
                                <!-- Titre de l’article -->
                                <h5 class="card-title"><?php echo htmlspecialchars($article['titre']); ?></h5>
                                <!-- Date de publication -->
                                <p class="card-text">
                                    <small class="text-muted">
                                        Publié le <?php echo date('d/m/Y', strtotime($article['date_creation'])); ?>
                                    </small>
                                </p>
                                <!-- Bouton vers la page de l’article -->
                                <a href="<?php echo BASE_URL; ?>blog/article.php?id=<?php echo $article['id_article']; ?>" class="btn btn-gold">Lire</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div> <!-- Fin de la ligne .row -->

        <!-- Affiche la pagination si plusieurs pages existent -->
        <?php if ($totalPages > 1): ?>
            <div class="pagination text-center">
                <!-- Boucle pour afficher chaque numéro de page -->
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?q=<?php echo urlencode($keyword); ?>&page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div> <!-- Fin du container -->


</section>
<!-- Inclusion du pied de page -->
<?php include "../includes/footer.php"; ?>