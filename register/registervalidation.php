<?php
// Démarre la session
session_start();

// ✨ Chargement de PHPMailer (juste ici)
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



// u prépares la session pour y mettre un message de succès ou un tableau d’erreurs si besoin
$_SESSION['succes'] = '';
$_SESSION['erreurs'] = '';

// Vérifie que le formulaire a été soumis en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Si pas en POST, retour au formulaire
    // header('Location:contact.php');
    // exit;
}

// Récupère les données du formulaire
$nom = $_POST['nom'] ?? '';
$prenom = $_POST['prenom'] ?? '';
// Pour l'email, on utilise le champ email du formulaire
$email = $_POST['email'] ?? '';
$password = $_POST['mot_de_passe'] ?? '';

$password_hash = password_hash($password, PASSWORD_DEFAULT);


// Nettoie les données (enlève les espaces, caractères dangereux)
$nom = trim(htmlspecialchars($nom));
$prenom = trim(htmlspecialchars($prenom));
$email = trim(htmlspecialchars($email));


$erreurs = [];
if (empty($_POST["nom"])) {
    $erreurs["nom"] = "Veuillez remplir le champ nom";
}
if (empty($_POST["prenom"])) {
    $erreurs["prenom"] = "Veuillez remplir le champ prénom";
}
if (empty($_POST["email"])) {
    $erreurs["email"] = "Veuillez remplir le champ email";
    // sfonction php qui sert à filter les données et verifie si c'est bien un format d'email
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erreurs["email"] = "L'email n'est pas valide";
}
if (empty($_POST["mot_de_passe"])) {
    $erreurs["mot_de_passe"] = "Veuillez remplir le champ mot de passe";
}



// // S'il y a des erreurs
if (!empty($erreurs)) {
    $_SESSION['erreurs'] = $erreurs;
    header('Location: ../contact.php');
    exit;
}

// Ici tout est OK ! On peut traiter les données
// Connexion PDO
include '../config/database.php';
//
$requete = "INSERT INTO user (nom_user, prenom_user, email_user,mot_de_passe)
            VALUES ('$nom','$prenom','$email', '$password_hash')";


// test exec
if ($pdo->exec($requete)) {
    // header('Location: ../login/login.php');
} else {
    $_SESSION['erreurs'] = ['database' => 'Erreur lors de l\'enregistrement en base de données.'];
    //     header('Location: ../contact.php');
    //     exit;
    // }

    // Par exemple : envoyer un email, sauvegarder en base...

    // Pour l'instant, on simule juste le succès
    $_SESSION['succes'] = "Merci $nom ! Votre message a été envoyé.";

    // Retour au formulaire avec le message de succès
    // header('Location: ../contact.php');
    // exit;

    // function dump($variable)
    // {
    //     echo "<pre>";
    //     print_r($variable);
    //     echo "</pre>";
    // }
}
