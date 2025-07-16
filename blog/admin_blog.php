<?php
session_start();

if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['administrateur', 'moderateur'])) {
    die('⛔ Accès refusé. Vous devez être connecté en tant qu’administrateur ou modérateur.');
}
require_once '../config/database.php';

// Récupérer tous les articles
$stmt = $pdo->prepare("SELECT a.id_article, a.titre, a.date_creation, a.statut, a.image_thumbnail, u.nom_user, u.prenom_user FROM articles a LEFT JOIN user u ON a.auteur_id = u.id_user ORDER BY a.date_creation DESC");
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Blog – Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/custom-theme.css" rel="stylesheet">
    <style>
        body {
            background: #f8f8f8;
        }

        .sidebar {
            background: var(--secondary-color);
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            z-index: 1000;
            box-shadow: var(--shadow-soft);
        }

        .sidebar .nav-link {
            color: var(--primary-color);
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.15rem;
            letter-spacing: 1px;
            border-left: 4px solid transparent;
            transition: all 0.3s;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background: rgba(207, 173, 108, 0.08);
            color: var(--primary-color-hover);
            border-left: 4px solid var(--primary-color);
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px 20px 20px 20px;
        }

        .header-admin {
            background: #fff;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-soft);
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-admin .logo {
            height: 48px;
            margin-right: 1.5rem;
        }

        .section-title {
            font-size: 2.2rem;
            font-family: 'Bebas Neue', sans-serif;
            text-transform: uppercase;
            color: var(--secondary-color);
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

        .table-container {
            background: #fff;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-soft);
            padding: 2rem;
        }

        .table thead th {
            color: var(--primary-color);
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.1rem;
            border-bottom: 2px solid var(--primary-color);
        }

        .table tbody td {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.05rem;
            vertical-align: middle;
        }

        .article-thumb {
            width: 60px;
            height: 40px;
            object-fit: cover;
            border-radius: var(--radius-sm);
            border: 1px solid #eee;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.95rem;
            font-family: 'Bebas Neue', sans-serif;
        }

        .status-brouillon {
            background: #fff3e0;
            color: var(--warning-color);
        }

        .status-publie {
            background: #e8f5e8;
            color: var(--success-color);
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar d-flex flex-column align-items-center py-4">
        <a href="/index.php" class="mb-4"><img src="../assets/img/logo.png" alt="Logo" class="logo"></a>
        <ul class="nav flex-column w-100">
            <li class="nav-item">
                <a class="nav-link" href="/admin.php">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin.php#contacts">
                    <i class="fas fa-envelope"></i> Messages Contact
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin.php#users">
                    <i class="fas fa-users"></i> Gestion Utilisateurs
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="/blog/admin_blog.php">
                    <i class="fas fa-blog"></i> Gestion Blog
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin.php#settings">
                    <i class="fas fa-cog"></i> Paramètres
                </a>
            </li>
        </ul>
    </nav>
    <div class="main-content">
        <div class="header-admin mb-4">
            <div class="d-flex align-items-center">
                <img src="../assets/img/logo.png" alt="Logo" class="logo me-3">
                <div>
                    <div class="section-title mb-1">Gestion du Blog</div>
                    <div class="text-muted" style="font-family:'Barlow Condensed',sans-serif;font-size:1.1rem;">Liste, ajout, modification et suppression des articles</div>
                </div>
            </div>
            <button class="btn btn-gold" data-bs-toggle="modal" data-bs-target="#addArticleModal">
                <i class="fas fa-plus me-1"></i> Nouvel article
            </button>
        </div>
        <div class="table-container">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Miniature</th>
                            <th>Titre</th>
                            <th>Auteur</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($articles as $article): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($article['image_thumbnail'])): ?>
                                        <img src="<?= htmlspecialchars($article['image_thumbnail']) ?>" class="article-thumb" alt="Miniature">
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($article['titre']) ?></td>
                                <td><?= htmlspecialchars($article['nom_user'] . ' ' . $article['prenom_user']) ?></td>
                                <td><?= date('d/m/Y', strtotime($article['date_creation'])) ?></td>
                                <td>
                                    <span class="status-badge status-<?= htmlspecialchars($article['statut']) ?>">
                                        <?= ucfirst($article['statut']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="edit_article.php?id=<?= $article['id_article'] ?>" class="btn btn-warning btn-action" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete_article.php?id=<?= $article['id_article'] ?>" class="btn btn-danger btn-action" title="Supprimer" onclick="return confirm('Supprimer cet article ?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal d'ajout d'article -->
    <div class="modal fade" id="addArticleModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title section-title mb-0"><i class="fas fa-plus me-2"></i>Nouvel article</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="traitement_blog.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre de l'article</label>
                            <input type="text" class="form-control" name="titre" id="titre" required>
                        </div>
                        <div class="mb-3">
                            <label for="contenu" class="form-label">Contenu</label>
                            <textarea name="contenu" id="contenu" class="form-control" rows="8"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image principale</label>
                            <input type="file" class="form-control" name="image" id="image" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label for="statut" class="form-label">Statut</label>
                            <select name="statut" class="form-select" id="statut">
                                <option value="brouillon">Brouillon</option>
                                <option value="publie">Publié</option>
                            </select>
                        </div>
                        <input type="hidden" name="auteur_id" value="<?php echo $_SESSION['user']['id_user']; ?>">
                        <button type="submit" class="btn btn-gold">
                            <i class="fas fa-save me-1"></i> Publier
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/jwgmbfb5zw8tb3d3pwf6unecjve1m2388d1ar1vvmamlyzf1/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#contenu',
            plugins: [
                'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace',
                'table', 'visualblocks', 'wordcount', 'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed',
                'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage',
                'advtemplate', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect',
                'typography', 'inlinecss', 'markdown', 'importword', 'exportword', 'exportpdf'
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | ' +
                'addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | ' +
                'emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Admin',
            height: 300,
            automatic_uploads: true,
            images_upload_url: 'upload_image.php',
            images_upload_credentials: true
        });
    </script>
</body>

</html>