<?php
session_start(); // On démarre la session pour pouvoir enregistrer les infos de l'utilisateur connecté
require_once '../config/database.php'; // On inclut la connexion sécurisée à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validation des champs
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL); // Nettoie et valide l'email
    $motDePasse = $_POST['mot_de_passe'] ?? ''; // Récupère le mot de passe saisi
    if ($email && $motDePasse) {
        // Préparation de la requête pour éviter les injections SQL
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email_user = ?");
        $stmt->execute([$email]); // On exécute avec l'email en paramètre
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // On récupère les infos de l’utilisateur

        // Vérification du mot de passe
        if ($user && password_verify($motDePasse, $user['mot_de_passe'])) {
            session_regenerate_id(true); // On régénère l'ID de session pour plus de sécurité
            // Stockage des informations utilisateur dans la session
            $_SESSION['user'] = [
                'id_user' => $user['id_user'],
                'nom' => $user['nom_user'],
                'prenom' => $user['prenom_user'],
                'email' => $user['email_user'],
                'role' => $user['role']
            ];
            if ($user['role'] === 'administrateur') {
                $_SESSION['admin'] = true; // On note que c’est un admin
                header('Location:../admin.php'); // On l’envoie vers le tableau de bord admin
            } else {
                $_SESSION['admin'] = false; // C’est un utilisateur standard
                header('Location:../dashbord/dashbord.php'); // Redirection vers son espace
            }
            exit; // On stoppe ici
        } else {
            $_SESSION['messageErreur'] = "❌ Email ou mot de passe incorrect.";
        }
    } else {
        $_SESSION['messageErreur'] = "❌ Veuillez remplir tous les champs correctement.";
    }
    header('Location:../login/login.php');
    exit;
}
