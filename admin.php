<?php
// Démarrer la session
session_start();
ob_start();
// Vérifier si l'utilisateur est connecté et a le rôle approprié
if (
    !isset($_SESSION['user'])
    || !in_array($_SESSION['user']['role'], ['administrateur', 'moderateur'])
) {
    // si pas connecté OU pas admin/modérateur → redirection vers le login
    header('Location: login/login.php');
    exit();
}
require 'config/database.php';
require 'update.php';
// Récupérer les contacts
$stmt = $pdo->prepare("SELECT CONCAT(nom_contact, ' ', prenom_contact) AS nom_complet, email_contact, sujet, message, date_envoi, statut FROM contact");
$stmt->execute();
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Récupérer les utilisateurs
$stmt = $pdo->prepare("SELECT id_user, nom_user, prenom_user, CONCAT(nom_user, ' ', prenom_user) AS nom_complet, email_user, role, statut, dateincrip_user FROM user");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/custom-theme.css" rel="stylesheet">
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
            margin-bottom: 2rem;
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

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-color-hover));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.95rem;
            font-family: 'Bebas Neue', sans-serif;
        }

        .status-new {
            background: #e8f5e8;
            color: var(--success-color);
        }

        .status-read {
            background: #e6f3ff;
            color: var(--primary-color);
        }

        .status-replied {
            background: #fff3e0;
            color: var(--warning-color);
        }

        .status-actif {
            background: #e8f5e8;
            color: var(--success-color);
        }

        .status-suspendu {
            background: #fff3e0;
            color: var(--warning-color);
        }

        .status-inactif {
            background: #f8d7da;
            color: var(--danger-color);
        }

        .btn-action {
            padding: 8px 12px;
            margin: 2px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            transition: all 0.3s;
        }

        .btn-action:hover {
            transform: translateY(-2px);
        }

        .search-box input,
        .input-group .form-control {
            border-radius: var(--radius-md);
            border: 2px solid #e9ecef;
            font-family: 'Barlow Condensed', sans-serif;
        }

        .search-box input:focus,
        .input-group .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(207, 173, 108, 0.15);
        }

        .modal-content {
            border-radius: var(--radius-md);
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
        <a href="/index.php" class="mb-4"><img src="assets/img/logo.png" alt="Logo" class="logo"></a>
        <ul class="nav flex-column w-100">
            <li class="nav-item">
                <a class="nav-link<?= !isset($_GET['tab']) || $_GET['tab'] === 'dashboard' ? ' active' : '' ?>" href="admin.php?tab=dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?= isset($_GET['tab']) && $_GET['tab'] === 'contacts' ? ' active' : '' ?>" href="admin.php?tab=contacts"><i class="fas fa-envelope"></i> Messages Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?= isset($_GET['tab']) && $_GET['tab'] === 'users' ? ' active' : '' ?>" href="admin.php?tab=users"><i class="fas fa-users"></i> Gestion Utilisateurs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?= isset($_GET['tab']) && $_GET['tab'] === 'blog' ? ' active' : '' ?>" href="admin.php?tab=blog"><i class="fas fa-blog"></i> Gestion Blog</a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?= isset($_GET['tab']) && $_GET['tab'] === 'settings' ? ' active' : '' ?>" href="admin.php?tab=settings"><i class="fas fa-cog"></i> Paramètres</a>
            </li>
        </ul>
    </nav>
    <div class="main-content">
        <div class="header-admin mb-4">
            <div class="d-flex align-items-center">
                <img src="assets/img/logo.png" alt="Logo" class="logo me-3">
                <div>
                    <div class="section-title mb-1">Tableau de Bord</div>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <!-- dashbord -->
            <?php $tab = $_GET['tab'] ?? 'dashboard'; ?>
            <?php if ($tab === 'dashboard'): ?>
                <div class="tab-pane show active" id="dashboard">
                    <div class="header-card">
                        <h2 class="mb-3">
                            <i class="fas fa-chart-bar me-2"></i>
                            Tableau de Bord
                        </h2>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="stats-card">
                                <div class="stats-icon" style="background: linear-gradient(135deg, var(--success-color), #229954);">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <h3 class="fw-bold mb-1">24</h3>
                                <p class="text-muted mb-0">Nouveaux messages</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="stats-card">
                                <div class="stats-icon" style="background: linear-gradient(135deg, var(--accent-color), #2980b9);">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h3 class="fw-bold mb-1">156</h3>
                                <p class="text-muted mb-0">Utilisateurs actifs</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="stats-card">
                                <div class="stats-icon" style="background: linear-gradient(135deg, var(--warning-color), #e67e22);">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <h3 class="fw-bold mb-1">8</h3>
                                <p class="text-muted mb-0">En attente</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="stats-card">
                                <div class="stats-icon" style="background: linear-gradient(135deg, var(--danger-color), #c0392b);">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h3 class="fw-bold mb-1">89%</h3>
                                <p class="text-muted mb-0">Taux de réponse</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- contact -->
            <?php elseif ($tab === 'contacts'): ?>
                <div class="tab-pane show active" id="contacts">
                    <div class="header-card">
                        <h2 class="mb-3">
                            <i class="fas fa-envelope me-2"></i>
                            Gestion des Messages
                        </h2>
                        <p class="mb-0">Consultez et gérez tous les messages de contact</p>
                    </div>

                    <div class="table-container">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="search-box">
                                    <i class="fas fa-search"></i>
                                    <input type="text" class="form-control" placeholder="Rechercher dans les messages...">
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <button class="btn btn-outline-primary">
                                    <i class="fas fa-filter me-1"></i>
                                    Filtrer
                                </button>
                                <button class="btn btn-success">
                                    <i class="fas fa-download me-1"></i>
                                    Exporter
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Expéditeur</th>
                                        <th>Email</th>
                                        <th>Sujet</th>
                                        <th>Date</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contacts as $contact): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="user-avatar me-3">JD</div>
                                                    <strong>
                                                        <?php echo $contact['nom_complet']; ?>
                                                    </strong>
                                                </div>
                                            </td>
                                            <td><?php echo $contact['email_contact']; ?></td>
                                            <td><?php echo $contact['sujet']; ?></td>
                                            <td><?php echo $contact['date_envoi']; ?></td>
                                            <td><span class="status-badge status-new"><?php echo $contact['statut']; ?></span></td>
                                            <td>
                                                <button class="btn btn-primary btn-action" title="Voir">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-success btn-action" title="Répondre">
                                                    <i class="fas fa-reply"></i>
                                                </button>
                                                <button class="btn btn-danger btn-action" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <nav class="mt-4">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#">Précédent</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Suivant</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- utilisteurs -->
            <?php elseif ($tab === 'users'): ?>
                <div class="tab-pane show active" id="users">
                    <div class="header-card">
                        <h2 class="mb-3"><i class="fas fa-users me-2"></i>Gestion des Utilisateurs</h2>
                        <p class="mb-0">Gérez les comptes utilisateurs de votre plateforme</p>
                    </div>
                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Utilisateur</th>
                                        <th>Email</th>
                                        <th>Rôle</th>
                                        <th>Date d'inscription</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="user-avatar me-3"><?= htmlspecialchars(substr($user['nom_user'], 0, 1) . substr($user['prenom_user'], 0, 1)) ?></div>
                                                    <div>
                                                        <strong><?= htmlspecialchars($user['nom_complet']) ?></strong><br>
                                                        <small class="text-muted"><?= htmlspecialchars($user['role']) ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($user['email_user']) ?></td>
                                            <td><?= htmlspecialchars($user['role']) ?></td>
                                            <td><?= htmlspecialchars($user['dateincrip_user']) ?></td>
                                            <td><?= htmlspecialchars($user['statut']) ?></td>
                                            <td>
                                                <a href="blog/delete_user.php?id=<?= $user['id_user'] ?>" class="btn btn-danger btn-action"><i class="fas fa-trash"></i></a>
                                                <button class="btn btn-primary btn-action" title="Voir" data-bs-toggle="modal" data-bs-target="#viewUserModal" data-user='<?= json_encode($user) ?>'><i class="fas fa-eye"></i></button>
                                                <button class="btn btn-warning btn-action" title="Modifier" data-bs-toggle="modal" data-bs-target="#editUserModal" data-user='<?= json_encode($user) ?>'><i class="fas fa-edit"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- blog -->
            <?php elseif ($tab === 'blog'):
                // --- TRAITEMENT CREATION ARTICLE ---
                // 2. Correction création article blog (POST, image, insertion)
                if (
                    $_SERVER['REQUEST_METHOD'] === 'POST' && // Si le formulaire a été envoyé en POST (sécurité de méthode)
                    isset($_POST['titre'], $_POST['contenu'], $_POST['statut'], $_POST['auteur_id']) && // Si les champs essentiels sont bien envoyés
                    isset($_FILES['image']) && $_FILES['image']['error'] === 0 // Si une image a bien été envoyée, sans erreur
                ) {
                    // ✅ Protection CSRF : on vérifie que le token est correct
                    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                        die('Erreur CSRF'); // Si le token est absent ou incorrect, on bloque tout
                    }

                    // ✅ Récupération et sécurité des données
                    $titre = htmlspecialchars($_POST['titre']); // On protège le titre contre les failles XSS (scripts cachés)
                    $contenu = $_POST['contenu']; // On récupère le contenu tel quel (il peut contenir du HTML de TinyMCE)
                    $statut = $_POST['statut']; // Brouillon ou Publié
                    $auteur_id = (int) $_POST['auteur_id']; // On transforme l'ID de l’auteur en nombre entier (sécurité)

                    // ✅ Infos sur l’image envoyée
                    $image_name = $_FILES['image']['name']; // On récupère le nom d’origine de l’image
                    $image_tmp = $_FILES['image']['tmp_name']; // Chemin temporaire de l’image (créé automatiquement par PHP)
                    $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION)); // On récupère l’extension (jpg, png…) en minuscule

                    // ✅ Vérification que le fichier est bien une image autorisée
                    $allowed_exts = ['jpg', 'jpeg', 'png', 'webp']; // Extensions acceptées
                    if (!in_array($image_ext, $allowed_exts)) {
                        die('Format d\'image non autorisé'); // Si l’extension n’est pas autorisée, on bloque tout
                    }

                    // ✅ Préparation du chemin où seront stockées les images
                    $base_path = __DIR__ . '/blog/uploads'; // Chemin complet du dossier uploads, basé sur le dossier actuel

                    // ✅ Création du dossier s’il n’existe pas
                    if (!is_dir($base_path)) mkdir($base_path);

                    // ✅ Création automatique des 4 sous-dossiers d’images
                    $folders = ['original', 'large', 'medium', 'thumbnail'];
                    foreach ($folders as $folder) {
                        if (!is_dir("$base_path/$folder")) {
                            mkdir("$base_path/$folder", 0755, true); // Création avec les bonnes permissions
                        }
                    }

                    // ✅ Création d’un nom unique pour l’image (évite les doublons et les attaques)
                    $new_filename = uniqid() . '.' . $image_ext;

                    // ✅ Chemin complet de l’image d’origine
                    $original_path = "$base_path/original/$new_filename";

                    // ✅ Enregistrement de l’image sur le serveur
                    if (!move_uploaded_file($image_tmp, $original_path)) {
                        die('Échec de l\'upload de l\'image'); // Si l’upload échoue, on arrête tout
                    }

                    // ✅ Inclusion de la fonction resizeImage()
                    require_once 'blog/functions_image.php';

                    // ✅ Définition des chemins des images redimensionnées
                    $large_path = "$base_path/large/$new_filename";
                    $medium_path = "$base_path/medium/$new_filename";
                    $thumb_path = "$base_path/thumbnail/$new_filename";

                    // ✅ Redimensionnement de l’image originale en plusieurs tailles
                    resizeImage($original_path, $large_path, 800, 600);   // grande image
                    resizeImage($original_path, $medium_path, 400, 300);  // image moyenne
                    resizeImage($original_path, $thumb_path, 150, 150);   // miniature

                    // ✅ Chemins à enregistrer dans la base (chemins relatifs)
                    $img_o = '../blog/uploads/original/' . $new_filename;
                    $img_l = '../blog/uploads/large/' . $new_filename;
                    $img_m = '../blog/uploads/medium/' . $new_filename;
                    $img_t = '../blog/uploads/thumbnail/' . $new_filename;

                    // ✅ Insertion de l’article dans la base de données
                    try {
                        $stmt = $pdo->prepare("INSERT INTO articles (titre, contenu, auteur_id, statut, image_originale, image_large, image_medium, image_thumbnail) VALUES (:titre, :contenu, :auteur_id, :statut, :img_o, :img_l, :img_m, :img_t)");
                        $stmt->execute([
                            ':titre'   => $titre,
                            ':contenu' => $contenu,
                            ':auteur_id' => $auteur_id,
                            ':statut' => $statut,
                            ':img_o'  => $img_o,
                            ':img_l'  => $img_l,
                            ':img_m'  => $img_m,
                            ':img_t'  => $img_t
                        ]);

                        // ✅ Redirection après succès

                        header('Location: admin.php?tab=blog&success=1');
                        exit();
                    } catch (PDOException $e) {
                        // ✅ En cas d'erreur SQL, on affiche un message sécurisé
                        echo '<div class="alert alert-danger">Erreur SQL : ' . htmlspecialchars($e->getMessage()) . '</div>';
                    }
                }
                // --- TRAITEMENT MODIFICATION ARTICLE ---
                if (
                    $_SERVER['REQUEST_METHOD'] === 'POST' &&
                    isset($_POST['edit_id_article'], $_POST['edit_titre'], $_POST['edit_contenu'], $_POST['edit_statut'])
                ) {
                    // CSRF
                    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                        die('Erreur CSRF');
                    }

                    $id_article = (int) $_POST['edit_id_article'];
                    $titre = htmlspecialchars($_POST['edit_titre']);
                    $contenu = $_POST['edit_contenu'];
                    $statut = $_POST['edit_statut'];

                    // Variables pour les images (garder les anciennes par défaut)
                    $img_o = null;
                    $img_l = null;
                    $img_m = null;
                    $img_t = null;

                    // Vérifier si une nouvelle image a été uploadée
                    if (isset($_FILES['edit_image']) && $_FILES['edit_image']['error'] === 0) {
                        $image_name = $_FILES['edit_image']['name'];
                        $image_tmp = $_FILES['edit_image']['tmp_name'];
                        $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

                        $allowed_exts = ['jpg', 'jpeg', 'png', 'webp'];
                        if (!in_array($image_ext, $allowed_exts)) {
                            die('Format d\'image non autorisé');
                        }

                        $base_path = __DIR__ . '/blog/uploads';
                        if (!is_dir($base_path)) mkdir($base_path);

                        $folders = ['original', 'large', 'medium', 'thumbnail'];
                        foreach ($folders as $folder) {
                            if (!is_dir("$base_path/$folder")) {
                                mkdir("$base_path/$folder", 0755, true);
                            }
                        }

                        $new_filename = uniqid() . '.' . $image_ext;
                        $original_path = "$base_path/original/$new_filename";

                        if (!move_uploaded_file($image_tmp, $original_path)) {
                            die('Échec de l\'upload de l\'image');
                        }

                        require_once 'blog/functions_image.php';

                        $large_path = "$base_path/large/$new_filename";
                        $medium_path = "$base_path/medium/$new_filename";
                        $thumb_path = "$base_path/thumbnail/$new_filename";

                        resizeImage($original_path, $large_path, 800, 600);
                        resizeImage($original_path, $medium_path, 400, 300);
                        resizeImage($original_path, $thumb_path, 150, 150);

                        $img_o = 'blog/uploads/original/' . $new_filename;
                        $img_l = 'blog/uploads/large/' . $new_filename;
                        $img_m = 'blog/uploads/medium/' . $new_filename;
                        $img_t = 'blog/uploads/thumbnail/' . $new_filename;
                    }

                    try {
                        if ($img_o) {
                            // Mise à jour avec nouvelle image
                            $stmt = $pdo->prepare("UPDATE articles SET titre = :titre, contenu = :contenu, statut = :statut, image_originale = :img_o, image_large = :img_l, image_medium = :img_m, image_thumbnail = :img_t WHERE id_article = :id");
                            $stmt->execute([
                                ':titre' => $titre,
                                ':contenu' => $contenu,
                                ':statut' => $statut,
                                ':img_o' => $img_o,
                                ':img_l' => $img_l,
                                ':img_m' => $img_m,
                                ':img_t' => $img_t,
                                ':id' => $id_article
                            ]);
                        } else {
                            // Mise à jour sans changer l'image
                            $stmt = $pdo->prepare("UPDATE articles SET titre = :titre, contenu = :contenu, statut = :statut WHERE id_article = :id");
                            $stmt->execute([
                                ':titre' => $titre,
                                ':contenu' => $contenu,
                                ':statut' => $statut,
                                ':id' => $id_article
                            ]);
                        }

                        header('Location: admin.php?tab=blog&success=1');
                        exit();
                    } catch (PDOException $e) {
                        echo '<div class="alert alert-danger">Erreur SQL : ' . htmlspecialchars($e->getMessage()) . '</div>';
                    }
                }
                // --- TRAITEMENT SUPPRESSION ARTICLE ---
                if (isset($_GET['delete_article']) && ctype_digit($_GET['delete_article'])) {
                    $id_article = (int)$_GET['delete_article'];
                    try {
                        $stmt = $pdo->prepare("DELETE FROM articles WHERE id_article = :id");
                        $stmt->execute([':id' => $id_article]);
                        header('Location: admin.php?tab=blog&success=1');
                        exit();
                    } catch (PDOException $e) {
                        echo '<div class="alert alert-danger">Erreur SQL : ' . htmlspecialchars($e->getMessage()) . '</div>';
                    }
                }
                // --- FIN TRAITEMENT CREATION ARTICLE ---
            ?>
                <div class="tab-pane show active" id="blog">
                    <?php
                    // Sécurité : CSRF token
                    if (empty($_SESSION['csrf_token'])) {
                        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                    }
                    $csrf_token = $_SESSION['csrf_token'];
                    // CRUD Blog : récupération des articles
                    $stmt = $pdo->prepare("SELECT a.id_article, a.titre, a.contenu, a.date_creation, a.statut, a.image_thumbnail, u.nom_user, u.prenom_user FROM articles a LEFT JOIN user u ON a.auteur_id = u.id_user ORDER BY a.date_creation DESC");
                    $stmt->execute();
                    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="header-card d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="mb-3"><i class="fas fa-blog me-2"></i>Gestion du Blog</h2>
                            <p class="mb-0">Liste, ajout, modification et suppression des articles</p>
                        </div>
                        <button class="btn btn-gold" data-bs-toggle="modal" data-bs-target="#addArticleModal">
                            <i class="fas fa-plus me-1"></i> Nouvel article
                        </button>
                    </div>
                    <?php if (!empty($erreur_blog)) : ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($erreur_blog) ?></div>
                    <?php endif; ?>
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
                                        <?php $imagePath = $article['image_thumbnail'];
                                        $imagePath = str_replace('../', '', $imagePath); // Enlever ../
                                        if (strpos($imagePath, 'blog/') !== 0) {
                                            $imagePath = 'blog/' . $imagePath; // Ajouter blog/ si absent
                                        }
                                        ?><tr>
                                            <td>

                                                <?php if (!empty($imagePath)): ?>
                                                    <img width="50" src="http://localhost:8888/php_le-studio-sport/<?= htmlspecialchars($imagePath) ?>" class="article-thumb" alt="Miniature">
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
                                                <button class="btn btn-warning"
                                                    title="Modifier"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editArticleModal"
                                                    data-article='<?= json_encode($article) ?>'>
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <a href="blog/delete_article.php?id=<?= $article['id_article'] ?>" class="btn btn-danger " title="Supprimer" onclick="return confirm('Supprimer cet article ?')">
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
                </table>

                <!-- Modal d'ajout d'article -->
                <div class="modal fade" id="addArticleModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title section-title mb-0"><i class="fas fa-plus me-2"></i>Nouvel article</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form action="admin.php?tab=blog" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="auteur_id" value="<?= $_SESSION['user']['id_user'] ?>">

                                    <div class="mb-3">
                                        <label for="titre" class="form-label">Titre de l'article</label>
                                        <input type="text" class="form-control" name="titre" id="titre" placeholder="Titre de l'article" required>
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
                                    <button type="submit" class="btn btn-gold">
                                        <i class="fas fa-save me-1"></i> Publier
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

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
                        images_upload_url: 'blog/upload_image.php',
                        images_upload_credentials: true
                    });
                </script>
        </div>
    <?php endif; ?>
    </div>

    <!-- Modals -->

    <!-- Modal de création utilisateur -->
    <div class="modal fade" id="createUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus me-2"></i>
                        Créer un nouvel utilisateur
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="createUserForm">
                        <div class="mb-3">
                            <label class="form-label">Nom complet</label>
                            <input type="text" id="createFullName" class="form-control" placeholder="Jean Dupont">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" id="createEmail" class="form-control" placeholder="jean.dupont@email.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rôle</label>
                            <select class="form-select">
                                <option>Utilisateur</option>
                                <option>Modérateur</option>
                                <option>Administrateur</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <a href="?id=<?= $user['id_user'] ?>"
                        class="btn btn-warning"
                        onclick="return confirm('Créer cet utilisateur ?')">
                        <i class="fas fa-save me-1"></i>
                        Sauvegarder
                    </a>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal de visualisation message -->
    <div class=" modal fade" id="viewMessageModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-envelope me-2"></i>
                        Détails du message
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Expéditeur :</strong> Jean Dupont
                        </div>
                        <div class="col-md-6">
                            <strong>Email :</strong> jean.dupont@email.com
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Date :</strong> 23 Juin 2025, 14:30
                        </div>
                        <div class="col-md-6">
                            <strong>Sujet :</strong> Demande d'information produit
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong>Message :</strong>
                        <div class="border rounded p-3 mt-2 bg-light">
                            Bonjour,<br><br>
                            Je souhaiterais obtenir plus d'informations concernant votre nouveau produit lancé récemment.
                            Pourriez-vous me faire parvenir la documentation technique ainsi que les tarifs ?<br><br>
                            Cordialement,<br>
                            Jean Dupont
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong>Réponse :</strong>
                        <textarea class="form-control mt-2" rows="4" placeholder="Tapez votre réponse ici..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-success">
                        <i class="fas fa-paper-plane me-1"></i>
                        Envoyer la réponse
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal de modification d'utilisateur -->
    <div class=" modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-edit me-2"></i>
                        Modifier l'utilisateur
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Nom complet</label>
                            <input type="text" class="form-control" value="Jean Dupont">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="jean.dupont@email.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rôle</label>
                            <select class="form-select">
                                <option>Utilisateur</option>
                                <option>Modérateur</option>
                                <option>Administrateur</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Statut</label>
                            <select class="form-select">
                                <option>Actif</option>
                                <option>Suspendu</option>
                                <option>Inactif</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <a href="blog/update.php?id=<?= $user['id_user'] ?>"
                        class="btn btn-warning"
                        onclick="return confirm('Modifier cet utilisateur ?')">
                        <i class="fas fa-save me-1"></i>
                        Sauvegarder
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de confirmation de suppression -->
    <!-- <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                        Confirmer la suppression
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <a href="delete_user.php?id=<?= isset($user['id_user']) ? $user["id_user"] : "" ?>"
                        class="btn btn-danger"
                        onclick="return confirm('Supprimer cet utilisateur ? Cette action est irréversible.')">
                        <i class="fas fa-trash me-1"></i>
                        Supprimer
                    </a>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Modal de modification d'article -->
    <div class="modal fade" id="editArticleModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>
                        Modifier l'article
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="admin.php?tab=blog" method="POST" enctype="multipart/form-data" id="editArticleForm">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        <input type="hidden" name="edit_id_article" id="editArticleId">

                        <div class="mb-3">
                            <label for="editTitre" class="form-label">Titre de l'article</label>
                            <input type="text" class="form-control" name="edit_titre" id="editTitre" required>
                        </div>

                        <div class="mb-3">
                            <label for="editContenu" class="form-label">Contenu</label>
                            <textarea name="edit_contenu" id="editContenu" class="form-control" rows="8"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="editImage" class="form-label">Nouvelle image (optionnel)</label>
                            <input type="file" class="form-control" name="edit_image" id="editImage" accept="image/*">

                        </div>

                        <div class="mb-3">
                            <label for="editStatut" class="form-label">Statut</label>
                            <select name="edit_statut" class="form-select" id="editStatut">
                                <option value="brouillon">Brouillon</option>
                                <option value="publie">Publié</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" form="editArticleForm" class="btn btn-warning" onclick="return confirm('Modifier cet article ?')">
                        <i class="fas fa-save me-1"></i>
                        Sauvegarder
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion des onglets de navigation
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    // Retirer la classe active de tous les liens
                    navLinks.forEach(nl => nl.classList.remove('active'));
                    // Ajouter la classe active au lien cliqué

                    this.classList.add('active');
                });
            });

            // Gestion des boutons d'action
            const actionButtons = document.querySelectorAll('.btn-action');
            actionButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const icon = this.querySelector('i');

                    if (icon.classList.contains('fa-trash')) {
                        // Ouvrir modal de confirmation de suppression
                        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                        deleteModal.show();
                    } else if (icon.classList.contains('fa-eye')) {
                        // Ouvrir modal de visualisation
                        const viewModal = new bootstrap.Modal(document.getElementById('viewMessageModal'));
                        viewModal.show();
                    } else if (icon.classList.contains('fa-edit')) {
                        // Ouvrir modal d'édition
                        const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                        editModal.show();
                    }
                });
            });

            // Gestion des boutons de création d'utilisateur
            const createUserButton = document.querySelector('#createUserModal .btn-warning');
            if (createUserButton) {

                createUserButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    const createModal = new bootstrap.Modal(document.getElementById('createUserModal'));
                    createModal.show();
                });
            }

            // Remplir dynamiquement le modal d'édition utilisateur
            const editUserModal = document.getElementById('editUserModal');
            editUserModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const user = JSON.parse(button.getAttribute('data-user'));
                document.getElementById('editUserId').value = user.id_user;
                document.getElementById('editFullName').value = user.nom_complet;
                document.getElementById('editEmail').value = user.email_user;
                document.getElementById('editRole').value = user.role;
                document.getElementById('editStatut').value = user.statut;
            });

            const editArticleModal = document.getElementById('editArticleModal');
            if (editArticleModal) {
                editArticleModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const article = JSON.parse(button.getAttribute('data-article'));

                    document.getElementById('editArticleId').value = article.id_article;
                    document.getElementById('editTitre').value = article.titre;
                    document.getElementById('editStatut').value = article.statut;

                    // Pour TinyMCE, utilisez setContent()
                    tinymce.get('editContenu').setContent(article.contenu);
                });
            }
            tinymce.init({
                selector: '#contenu, #editContenu', // Ajoutez #editContenu ici
                plugins: [
                    'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace',
                    'table', 'visualblocks', 'wordcount', 'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed',
                    'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage',
                    'advtemplate', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect',
                    'typography', 'inlinecss', 'markdown', 'importword', 'exportword', 'exportpdf', 'paste'
                ],
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | ' +
                    'addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | ' +
                    'emoticons charmap | removeformat',
                paste_data_images: false, // ← IMPORTANT !
                tinycomments_mode: 'embedded',
                tinycomments_author: 'Admin',
                height: 300,
                automatic_uploads: true,
                images_upload_url: 'blog/upload_image.php',
                images_upload_credentials: true
            });
            // Animation des cartes statistiques
            const statsCards = document.querySelectorAll('.stats-card');
            statsCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px) scale(1.02)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Fonction de recherche en temps réel
            const searchInputs = document.querySelectorAll('.search-box input');
            searchInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const table = this.closest('.table-container').querySelector('table tbody');
                    const rows = table.querySelectorAll('tr');

                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            });

            // Effets de notification (simulation)
            function showNotification(message, type = 'success') {
                const notification = document.createElement('div');
                notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
                notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                notification.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(notification);

                // Auto-remove après 3 secondes
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 3000);
            }

            // Simulation d'actions
            document.querySelectorAll('button[type="submit"]').forEach(button => {
                button.addEventListener('click', function(e) {
                    // e.preventDefault();
                    showNotification('Paramètres sauvegardés avec succès !', 'success');
                });
            });

            // Gestion responsive du sidebar
            function handleResize() {
                const sidebar = document.querySelector('.sidebar');
                const mainContent = document.querySelector('.main-content');

                if (window.innerWidth <= 768) {
                    sidebar.style.transform = 'translateX(-100%)';
                    mainContent.style.marginLeft = '0';
                } else {
                    sidebar.style.transform = 'translateX(0)';
                    mainContent.style.marginLeft = '250px';
                }
            }

            window.addEventListener('resize', handleResize);
            handleResize(); // Appel initial

            // Bouton pour toggle sidebar sur mobile
            const toggleButton = document.createElement('button');
            toggleButton.className = 'btn btn-primary position-fixed d-md-none';
            toggleButton.style.cssText = 'top: 20px; left: 20px; z-index: 1001;';
            toggleButton.innerHTML = '<i class="fas fa-bars"></i>';
            document.body.appendChild(toggleButton);

            toggleButton.addEventListener('click', function() {
                const sidebar = document.querySelector('.sidebar');
                const isHidden = sidebar.style.transform === 'translateX(-100%)';

                sidebar.style.transform = isHidden ? 'translateX(0)' : 'translateX(-100%)';
            });
        });
        // 🔧 Filtrage automatique lors du changement de sélection
        const filterForm = document.getElementById('filterForm');
        const filterSelects = filterForm.querySelectorAll('select');

        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                // Auto-submit du formulaire quand on change un filtre
                filterForm.submit();
            });
        });
        // Script pour gérer les filtres // Nettoyer l'URL des paramètres success/error après affichage du message
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('success') || urlParams.has('error')) {
            // Garder tous les autres paramètres
            const currentTab = urlParams.get('tab');
            const filters = ['date_filter', 'role_filter', 'status_filter', 'sort'];
            const newUrl = new URL(window.location);

            // Supprimer seulement success/error
            newUrl.searchParams.delete('success');
            newUrl.searchParams.delete('error');

            // Remplacer l'URL sans recharger la page
            window.history.replaceState({}, '', newUrl);
        }
    </script>
</body>

</html>