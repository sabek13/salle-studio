<?php
require_once 'config/database.php'; // Inclure la connexion à la base de données

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sécurise l'ID reçu

    try {
        // Préparation de la requête SQL pour supprimer l'utilisateur
        $stmt = $pdo->prepare("DELETE FROM user WHERE id_user = ?");
        $stmt->execute([$id]);

        // Redirection après suppression
        header('Location: admin.php?message=Utilisateur supprimé avec succès');
        exit;
    } catch (PDOException $e) {
        // Gestion des erreurs
        header('Location: admin.php?message=Erreur lors de la suppression');
        exit;
    }
} else {
    // Redirection si aucun ID n'est fourni
    header('Location: admin.php?message=Aucun utilisateur sélectionné');
    exit;
}
