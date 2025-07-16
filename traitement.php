<?php
ob_start(); // Démarre la mise en tampon de sortie
// Démarre la session
session_start();

// Inclusion des fonctions et PHPMailer
require 'vendor/autoload.php'; // Ou le chemin vers PHPMailer
require 'functions/functions.php';


// u prépares la session pour y mettre un message de succès ou un tableau d’erreurs si besoin
$_SESSION['succes'] = '';
$_SESSION['erreurs'] = '';

// Vérifie que le formulaire a été soumis en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Si pas en POST, retour au formulaire
    header('Location: contact.php');
    exit;
}

// Récupère les données du formulaire
$nom = $_POST['nom'] ?? '';
$prenom = $_POST['prenom'] ?? '';
$telephone = $_POST['telephone'] ?? '';
$sujet = $_POST['sujet'] ?? '';
// Pour l'email, on utilise le champ email du formulaire
$email = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';
// dump($_POST);

// Nettoie les données (enlève les espaces, caractères dangereux)
$nom = trim(htmlspecialchars($nom));
$email = trim(htmlspecialchars($email));
$message = trim(htmlspecialchars($message));

$erreurs = [];
if (empty($_POST["nom"])) {
    $erreurs["nom"] = "Veuillez remplir le champ nom";
}
if (empty($_POST["prenom"])) {
    $erreurs["prenom"] = "Veuillez remplir le champ prénom";
}
if (empty($_POST["telephone"])) {
    $erreurs["telephone"] = "Veuillez remplir le champ téléphone";
}
if (empty($_POST["email"])) {
    $erreurs["email"] = "Veuillez remplir le champ email";
    // sfonction php qui sert à filter les données et verifie si c'est bien un format d'email
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erreurs["email"] = "L'email n'est pas valide";
}
if (empty($_POST["sujet"])) {
    $erreurs["sujet"] = "Veuillez remplir le champ sujet";
}
if (empty($_POST["message"])) {
    $erreurs["message"] = "Veuillez remplir le champ message";
}


// // S'il y a des erreurs
if (!empty($erreurs)) {
    $_SESSION['erreurs'] = $erreurs;
    header('Location: contact.php');
    exit;
}

// Ici tout est OK ! On peut traiter les données
// Connexion PDO
include './config/database.php';

$requete = "INSERT INTO contact (nom_contact, prenom_contact, telephone, email_contact, sujet, message) 
            VALUES ('$nom','$prenom', '$telephone','$email', '$sujet', '$message')";


// test exec
if ($pdo->exec($requete)) {
    // Tentative d'envoi de l'email
    $resultat = envoyerEmail([
        'nom' => $nom,
        'email' => $email,
        'message' => $message
    ]);
    // Gestion du résultat
    if ($resultat['success']) {
        $_SESSION['succes'] = $resultat['message'];
    } else {
        $_SESSION['erreurs'] = ['general' => $resultat['message']];
    }
    echo "✅ Message ajouté !";
} else {
    $_SESSION['erreurs'] = ['database' => 'Erreur lors de l\'enregistrement en base de données.'];
    header('Location: contact.php');
    exit;
}

// Par exemple : envoyer un email, sauvegarder en base...

// Pour l'instant, on simule juste le succès
$_SESSION['succes'] = "Merci $nom ! Votre message a été envoyé.";

// Retour au formulaire avec le message de succès
header('Location: contact.php');
exit;
ob_end_flush();



// function dump($variable)
// {
//     echo "<pre>";
//     print_r($variable);
//     echo "</pre>";
// }
