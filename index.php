<?php
include_once "./functions/functions.php";
$pageTitle = "Accueil Studio Sport";
$metaDescription = "Bienvenue sur le site";
include_once "./includes/data.php";
include "./includes/header.php";
$base_url = "http://localhost:8888/php_le-studio-sport";
?>
<!-- PRÉSENTATION -->

<section class="container my-5">
  <h2 class="text-center mb-4">Le Studio Sport & Coaching, Salle de sport, Fitness et crossfit à Biarritz</h2>
  <div class="text-center">
    <img src="assets/img/bg_titre.jpg" class="mb-4 mx-auto d-block" alt="Séparateur de titre">
  </div>
  <p>Aujourd'hui beaucoup de salles de sport vendent des abonnements où vous avez accès à tous les services du club (cours collectifs, plateau musculation…) mais combien vous connaissent au point de connaître vos objectifs et de savoir si vous êtes en bonne voie pour les atteindre ?</p>
  <p>Beaucoup de gens estiment être livrés à eux-mêmes dans ce genre de salle. Nous avons choisi la direction diamétralement opposée ! Notre seule priorité ? La qualité du Service. Notre nouveau concept de salle de sport SUR MESURE trouve une solution adaptée à votre budget et vos disponibilités. Nous œuvrons pour créer une ambiance conviviale tout en vous aidant à vous dépasser dans l'effort et ce, pour maximiser vos chances d'obtenir des résultats.</p>
  <p>Voulez plus de Motivation, plus de Résultats, plus vite… Alors bienvenue au Studio Sport & Coaching !</p>
</section>

<?php include "./includes/sections/section-activities.php"; ?>


<?php include "./includes/sections/section-actualities.php"; ?>


<?php
include "./includes/footer.php";
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
</script>