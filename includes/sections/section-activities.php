  <section class="section-activites">
      <h2 class="text-center mb-4">Les Activités Proposées Au Studio Sport Biarritz</h2>
      <div class="text-center">
        <img src="assets/img/bg_titre.jpg" class="mb-4 mx-auto d-block" alt="Séparateur de titre">
      </div>
      <div class="container-fluid p-0">
        <div class="row g-0">
           <?php foreach ($activities  as $activity) :    ?>
            <?php include "./includes/components/activity-cards.php" ?>
            <?php endforeach; ?>
        </div>
      </div>
    </section> 