<?php
// 📝 Informations de connexion
$serveur = 'localhost';
$port = '3306'; // Port par défaut pour MySQL
$baseDeDonnees = 'studio';
$utilisateur = 'root';
$motDePasse = 'root';

// 🎯 Connexion avec PDO
// $pdo = new PDO("mysql:host=$serveur;port=$port;dbname=$baseDeDonnees;charset=utf8", $utilisateur, $motDePasse);

// echo "✅ Connecté à la base de données !";

try {
    // 🎯 On essaie de se connecter
    $pdo = new PDO("mysql:host=$serveur;dbname=$baseDeDonnees;charset=utf8mb4", $utilisateur, $motDePasse);

    // 🛡️ On dit à PDO d'être strict sur les erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "✅ Connexion réussie !";
} catch (PDOException $e) {
    // 🚨 Si ça ne marche pas, on affiche l'erreur
    echo "❌ Erreur : " . $e->getMessage();
    die(); // On arrête le script
}
?>

<!-- <?php
        // ✨ Ma première requête SQL avec PDO !
        $requete = "SELECT CONCAT(nom_contact, ' ', prenom_contact) AS nom_complet, email_contact, sujet, message,date_envoi, statut FROM contact";
        $resultat = $pdo->query($requete);
        // 📦 On récupère tous les résultats
        $contacts = $resultat->fetchAll();

        $requete = "SELECT id_user, nom_user, prenom_user, CONCAT(nom_user,' ',prenom_user) AS nom_complet, email_user, role, statut, dateincrip_user FROM user";
        $resultat = $pdo->query($requete);
        $users = $resultat->fetchAll();
        ?> -->

<!-- // 🔧 Construction des filtres -->
<?php
$filters = [];
$filter_params = [];
$filter_conditions = [];

// 📅 Filtre par période d'inscription
if (isset($_GET['date_filter']) && !empty($_GET['date_filter'])) {
    $date_filter = $_GET['date_filter'];
    switch ($date_filter) {
        case 'today':
            $filter_conditions[] = "DATE(dateincrip_user) = CURDATE()";
            break;
        case 'week':
            $filter_conditions[] = "dateincrip_user >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
            break;
        case 'month':
            $filter_conditions[] = "dateincrip_user >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
            break;
        case 'year':
            $filter_conditions[] = "dateincrip_user >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
            break;
    }
    $filters['date_filter'] = $date_filter;
}

// 👤 Filtre par rôle
if (isset($_GET['role_filter']) && !empty($_GET['role_filter'])) {
    $role_filter = $_GET['role_filter'];
    $filter_conditions[] = "role = :role_filter";
    $filter_params[':role_filter'] = $role_filter;
    $filters['role_filter'] = $role_filter;
}

// ✅ Filtre par statut
if (isset($_GET['status_filter']) && !empty($_GET['status_filter'])) {
    $status_filter = $_GET['status_filter'];
    $filter_conditions[] = "statut = :status_filter";
    $filter_params[':status_filter'] = $status_filter;
    $filters['status_filter'] = $status_filter;
}

// 🔤 Ordre alphabétique
$order_by = "dateincrip_user DESC"; // Par défaut
if (isset($_GET['sort']) && !empty($_GET['sort'])) {
    $sort = $_GET['sort'];
    switch ($sort) {
        case 'name_asc':
            $order_by = "nom ASC, prenom_user ASC";
            break;
        case 'name_desc':
            $order_by = "nom DESC, prenom_user DESC";
            break;
        case 'email_asc':
            $order_by = "email_user ASC";
            break;
        case 'email_desc':
            $order_by = "email_user DESC";
            break;
        case 'date_asc':
            $order_by = "dateincrip_user ASC";
            break;
        case 'date_desc':
            $order_by = "dateincrip_user DESC";
            break;
    }
    $filters['sort'] = $sort;
}

// 🛠️ Construction de la requête finale
$where_clause = '';
if (!empty($filter_conditions)) {
    $where_clause = ' WHERE ' . implode(' AND ', $filter_conditions);
}


// 📊 Récupération des utilisateurs filtrés
try {
    $sql = "SELECT id_user, 
                   nom_user,
                   prenom_user,
                   CONCAT(nom_user, ' ', prenom_user) AS full_name,
                   email_user, 
                   role, 
                   statut, 
                   dateincrip_user 
            FROM user" . $where_clause . " 
            ORDER BY " . $order_by;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($filter_params);
    $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Compter le total
    $count_sql_total = "SELECT COUNT(*) as total FROM user";
    $count_stmt_total = $pdo->prepare($count_sql_total);
    $count_stmt_total->execute();
    $total_users_db = $count_stmt_total->fetch(PDO::FETCH_ASSOC)['total'];

    // Valeurs distinctes
    $roles_sql = "SELECT DISTINCT role FROM user WHERE role IS NOT NULL ORDER BY role";
    $roles_result = $pdo->query($roles_sql);
    $available_roles = $roles_result->fetchAll(PDO::FETCH_COLUMN);

    $status_sql = "SELECT DISTINCT statut FROM user WHERE statut IS NOT NULL ORDER BY statut";
    $status_result = $pdo->query($status_sql);
    $available_status = $status_result->fetchAll(PDO::FETCH_COLUMN);

    $total_users_filtered = count($utilisateurs);
} catch (PDOException $e) {
    $error_message = "Erreur lors de la récupération des utilisateurs : " . $e->getMessage();
    $utilisateurs = [];
    $total_users_db = 0;
    $total_users_filtered = 0;
    $available_roles = [];
    $available_status = [];
}
?>