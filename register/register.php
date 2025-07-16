<?php
session_start();
// include '../config/database.php';


$messageErreur = "";

?>

<!-- Formulaire HTML -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Salle de Sport</title>
    <style>
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
            /* Augmentation de l'espace interne */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            /* Augmentation de la largeur */
            text-align: center;
            border: 2px solid #d4af37;
            /* Bordure dorée */
        }

        .logo {
            margin-bottom: 30px;
            /* Augmentation de l'espace sous le logo */
        }

        h2 {
            margin-bottom: 30px;
            /* Augmentation de l'espace sous le titre */
            color: rgb(9, 8, 8);
            /* Texte doré */
            font-size: 21px;
            /* Taille de police plus grande */
        }

        .error {
            color: #e74c3c;
            font-weight: bold;
            margin-bottom: 20px;
            /* Augmentation de l'espace sous le message d'erreur */
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
            /* Augmentation de l'espace sous le label */
            color: #333;
            font-size: 16px;
            /* Taille de police plus grande */
        }

        input {
            width: calc(100% - 30px);
            /* Réduction de la largeur pour ajouter de l'espace */
            padding: 15px;
            /* Augmentation de la hauteur des champs */
            margin-bottom: 20px;
            /* Augmentation de l'espace entre les champs */
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            /* Taille de police plus grande */
        }

        input:focus {
            border-color: #d4af37;
            /* Focus doré */
            outline: none;
        }

        button {
            width: 100%;
            padding: 15px;
            /* Augmentation de la hauteur du bouton */
            background-color: #d4af37;
            /* Bouton doré */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            /* Taille de police plus grande */
        }

        button:hover {
            background-color: #c19a2b;
            /* Couleur dorée plus foncée au survol */
        }

        .footer {
            margin-top: 30px;
            /* Augmentation de l'espace au-dessus du footer */
            font-size: 16px;
            /* Taille de police plus grande */
            color: #aaa;
        }

        .footer a {
            color: #d4af37;
            /* Lien doré */
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <img src="../assets/img/logo_2.png" alt="Logo Salle de Sport" width="200"> <!-- Augmentation de la taille du logo -->
        </div>

        <h2>Inscription à la Salle de Sport</h2>
        <?php if ($messageErreur): ?>
            <p class="error"><?= htmlspecialchars($messageErreur) ?></p>
        <?php endif; ?>
        <form method="POST" action="registervalidation.php">
            <label for="nom">Nom</label>
            <input type="nom" id="email" name="nom" placeholder="Entrez votre nom" required>

            <label for="prenom">Prenom</label>
            <input type="prenom" id="prenom" name="prenom" placeholder="Entrez votre prenom" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Entrez votre email" required>

            <label for="mot_de_passe">Mot de passe </label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Entrez votre mot de passe" required>

            <button type="submit">S'inscrire</button>
        </form>
        <div class="footer">
            <p>Besoin d'aide ? Contactez-nous à <a href="mailto:support@salledesport.com">support@salledesport.com</a></p>
        </div>
    </div>
</body>

</html>