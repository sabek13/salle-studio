<?php
$pageTitle       = "404 | Studio Sport";
$metaDescription = "Page d'erreur";
$base_url        = "http://localhost:8888/php_le-studio-sport";
$page            = basename($_SERVER['PHP_SELF'], '.php');
include "./includes/header.php";
?>

<main
  class="bg-dark text-white d-flex flex-column justify-content-center align-items-center text-center"
  style="position: absolute;top: 80px;bottom: 0;left: 0;right: 0;">
  <img
    src="<?= $base_url ?>/assets/img/404_sport.png"
    alt="Erreur 404"
    class="img-fluid mb-4"
    style="max-width:300px;">
  <h1 class="display-4 fw-bold mb-3">Oups, cette page n'existe pas !</h1>
  <p class="lead mb-4">
    Tu es peut-être en train de faire une erreur de parcours…<br>
    mais ne t’inquiète pas, ça arrive même aux meilleurs sportifs 🏋️‍♂️
  </p>
  <a href="<?= $base_url ?>/index.php" class="btn btn-warning btn-lg">
    Revenir à l'accueil
  </a>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>