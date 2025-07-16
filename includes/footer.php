<?php
$page = basename($_SERVER['PHP_SELF'], '.php');
include_once "data.php";

// Définit BASE_URL uniquement si elle n’est pas déjà définie
if (!defined('BASE_URL')) {
  define('BASE_URL', '/php_le-studio-sport/');
}
?>

<?php if ($page === "index") : ?>
  <section class="bg-dark py-5 text-center">
    <div class="container">
      <h2 class="text-white mb-4">Studio Sport & Coaching, Nos Partenaires</h2>
      <div class="text-center">
        <img src="<?php echo BASE_URL; ?>assets/img/bg_titre.jpg" class="mb-4 mx-auto d-block" alt="Séparateur de titre">
      </div>
      <p class="text-white mb-4">
        Découvrez nos partenaires qui partagent notre passion pour le sport et le bien-être.
        En tant que membre du Studio Sport & Coaching, vous bénéficierez dans ces étabissemebt d'avantages exclusifs.
        <a class="cliquez" href="404.php">Cliquez ici</a> pour en savoir plus.
      </p>

      <div class="d-flex flex-wrap justify-content-around align-items-center gap-4">
        <?php foreach ($partners as $partner) : ?>
          <?php include "components/partner.php"; ?>
        <?php endforeach; ?>

      </div>
    </div>
  </section>
<?php endif; ?>

<?php if ($page === "contact") : ?>
  <div class="p-0">
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2911.840089032647!2d-1.5447696842339356!3d43.474529079126824!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd51153d4a6a1e9b%3A0xf1f7404f9898ec1b!2sStudio%20Sport%20et%20Coaching!5e0!3m2!1sfr!2sfr!4v1662911557560!5m2!1sfr!2sfr"
      class="w-100 border-0 m-0 p-0 map-iframe"
      allowfullscreen=""
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade">
    </iframe>
  </div>
<?php endif; ?>


<footer class="footer-main text-white">
  <?php if (!in_array($page, ['blog', 'article'])): ?>
    <img src="<?php echo BASE_URL; ?>assets/img/a304f68f1a305b88f92231d03ce3fad8e8f6098d.png" alt="banniere-footer" class="img-fluid w-100">
  <?php endif; ?>
  <div class="bg-dark py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-4 mb-4">
          <h6 class="text-uppercase fw-bold">
            <img src="<?php echo BASE_URL; ?>assets/img/logo_footer.png" alt="Logo" class="footer-logo me-2">
            À PROPOS
          </h6>
          <p>
            2018 © Studio Sport Biarritz<br>
            Salle de sport, de fitness et de crossfit à Biarritz Pays basque.<br>
            RCS : 000 000 000<br>
            <a href="404.php" class="footer-link">Mentions légales</a>
          </p>
        </div>
        <div class="col-md-4 mb-4">
          <h6 class="text-uppercase fw-bold">STUDIO SPORT CORPORATE</h6>
          <ul class="list-unstyled footer-list">
            <?php foreach ($footer_items as $footer_item) :
            // echo footer_link($footer_item['lien'], $footer_item['span']);
            endforeach; ?>
          </ul>
        </div>
        <div class="col-md-4 mb-4">
          <h6 class="text-uppercase fw-bold">FITNESS, CROSSFIT ET TRAINING AU PAYS BASQUE</h6>
          <p>
            Coach personnel de sport à Biarritz, <a href="404.php" class="footer-link">Coach personnel de sport à Anglet</a>,
            Salle de sport BAB, Fitness à Biarritz
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="bg-black py-4">
    <div class="container d-flex justify-content-center align-items-center">
      <div class="me-3">
        <p class="mb-0">Un site créé par</p>
        <strong>L'AGENCE 364 COM'</strong>
      </div>
      <img src="<?php echo BASE_URL; ?>assets/img/364.png" alt="Logo 364" class="logo-364">
    </div>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>
<script src="js/validation.js"></script>
</body>

</html>