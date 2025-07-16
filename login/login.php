<?php
session_start(); // Démarre la session pour pouvoir afficher des messages d'erreur ou gérer la connexion
?>

<!-- Formulaire HTML -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Salle de Sport</title>
    <style>
        /* Styles CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #fff;
            color: #333;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
            border: 2px solid #d4af37;
        }

        .logo {
            margin-bottom: 30px;
        }

        h2 {
            margin-bottom: 30px;
            color: rgb(9, 8, 8);
            font-size: 21px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-size: 16px;
        }

        input {
            width: calc(100% - 30px);
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input:focus {
            border-color: #d4af37;
            outline: none;
        }

        button {
            width: 100%;
            padding: 15px;
            background-color: #d4af37;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
        }

        button:hover {
            background-color: #c19a2b;
        }

        .footer {
            margin-top: 30px;
            font-size: 16px;
            color: #aaa;
        }

        .footer a {
            color: #d4af37;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container"> <!-- Bloc principal centré -->
        <!-- Logo affiché en haut -->
        <div class="logo">
            <img src="../assets/img/logo_2.png" alt="Logo Salle de Sport" width="200">
        </div>
        <!-- Titre de la section -->
        <h2>Connexion à la Salle de Sport</h2>
        <?php if (isset($_SESSION['messageErreur'])): ?> <!-- Si une erreur existe -->
            <p class="error"><?= htmlspecialchars($_SESSION['messageErreur']) ?></p> <!-- On affiche l’erreur -->
            <?php unset($_SESSION['messageErreur']); ?> <!-- Puis on la supprime pour éviter qu’elle ne réapparaisse -->
        <?php endif; ?>
        <form method="POST" action="loginvalidation.php"> <!-- Envoie les données vers loginvalidation.php -->
            <label for="email">Email </label> <!-- Libellé de champ -->
            <input type="email" id="email" name="email" placeholder="Entrez votre email" required> <!-- Champ email -->

            <label for="mot_de_passe">Mot de passe </label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Entrez votre mot de passe" required> <!-- Champ mot de passe -->

            <button type="submit">Se connecter</button> <!-- Bouton pour envoyer le formulaire -->
        </form>
        <div class="footer">
            <p>Besoin d'aide ? Contactez-nous à <a href="mailto:support@salledesport.com">support@salledesport.com</a></p>
        </div>
    </div>
</body>

</html>