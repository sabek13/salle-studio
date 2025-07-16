<?php
session_start();
require_once __DIR__ . '/../config/database.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'utilisateur') {
    header('Location: ../login/login.php');
    exit;
}
$user = $_SESSION['user'];
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'accueil';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tableau de Bord Utilisateur – Studio Sport</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/custom-theme.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: #f8f8f8;
        }

        .sidebar-user {
            background: var(--secondary-color, #cfae6c);
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            z-index: 1000;
            box-shadow: var(--shadow-soft, 0 2px 12px rgba(0, 0, 0, 0.08));
            padding-top: 40px;
            display: flex;
            flex-direction: column;
            align-items: start;
        }

        .sidebar-user .btn-gold {
            background: var(--primary-color, #cfae6c);
            color: #fff;
            border-radius: var(--radius-sm, 1.2rem);
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.1rem;
            letter-spacing: 1px;
            border: none;
            padding: 0.6rem 1.5rem;
            margin-bottom: 2rem;
            margin-left: 10px;
            margin-right: 10px;
            margin-top: 10px;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sidebar-user .btn-gold:hover {
            background: var(--primary-color-hover, #b48c3e);
            color: #fff;
        }

        .sidebar-user .nav-link {
            color: var(--primary-color, #222);
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.15rem;
            letter-spacing: 1px;
            border-left: 4px solid transparent;
            transition: all 0.3s;
            margin-bottom: 8px;
            width: 100%;
        }

        .sidebar-user .nav-link.active,
        .sidebar-user .nav-link:hover {
            background: rgba(255, 255, 255, 0.13);
            color: var(--primary-color-hover, #b48c3e);
            border-left: 4px solid var(--primary-color, #222);
        }

        .sidebar-user .nav-link i {
            margin-right: 10px;
        }

        .main-content-user {
            margin-left: 250px;
            padding: 40px 20px 20px 20px;
        }

        .dashboard-card {
            background: #fff;
            border-radius: 1.2rem;
            box-shadow: 0 6px 32px 0 rgba(0, 0, 0, 0.13);
            font-family: 'Barlow Condensed', sans-serif;
            transition: transform 0.15s;
        }

        .dashboard-card:hover {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 0 12px 36px 0 rgba(0, 0, 0, 0.18);
        }

        .dashboard-card .card-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.5rem;
            color: var(--secondary-color, #cfae6c);
            letter-spacing: 1px;
        }

        .dashboard-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2.3rem;
            color: var(--secondary-color, #cfae6c);
            margin-bottom: 0.5rem;
        }

        .dashboard-role {
            color: #222;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        @media (max-width: 991px) {
            .sidebar-user {
                width: 100vw;
                min-height: auto;
                position: static;
                box-shadow: none;
                padding-top: 0;
            }

            .main-content-user {
                margin-left: 0;
                padding: 20px 5px;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar navigation -->
        <nav class="sidebar-user p-3">
            <a href="../index.php" class="btn btn-gold mb-4"><i class="fa fa-home"></i>Retour au site</a>
            <a href="?tab=accueil" class="nav-link<?= $tab === 'accueil' ? ' active' : '' ?>"><i class="fa fa-home"></i>Accueil</a>
            <a href="?tab=profil" class="nav-link<?= $tab === 'profil' ? ' active' : '' ?>"><i class="fa fa-user"></i>Mon profil</a>
            <a href="?tab=reservations" class="nav-link<?= $tab === 'reservations' ? ' active' : '' ?>"><i class="fa fa-calendar-check"></i>Mes réservations</a>
            <a href="?tab=messages" class="nav-link<?= $tab === 'messages' ? ' active' : '' ?>"><i class="fa fa-envelope-open-text"></i>Messages</a>
        </nav>
        <!-- Main content -->
        <div class="main-content-user flex-grow-1">
            <?php if ($tab === 'accueil'): ?>
                <h1 class="dashboard-title mb-2">Bienvenue <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?> !</h1>
                <p class="dashboard-role">Vous êtes connecté en tant qu'<strong><?= htmlspecialchars($user['role']) ?></strong>.</p>
                <div class="row g-4 mt-4 justify-content-center">
                    <div class="col-md-6 col-lg-4">
                        <div class="card dashboard-card h-100 text-center">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fa fa-user me-2"></i>Mon profil</h5>
                                <p class="card-text">Consultez et modifiez vos informations personnelles.</p>
                                <a href="?tab=profil" class="btn btn-success">Accéder</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card dashboard-card h-100 text-center">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fa fa-calendar-check me-2"></i>Mes réservations</h5>
                                <p class="card-text">Consultez vos réservations de cours ou d'activités.</p>
                                <a href="?tab=reservations" class="btn btn-info">Accéder</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card dashboard-card h-100 text-center">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fa fa-envelope-open-text me-2"></i>Messages</h5>
                                <p class="card-text">Voir vos messages de contact.</p>
                                <a href="?tab=messages" class="btn btn-primary">Accéder</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php elseif ($tab === 'profil'): ?>
                <h2 class="dashboard-title mb-3"><i class="fa fa-user me-2"></i>Mon profil</h2>
                <div class="card dashboard-card p-4 mx-auto" style="max-width:500px;">
                    <form method="post" action="">
                        <div class="mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($user['nom']) ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prénom</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($user['prenom']) ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                        </div>
                        <!-- Ajoutez ici la logique de modification si besoin -->
                    </form>
                </div>
            <?php elseif ($tab === 'reservations'): ?>
                <h2 class="dashboard-title mb-3"><i class="fa fa-calendar-check me-2"></i>Mes réservations</h2>
                <div class="card dashboard-card p-4 mx-auto" style="max-width:700px;">
                    <p class="text-center">(Ici s'afficheront vos réservations. À personnaliser selon votre logique.)</p>
                </div>
            <?php elseif ($tab === 'messages'): ?>
                <h2 class="dashboard-title mb-3"><i class="fa fa-envelope-open-text me-2"></i>Messages</h2>
                <div class="card dashboard-card p-4 mx-auto" style="max-width:700px;">
                    <p class="text-center">(Ici s'afficheront vos messages. À personnaliser selon votre logique.)</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>