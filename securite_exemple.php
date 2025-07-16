<?php
// =========================
// EXEMPLE DE SECURITE PHP
// =========================

session_start();

// 1. Protection CSRF (token sur tous les formulaires)
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// 2. Validation côté serveur (exemple pour un formulaire de contact)
$erreurs = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF check
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('⛔ CSRF token invalide');
    }
    // Validation stricte
    $nom = trim($_POST['nom'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $message = trim($_POST['message'] ?? '');
    if ($nom === '') $erreurs['nom'] = 'Nom requis';
    if (!$email) $erreurs['email'] = 'Email invalide';
    if ($message === '') $erreurs['message'] = 'Message requis';

    // 3. Échappement des données (XSS)
    $nom = htmlspecialchars($nom);
    $message = htmlspecialchars($message);

    // 4. Requêtes préparées (PDO)
    if (empty($erreurs)) {
        require 'config/database.php';
        $stmt = $pdo->prepare('INSERT INTO contact (nom_contact, email_contact, message) VALUES (?, ?, ?)');
        $stmt->execute([$nom, $email, $message]);
    }
}

// 5. Validation d'upload (type MIME, extension, taille)
if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] === 0) {
    $allowedExts = ['jpg', 'jpeg', 'png', 'pdf'];
    $allowedMime = ['image/jpeg', 'image/png', 'application/pdf'];
    $ext = strtolower(pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION));
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['fichier']['tmp_name']);
    finfo_close($finfo);
    if (!in_array($ext, $allowedExts) || !in_array($mime, $allowedMime)) {
        die('⛔ Fichier non autorisé');
    }
    if ($_FILES['fichier']['size'] > 2 * 1024 * 1024) {
        die('⛔ Fichier trop volumineux');
    }
    move_uploaded_file($_FILES['fichier']['tmp_name'], 'uploads/' . uniqid() . '.' . $ext);
}

// 6. Contrôle d'accès (exemple)
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'utilisateur') {
    header('Location: login.php');
    exit;
}

// 7. Sessions sécurisées
// Régénération d'ID après login (à faire dans le script de connexion)
// session_regenerate_id(true);
// Timeout (exemple)
if (isset($_SESSION['LAST_ACTIVITY']) && time() - $_SESSION['LAST_ACTIVITY'] > 1800) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();

// 8. Filtrage TinyMCE (whitelist des balises)
function filtrer_html_tinymce($html)
{
    // Autorise seulement certaines balises
    return strip_tags($html, '<p><b><i><ul><ol><li><a><strong><em>');
}

// =========================
// FORMULAIRE EXEMPLE
// =========================
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Sécurité PHP - Démo</title>
</head>

<body>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
        <label>Nom : <input type="text" name="nom"></label><br>
        <label>Email : <input type="email" name="email"></label><br>
        <label>Message : <textarea name="message"></textarea></label><br>
        <label>Fichier : <input type="file" name="fichier"></label><br>
        <button type="submit">Envoyer</button>
    </form>
</body>

</html>