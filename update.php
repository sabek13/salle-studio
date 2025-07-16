<?php
require_once 'config/database.php'; // Connexion PDO sécurisée
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_user') {

    // 1. Sécurisation et récupération des données
    $user_id = intval($_POST['user_id']);
    $full_name = explode(' ', trim($_POST['full_name']), 2);
    $prenom_user = htmlspecialchars($full_name[0]); // Prénom
    $nom_user = isset($full_name[1]) ? htmlspecialchars($full_name[1]) : ''; // Nom (si fourni)
    $email_user = htmlspecialchars($_POST['email']);
    $role = htmlspecialchars($_POST['role']);
    $statut = htmlspecialchars($_POST['statut']);
    var_dump($_POST); // Pour déboguer, à retirer en production
    var_dump($users);

    try {
        // 2. Requête de mise à jour SQL
        $sql = "UPDATE user SET 
                nom_user = :nom_user,
                prenom_user = :prenom_user,
                email_user = :email_user,
                role = :role,
                statut = :statut
            WHERE id_user = :id_user";

        // 3. Préparation + exécution sécurisée
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nom_user' => $nom_user,
            ':prenom_user' => $prenom_user,
            ':email_user' => $email_user,
            ':role' => $role,
            ':statut' => $statut,
            ':id_user' => $user_id
        ]);

        // 4. Redirection avec message de succès
        header("Location: admin.php?success=1&tab=users");
        exit();
    } catch (PDOException $e) {
        // 5. En cas d’erreur SQL
        header("Location: admin.php?success=1&tab=users?error=" . urlencode($e->getMessage()) . "&tab=users");
        exit();
    }
}

// Gestion des messages après redirection
if (isset($_GET['success'])) {
    $success_message = "Utilisateur modifié avec succès !";
}
if (isset($_GET['error'])) {
    $error_message = "Erreur lors de la modification : " . htmlspecialchars($_GET['error']);
}
