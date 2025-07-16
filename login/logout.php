<?php
// vider la session et rediriger vers la page de connexion
session_start();
session_unset(); // Vide toutes les variables de session
session_destroy(); // Détruit la session

// Redirige vers la page de connexion
header('Location: login.php');
exit();
