<?php
session_start();
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['administrateur', 'moderateur'])) {
    die('⛔ Accès refusé. Vous devez être connecté en tant qu’administrateur ou modérateur.');
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Tableau de bord – Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- STYLE PERSONNALISÉ DIRECTEMENT INTÉGRÉ -->
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        .sidebar {
            background-color: #1f1f1f;
            color: #fff;
            width: 220px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px 10px;
        }

        .sidebar h2 {
            font-size: 20px;
            margin-bottom: 30px;
            text-align: center;
        }

        .sidebar a {
            display: block;
            padding: 12px;
            color: #eee;
            text-decoration: none;
            margin: 10px 0;
            border-left: 4px solid transparent;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #333;
            border-left: 4px solid #C9A659;
        }

        .main {
            margin-left: 240px;
            padding: 40px 30px;
        }

        h1 {
            font-size: 26px;
            color: #1a1a1a;
            margin-bottom: 30px;
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .card {
            background-color: #fff;
            border-radius: 12px;
            padding: 20px 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .card h3 {
            font-size: 18px;
            margin-bottom: 8px;
            color: #222;
        }

        .card p {
            font-size: 14px;
            margin-bottom: 18px;
            color: #555;
        }

        .card a {
            display: inline-block;
            padding: 10px 18px;
            background-color: #C9A659;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .card a:hover {
            background-color: #b89248;
        }

        @media (max-width: 768px) {
            .main {
                margin-left: 0;
                padding: 20px;
            }

            .sidebar {
                position: static;
                width: 100%;
                height: auto;
            }

            .card-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>Tableau de bord</h2>
        <a href="admin.php">Dashboard</a>
        <a href="messages.php">Messages</a>
        <a href="users.php">Utilisateurs</a>
        <a href="admin-blog.php">Blog</a>
        <a href="settings.php">Paramètres</a>
    </div>

    <div class="main">
        <h1>Bienvenue sur votre espace admin</h1>

        <div class="card-grid">
            <div class="card">
                <h3>📬 Derniers messages</h3>
                <p>Gérez les messages reçus depuis le formulaire de contact.</p>
                <a href="messages.php">Voir les messages</a>
            </div>

            <div class="card">
                <h3>📝 Gestion du blog</h3>
                <p>Ajoutez, modifiez ou supprimez des articles de blog.</p>
                <a href="admin-blog.php">Gérer les articles</a>
            </div>

            <div class="card">
                <h3>👥 Utilisateurs</h3>
                <p>Consultez ou modifiez les rôles et profils utilisateurs.</p>
                <a href="users.php">Voir les utilisateurs</a>
            </div>

            <div class="card">
                <h3>⚙️ Paramètres</h3>
                <p>Configurez les options de votre site ou du tableau de bord.</p>
                <a href="settings.php">Configurer</a>
            </div>
        </div>
    </div>

</body>

</html>