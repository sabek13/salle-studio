<?php
$page = basename($_SERVER['PHP_SELF'], '.php');
$base_url = "http://localhost:8888/php_le-studio-sport"; // URL de base
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($pageTitle) ? $pageTitle : "Titre par défaut" ?></title>
  <meta name="description" content="<?= isset($metaDescription) ? $metaDescription : "Description par défaut" ?>">
  <link rel="icon" href="<?= $base_url ?>/assets/img/favicon.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Barlow+Condensed&family=Bebas+Neue&family=MonteCarlo&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Feuilles de style locales avec URL complète -->
  <link rel="stylesheet" href="<?= $base_url ?>/css/custom-theme.css">
  <link rel="stylesheet" href="<?= $base_url ?>/css/style.css">
  <link rel="stylesheet" href="<?= $base_url ?>/css/404.css">
  <link rel="stylesheet" href="<?= $base_url ?>/css/activite.css">
  <link rel="stylesheet" href="<?= $base_url ?>/css/contact.css">
</head>

<body>
  <header class="header-main fixed-top w-100 z-3">
    <div class="nav-visible container d-flex justify-content-between align-items-center py-3">
      <!-- Logo -->
      <a href="<?= $base_url ?>/index.php" class="d-flex align-items-center text-white text-decoration-none">
        <img src="<?= $base_url ?>/assets/img/logo.png" alt="Logo Le Studio" class="logo me-2">
      </a>

      <!-- Bouton burger pour mobile -->
      <button class="btn d-lg-none text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu">
        <i class="fa fa-bars fs-4"></i>
      </button>

      <!-- Menu Desktop -->
      <nav class="d-none d-lg-flex align-items-center">
        <ul class="nav align-items-center me-4">

          <!-- L'ÉQUIPE -->
          <li class="nav-item">
            <a class="nav-link nav-link-custom text-white <?= $page === 'presentation' ? 'active' : '' ?>"
              href="<?= $base_url ?>/404.php">
              L'ÉQUIPE
            </a>
          </li>

          <!-- LES ACTIVITÉS (dropdown) -->
          <li class="nav-item dropdown">
            <a class="nav-link nav-link-custom text-white dropdown-toggle"
              href="#"
              id="activitesDropdown"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false">
              LES ACTIVITÉS
            </a>
            <ul class="dropdown-menu" aria-labelledby="activitesDropdown">
              <li><a class="dropdown-item" href="<?= $base_url ?>/activite.php">LE CYCLING</a></li>
              <li><a class="dropdown-item" href="<?= $base_url ?>/presentation.php">LE TRAINING FONCTIONNEL</a></li>
              <li><a class="dropdown-item" href="<?= $base_url ?>/activite.php">LE CROSSFIT</a></li>
              <li><a class="dropdown-item" href="<?= $base_url ?>/activite.php">PERSONAL TRAINING</a></li>
            </ul>
          </li>

          <!-- NOS OFFRES -->
          <li class="nav-item">
            <a class="nav-link nav-link-custom text-white <?= in_array($page, ['contact', 'presentation', 'activite']) ? 'active' : '' ?>"
              href="<?= $base_url ?>/404.php">
              NOS OFFRES
            </a>
          </li>

          <!-- PLANNING -->
          <li class="nav-item">
            <a class="nav-link nav-link-custom text-white <?= $page === 'contact' ? 'active' : '' ?>"
              href="<?= $base_url ?>/404.php">
              PLANNING
            </a>
          </li>

          <!-- LE BLOG -->
          <li class="nav-item">
            <a class="nav-link nav-link-custom text-white <?= $page === 'blog' ? 'active' : '' ?>"
              href="<?= $base_url ?>/blog/blog.php">
              LE BLOG
            </a>
          </li>

          <!-- CONTACT -->
          <li class="nav-item">
            <a class="nav-link nav-link-custom text-white <?= $page === 'contact' ? 'active' : '' ?>"
              href="<?= $base_url ?>/contact.php">
              CONTACT
            </a>
          </li>

          <!-- MON COMPTE -->
          <li class="nav-item dropdown">
            <a class="nav-link nav-link-custom text-white dropdown-toggle"
              href="#"
              id="accountDropdown"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false">
              MON COMPTE
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
              <li>
                <a class="dropdown-item" href="<?= $base_url ?>/login/login.php">Me connecter</a>
              </li>
              <li>
                <a class="dropdown-item" href="<?= $base_url ?>/register/register.php">M’inscrire</a>
              </li>
            </ul>
          </li>

        </ul>
      </nav>

      <!-- Réseaux sociaux -->
      <div class="d-none d-lg-flex align-items-center gap-3">
        <span class="text-white fw-bold"><i class="fa fa-mobile-phone"></i> 05 59 47 84 18</span>
        <a href="https://www.facebook.com" target="_blank" class="text-white"><i class="fa fa-facebook-f"></i></a>
        <a href="https://www.instagram.com" target="_blank" class="text-white"><i class="fa fa-instagram"></i></a>
        <a href="https://www.tripadvisor.fr" target="_blank" class="text-white"><i class="fa fa-tripadvisor"></i></a>
      </div>
    </div>

    <!-- Menu Mobile (Offcanvas) -->
    <div class="offcanvas offcanvas-end bg-dark text-white" id="offcanvasMenu">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title">
          <img src="<?= $base_url ?>/assets/img/logo.png" alt="Logo Le Studio" class="logo">
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="nav flex-column">
          <li class="nav-item mb-2"><a class="nav-link text-white" href="<?= $base_url ?>/404.php">L'ÉQUIPE</a></li>
          <li class="nav-item mb-2">
            <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#activitesCollapse">LES ACTIVITÉS</a>
            <div class="collapse" id="activitesCollapse">
              <ul class="list-unstyled ps-3">
                <li><a class="text-white text-decoration-none" href="<?= $base_url ?>/404.php">LE CYCLING</a></li>
                <li><a class="text-white text-decoration-none" href="<?= $base_url ?>/presentation.php">LE TRAINING FONCTIONNEL</a></li>
                <li><a class="text-white text-decoration-none" href="<?= $base_url ?>/404.php">LE CROSSFIT</a></li>
                <li><a class="text-white text-decoration-none" href="<?= $base_url ?>/404.php">PERSONAL TRAINING</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item mb-2"><a class="nav-link text-white" href="<?= $base_url ?>/404.php">NOS OFFRES</a></li>
          <li class="nav-item mb-2"><a class="nav-link text-white" href="<?= $base_url ?>/404.php">PLANNING</a></li>
          <li class="nav-item mb-2"><a class="nav-link text-white" href="<?= $base_url ?>/blog/blog.php">LE BLOG</a></li>
          <li class="nav-item mb-2"><a class="nav-link text-white" href="<?= $base_url ?>/contact.php">CONTACT</a></li>
          <li class="nav-item mb-2">
            <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#accountCollapse">MON COMPTE</a>
            <div class="collapse" id="accountCollapse">
              <ul class="list-unstyled ps-3">
                <li><a class="text-white text-decoration-none" href="<?= $base_url ?>/login/login.php">Me connecter</a></li>
                <li><a class="text-white text-decoration-none" href="<?= $base_url ?>/register/register.php">M’inscrire</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </header>
  <!-- page index -->
  <?php if ($page === "index") : ?>
    <section id="accueil-slider">
      <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <div class="carousel-inner">
          <div class="carousel-item active slide-1">
            <div class="carousel-caption">
              <p class="slider-subtitle">2 inscriptions simultanées = un 3ème abonnement de 6 mois offert !</p>
              <a href="404.php" class="btn-activite">Plus d'infos</a>
            </div>
          </div>

          <div class="carousel-item slide-2">
            <div class="carousel-caption">
              <h2 class="slider-title">DES ÉQUIPEMENTS HAUT DE GAMME</h2>
              <p class="slider-subtitle">Cardio, muscu, cycling, training fonctionnel... tout ce qu'il faut pour performer.</p>
              <a href="404.php" class="btn-activite">Voir les équipements</a>
            </div>
          </div>

          <div class="carousel-item slide-3">
            <div class="carousel-caption">
              <h2 class="slider-title">UN ACCOMPAGNEMENT SUR-MESURE</h2>
              <p class="slider-subtitle">Coaching personnalisé adapté à vos objectifs et votre rythme de vie.</p>
              <a href="404.php" class="btn-activite">Découvrir nos coachs</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <!-- page presentation -->
  <?php if ($page === "presentation") : ?>
    <div class="banner-training"></div>
  <?php endif; ?>

  <!-- page contact -->
  <?php if ($page === "contact") : ?>
    <div class="contact-hero"></div>
  <?php endif; ?>
  <!-- page 404 -->
  <?php if ($page === "404") : ?>
    <div class="d-flex flex-column min-vh-100 bg-dark text-white"></div>
  <?php endif; ?>
  <!--page blog -->
  <?php if ($page === "blog") : ?>
    <div class="blog-hero"></div>
  <?php endif; ?>
  <!-- page article -->
  <?php if ($page === "article") : ?>
    <div class="article-hero"></div>
  <?php endif; ?>

  <!-- Script Bootstrap obligatoire -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>