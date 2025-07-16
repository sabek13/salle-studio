<?php
$pageTitle = "Présentation  Studio Sport";
$metaDescription = "Présentation";
include "./includes/header.php";
$base_url = "http://localhost:8888/php_le-studio-sport";
?>

<!-- TITRE PRINCIPAL -->
<section class="section-intro bg-white py-5">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 class="section-title text-center mb-4">LE TRAINING FONCTIONNEL</h2>
      </div>

      <!-- Texte gauche -->
      <div class="col-md-6 d-flex flex-column justify-content-center">
        <div class="section-text">
          <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur...</p>
          <p>Exceptur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium...</p>
          <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet.</p>
        </div>
        <div class="d-flex gap-3 mt-4">
          <a href="404.php" class="btn btn-gold">VOIR NOS OFFRES ET FORMULES</a>
          <a href="contact.php" class="btn btn-gold">CONTACT ET RÉSERVATION</a>
        </div>
      </div>

      <!-- Carousel droite -->
      <div class="col-md-6 d-flex align-items-center">
        <div id="carouselActivite" class="carousel slide w-100" data-bs-ride="carousel">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselActivite" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselActivite" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselActivite" data-bs-slide-to="2" aria-label="Slide 3"></button>
          </div>
          <div class="carousel-inner rounded shadow">
            <div class="carousel-item active">
              <img src="assets/img/activites/bg_activite_1.jpg" class="d-block w-100 h-auto" alt="Activité 1">
            </div>
            <div class="carousel-item">
              <img src="assets/img/activites/bg_activite_2.jpg" class="d-block w-100 h-auto" alt="Activité 2">
            </div>
            <div class="carousel-item">
              <img src="assets/img/activites/bg_activite_4.jpg" class="d-block w-100 h-auto" alt="Activité 3">
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Ateliers -->
<section class="activites py-5">
  <div class="container">
    <h2 class="section-title text-center">LES ATELIERS PRÉSENTS DANS LE TRAINING FONCTIONNEL</h2>
    <div class="row text-center g-4">

      <!-- TRX CORE -->
      <div class="col-md-3">
        <div class="activite" data-bs-toggle="modal" data-bs-target="#modalTrxcore">
          <img src="assets/img/trx_core.jpg" alt="TRX CORE" class="img-fluid activite-img mb-3">
          <h3 class="h5 fw-bold">TRX CORE</h3>
          <p>
            Ce cours a pour but d'améliorer votre force fonctionnelle ainsi que votre mobilité à l'aide de sangles en suspension.<br>
            L’accent est mis sur le CORE (centre du corps) afin d’obtenir un gainage, une sangle abdominale résistante à toute épreuve et un renforcement musculaire.<br>
            En complément, des automassages et des exercices de mobilité et d’étirements sont également présents dans ce cours.
          </p>
          <p><strong>Durée :</strong> 45 minutes</p>
        </div>
      </div>

      <!-- BOXE -->
      <div class="col-md-3">
        <div class="activite" data-bs-toggle="modal" data-bs-target="#modalBoxe">
          <img src="assets/img/boxe.jpg" alt="Boxe" class="img-fluid activite-img mb-3">
          <h3 class="h5 fw-bold">BOXE</h3>
          <p>
            Ici un seul mot d’ordre : se défouler !<br>
            Mélange de karaté, de boxe, de kick boxing et de MMA, le cours se déroule face à un sac de frappe, gants aux poings et accompagné de petits matériels : corde à sauter, slam ball…<br>
            L’objectif ici est d’améliorer vos qualités de résistance à l’effort, de vitesse, de coordination et d’agilité.
          </p>
          <p><strong>Durée :</strong> 30 minutes</p>
        </div>
      </div>

      <!-- HIIT -->
      <div class="col-md-3">
        <div class="activite" data-bs-toggle="modal" data-bs-target="#modalHiit">
          <img src="assets/img/hiit.jpg" alt="HIIT" class="img-fluid activite-img mb-3">
          <h3 class="h5 fw-bold">HIIT</h3>
          <p>
            Le HIIT est l’acronyme de High Intensity Interval training en anglais.<br>
            Cet entraînement à haute intensité réalisé avec le poids du corps, alterne périodes d’efforts courts et intenses et période de récupération active, dans le but de brûler un maximum de calories.
          </p>
          <p><strong>Durée :</strong> 30 minutes</p>
        </div>
      </div>

      <!-- TRX FUSION -->
      <div class="col-md-3">
        <div class="activite" data-bs-toggle="modal" data-bs-target="#modalTrxFusion">
          <img src="assets/img/trx_fusion.jpg" alt="TRX FUSION" class="img-fluid activite-img mb-3">
          <h3 class="h5 fw-bold">TRX FUSION</h3>
          <p>
            Un excellent programme pour travailler l’ensemble du corps et transpirer à grosses gouttes.<br>
            Grâce à des exercices d’une intensité allant de modérée à forte, vous allez sculpter et tonifier votre corps tout en perdant du poids.<br>
            Dans cet atelier, vous utiliserez des sangles de TRX et des accessoires comme le Kettlebell, le Slamball ou le ViPR.<br>
            Votre mental et votre système cardio-vasculaire seront mis à rudes épreuves !
          </p>
          <p><strong>Durée :</strong> 30 minutes</p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- MODALE TRX CORE -->
<div class="modal fade" id="modalTrxcore" tabindex="-1" aria-labelledby="modalTrxcoreLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-4">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTrxcoreLabel">TRX CORE</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <p>Ce cours a pour but d'améliorer votre force fonctionnelle ainsi que votre mobilité à l'aide de sangles en suspension. L’accent est mis sur le CORE (centre du corps) afin d’obtenir un gainage, une sangle abdominale résistante à toute épreuve et un renforcement musculaire. En complément, des automassages et des exercices de mobilité et d’étirements sont également présents dans ce cours.</p>
      </div>
    </div>
  </div>
</div>

<!-- MODALE BOXE -->
<div class="modal fade" id="modalBoxe" tabindex="-1" aria-labelledby="modalBoxeLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-4">
      <div class="modal-header">
        <h5 class="modal-title" id="modalBoxeLabel">BOXE</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <p>Ici un seul mot d’ordre : se défouler ! Mélange de karaté, de boxe, de kick boxing et de MMA, le cours se déroule face à un sac de frappe, gants aux poings et accompagné de petits matériels : corde à sauter, slam ball… L’objectif ici est d’améliorer vos qualités de résistance à l’effort, de vitesse, de coordination et d’agilité.</p>
      </div>
    </div>
  </div>
</div>

<!-- MODALE HIIT -->
<div class="modal fade" id="modalHiit" tabindex="-1" aria-labelledby="modalHiitLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-4">
      <div class="modal-header">
        <h5 class="modal-title" id="modalHiitLabel">HIIT</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <p>Le HIIT est l’acronyme de High Intensity Interval training en anglais. Cet entraînement à haute intensité réalisé avec le poids du corps, alterne périodes d’efforts courts et intenses et période de récupération active, dans le but de brûler un maximum de calories.</p>
      </div>
    </div>
  </div>
</div>

<!-- MODALE TRX FUSION -->
<div class="modal fade" id="modalTrxFusion" tabindex="-1" aria-labelledby="modalTrxFusionLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-4">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTrxFusionLabel">TRX FUSION</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <p>Un excellent programme pour travailler l’ensemble du corps et transpirer à grosses gouttes. Grâce à des exercices d’une intensité allant de modérée à forte, vous allez sculpter et tonifier votre corps tout en perdant du poids. Dans cet atelier, vous utiliserez des sangles de TRX et des accessoires comme le Kettlebell, le Slamball ou le ViPR. Votre mental et votre système cardio-vasculaire seront mis à rudes épreuves !</p>
      </div>
    </div>
  </div>
</div>

<!-- SÉPARATEUR GRIS -->
<div class="container">
  <hr class="separator my-5">
</div>

<!-- SECTION : Activités proposées au Studio Sport Biarritz -->
<section class="activites ">
  <div class="container text-center">
    <h2 class="section-title">LES ACTIVITÉS PROPOSÉES AU STUDIO SPORT BIARRITZ</h2>
  </div>
</section>
<?php
include "./includes/footer.php";
?>