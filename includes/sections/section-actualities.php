<section class="container my-5">
      <h2 class="text-center mb-4">Nos Dernières Actualités</h2>
      <div class="text-center">
        <img src="assets/img/bg_titre.jpg" class="mb-4 mx-auto d-block" alt="Séparateur de titre">
      </div>
      <div class="row g-4">
      <?php foreach ($actualities as $actuality) :    ?>
            <?php include "./includes/components/actuality-cards.php" ?>
            <?php endforeach; ?>
        </div>
      </div>
    </section> 