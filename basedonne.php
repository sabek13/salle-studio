<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --light-bg: #ecf0f1;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar .nav-link {
            color: #bdc3c7;
            padding: 15px 20px;
            border-radius: 0;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--accent-color);
            transform: translateX(5px);
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .header-card {
            background: linear-gradient(135deg, var(--accent-color), #2980b9);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(52, 152, 219, 0.3);
        }

        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: none;
            transition: transform 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            margin-bottom: 15px;
        }

        .table-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: var(--light-bg);
            border: none;
            font-weight: 600;
            color: var(--primary-color);
            padding: 15px;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-color: #dee2e6;
        }

        .btn-action {
            padding: 8px 12px;
            margin: 2px;
            border-radius: 8px;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-new {
            background-color: #e8f5e8;
            color: var(--success-color);
        }

        .status-read {
            background-color: #e6f3ff;
            color: var(--accent-color);
        }

        .status-replied {
            background-color: #fff3e0;
            color: var(--warning-color);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-color), #2980b9);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .search-box {
            position: relative;
            margin-bottom: 20px;
        }

        .search-box input {
            padding-left: 45px;
            border-radius: 25px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .tab-content {
            padding-top: 20px;
        }

        .nav-tabs {
            border-bottom: 2px solid #e9ecef;
            margin-bottom: 20px;
        }

        .nav-tabs .nav-link {
            border: none;
            color: var(--secondary-color);
            font-weight: 500;
            padding: 15px 20px;
            border-radius: 10px 10px 0 0;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            background-color: var(--accent-color);
            color: white;
            border-bottom: 3px solid var(--accent-color);
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
    <nav class="sidebar">
        <div class="p-4">
            <h4 class="text-white mb-4">
                <i class="fas fa-cogs me-2"></i>
                Admin Panel
            </h4>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="#dashboard" data-bs-toggle="tab">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#contacts" data-bs-toggle="tab">
                    <i class="fas fa-envelope"></i>
                    Messages Contact
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#users" data-bs-toggle="tab">
                    <i class="fas fa-users"></i>
                    Gestion Utilisateurs
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#settings" data-bs-toggle="tab">
                    <i class="fas fa-cog"></i>
                    Paramètres
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="tab-content">
            <!-- Dashboard Tab -->
            <div class="tab-pane fade show active" id="dashboard">
                <div class="header-card">
                    <h2 class="mb-3">
                        <i class="fas fa-chart-bar me-2"></i>
                        Tableau de Bord
                    </h2>
                    <p class="mb-0">Vue d'ensemble de votre administration</p>
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

            <!-- Contacts Tab -->
            <div class="tab-pane fade" id="contacts">
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
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">JD</div>
                                            <strong>Jean Dupont</strong>
                                        </div>
                                    </td>
                                    <td>jean.dupont@email.com</td>
                                    <td>Demande d'information produit</td>
                                    <td>23 Juin 2025</td>
                                    <td><span class="status-badge status-new">Nouveau</span></td>
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
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">ML</div>
                                            <strong>Marie Leblanc</strong>
                                        </div>
                                    </td>
                                    <td>marie.leblanc@email.com</td>
                                    <td>Support technique</td>
                                    <td>22 Juin 2025</td>
                                    <td><span class="status-badge status-read">Lu</span></td>
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
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">PM</div>
                                            <strong>Pierre Martin</strong>
                                        </div>
                                    </td>
                                    <td>pierre.martin@email.com</td>
                                    <td>Réclamation commande</td>
                                    <td>21 Juin 2025</td>
                                    <td><span class="status-badge status-replied">Répondu</span></td>
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
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">SB</div>
                                            <strong>Sophie Bernard</strong>
                                        </div>
                                    </td>
                                    <td>sophie.bernard@email.com</td>
                                    <td>Partenariat commercial</td>
                                    <td>20 Juin 2025</td>
                                    <td><span class="status-badge status-new">Nouveau</span></td>
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
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">AL</div>
                                            <strong>Antoine Legrand</strong>
                                        </div>
                                    </td>
                                    <td>antoine.legrand@email.com</td>
                                    <td>Question facturation</td>
                                    <td>19 Juin 2025</td>
                                    <td><span class="status-badge status-read">Lu</span></td>
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

            <!-- Users Tab -->
            <div class="tab-pane fade" id="users">
                <div class="header-card">
                    <h2 class="mb-3">
                        <i class="fas fa-users me-2"></i>
                        Gestion des Utilisateurs
                    </h2>
                    <p class="mb-0">Gérez les comptes utilisateurs de votre plateforme</p>
                </div>

                <div class="table-container">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" class="form-control" placeholder="Rechercher un utilisateur...">
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <button class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>
                                Nouvel utilisateur
                            </button>
                            <button class="btn btn-outline-secondary">
                                <i class="fas fa-filter me-1"></i>
                                Filtrer
                            </button>
                        </div>
                    </div>

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
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">AD</div>
                                            <div>
                                                <strong>Admin Demo</strong>
                                                <br>
                                                <small class="text-muted">Administrateur</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>admin@demo.com</td>
                                    <td>
                                        <span class="badge bg-danger">Administrateur</span>
                                    </td>
                                    <td>15 Jan 2025</td>
                                    <td>
                                        <span class="badge bg-success">Actif</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-action" title="Voir profil">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-action" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-secondary btn-action" title="Suspendre">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">JD</div>
                                            <div>
                                                <strong>Jean Dupont</strong>
                                                <br>
                                                <small class="text-muted">Utilisateur standard</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>jean.dupont@email.com</td>
                                    <td>
                                        <span class="badge bg-primary">Utilisateur</span>
                                    </td>
                                    <td>10 Mars 2025</td>
                                    <td>
                                        <span class="badge bg-success">Actif</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-action" title="Voir profil">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-action" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-action" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">ML</div>
                                            <div>
                                                <strong>Marie Leblanc</strong>
                                                <br>
                                                <small class="text-muted">Modératrice</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>marie.leblanc@email.com</td>
                                    <td>
                                        <span class="badge bg-info">Modérateur</span>
                                    </td>
                                    <td>22 Fév 2025</td>
                                    <td>
                                        <span class="badge bg-success">Actif</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-action" title="Voir profil">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-action" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-action" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">PM</div>
                                            <div>
                                                <strong>Pierre Martin</strong>
                                                <br>
                                                <small class="text-muted">Utilisateur standard</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>pierre.martin@email.com</td>
                                    <td>
                                        <span class="badge bg-primary">Utilisateur</span>
                                    </td>
                                    <td>05 Avril 2025</td>
                                    <td>
                                        <span class="badge bg-warning">Suspendu</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-action" title="Voir profil">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-success btn-action" title="Réactiver">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-danger btn-action" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">SB</div>
                                            <div>
                                                <strong>Sophie Bernard</strong>
                                                <br>
                                                <small class="text-muted">Utilisateur standard</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>sophie.bernard@email.com</td>
                                    <td>
                                        <span class="badge bg-primary">Utilisateur</span>
                                    </td>
                                    <td>18 Mai 2025</td>
                                    <td>
                                        <span class="badge bg-success">Actif</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-action" title="Voir profil">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-action" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-action" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
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

            <!-- Settings Tab -->
            <div class="tab-pane fade" id="settings">
                <div class="header-card">
                    <h2 class="mb-3">
                        <i class="fas fa-cog me-2"></i>
                        Paramètres
                    </h2>
                    <p class="mb-0">Configuration générale de l'administration</p>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="table-container">
                            <h5 class="mb-4">
                                <i class="fas fa-envelope me-2"></i>
                                Configuration Email
                            </h5>
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Email administrateur</label>
                                    <input type="email" class="form-control" value="admin@example.com">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Réponse automatique</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">Activer</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Message automatique</label>
                                    <textarea class="form-control" rows="3">Merci pour votre message. Nous vous répondrons dans les plus brefs délais.</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>
                                    Sauvegarder
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="table-container">
                            <h5 class="mb-4">
                                <i class="fas fa-shield-alt me-2"></i>
                                Sécurité
                            </h5>
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Authentification à deux facteurs</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox">
                                        <label class="form-check-label">Activer 2FA</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Durée de session (minutes)</label>
                                    <input type="number" class="form-control" value="60">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tentatives de connexion max</label>
                                    <input type="number" class="form-control" value="5">
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>
                                    Sauvegarder
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="table-container">
                            <h5 class="mb-4">
                                <i class="fas fa-database me-2"></i>
                                Sauvegarde et Maintenance
                            </h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card border-success mb-3">
                                        <div class="card-body text-center">
                                            <i class="fas fa-download fa-2x text-success mb-2"></i>
                                            <h6>Sauvegarde complète</h6>
                                            <p class="text-muted small">Dernière: 22 Juin 2025</p>
                                            <button class="btn btn-success btn-sm">
                                                <i class="fas fa-download me-1"></i>
                                                Sauvegarder
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-warning mb-3">
                                        <div class="card-body text-center">
                                            <i class="fas fa-broom fa-2x text-warning mb-2"></i>
                                            <h6>Nettoyage cache</h6>
                                            <p class="text-muted small">Dernier: 23 Juin 2025</p>
                                            <button class="btn btn-warning btn-sm">
                                                <i class="fas fa-broom me-1"></i>
                                                Nettoyer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-info mb-3">
                                        <div class="card-body text-center">
                                            <i class="fas fa-chart-bar fa-2x text-info mb-2"></i>
                                            <h6>Optimisation DB</h6>
                                            <p class="text-muted small">Dernière: 20 Juin 2025</p>
                                            <button class="btn btn-info btn-sm">
                                                <i class="fas fa-cogs me-1"></i>
                                                Optimiser
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
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
                    <button type="button" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>
                        Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de visualisation message -->
    <div class="modal fade" id="viewMessageModal" tabindex="-1">
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

    <!-- Modal d'édition utilisateur -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
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
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        Sauvegarder
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts Bootstrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

    <script>
        // JavaScript pour les interactions
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
                        if (text.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
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
                    e.preventDefault();
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

                if (isHidden) {
                    sidebar.style.transform = 'translateX(0)';
                } else {
                    sidebar.style.transform = 'translateX(-100%)';
                }
            });
        });
    </script>
</body>

</html>