<?php
require_once 'includes/data.php';
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$base_url = "http://localhost:8888/php_le-studio-sport";
$pageTitle = "Contact | Studio Sport";
$metaDescription = "Contactez-nous pour plus d'informations";
include "./includes/header.php";
// Démarre la session si pas déjà déclarer ailleurs

?>

<!-- FORMULAIRE + COORDONNÉES -->
<section class="container-fluid bg-white shadow py-5 px-4">
  <div class="row w-75 m-auto">
    <!-- Coordonnées -->
    <div class="col-md-6 mb-4" id="contact-info">
      <h5 class="text-uppercase fw-bold position-relative pb-2 mb-4 title-underline">Nos coordonnées</h5>
      <p><strong><?= $contact['nom'] ?></strong></p>
      <p><?= $contact['adresse'] ?></p>
      <p><?= $contact['code_postal'] ?> <?= $contact['ville'] ?></p>
      <p><strong>Téléphone :</strong></p>
      <p><?= $contact['telephone'] ?></p>
      <p><strong>Horaires :</strong></p>
      <p><?= $contact['horaires_semaine'] ?></p>
      <p><?= $contact['horaires_samedi'] ?></p>
      <p><strong>Email :</strong></p>
      <p><?= $contact['email'] ?></p>
      <p>ou via ce formulaire</p>
    </div>
    <!-- Formulaire -->
    <div class="col-md-6 mb-4">
      <h5 class="text-uppercase fw-bold position-relative pb-2 mb-4 title-underline">Formulaire de contact</h5>
      <form id="contactForm" action="traitement.php" method="POST">
        <?php // Affichage des messages de succès ou d'erreur
        if (isset($_SESSION['succes'])) : ?>
          <div class="alert alert-success">
            <?php echo $_SESSION['succes']; ?>
          </div>
        <?php unset($_SESSION['succes']);
        endif; ?>
        <div class="row mb-3">
          <div class="mb-3">
            <label for="nom" class="form-label">Nom :</label>
            <input type="text" name="nom" id="nom" class="form-control">
            <?php if (isset($erreurs['nom'])) :  ?>
              <div class="alert alert-danger">
                <?php echo $erreurs['nom']; ?>
              </div>
            <?php endif   ?>
          </div>

          <div class="col">
            <input type="text" name="prenom" class="form-control bg-light border-0 rounded-0 py-3" placeholder="Votre prénom" required>
            <!--  si une erreur existe pour le prénom, si oui affiche un message d’erreur  -->
            <?php if (isset($erreurs['prenom'])) :  ?>
              <div class="alert alert-danger">
                <?php echo $erreurs['prenom']; ?>
              </div>
            <?php endif   ?>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col">
            <input type="tel" name="telephone" class="form-control bg-light border-0 rounded-0 py-3" placeholder="Votre téléphone" required>
            <?php if (isset($erreurs['telephone'])) :  ?>
              <div class="alert alert-danger">
                <?php echo $erreurs['telephone']; ?>
              </div>
            <?php endif  ?>
          </div>
          <div class="col">
            <input type="email" name="email" class="form-control bg-light border-0 rounded-0 py-3" placeholder="Votre email" required>
            <?php if (isset($erreurs['email'])) :  ?>
              <div class="alert alert-danger">
                <?php echo $erreurs['email']; ?>
              </div>
            <?php endif   ?>
          </div>
        </div>
        <div class="mb-3">
          <input type="text" name="sujet" class="form-control bg-light border-0 rounded-0 py-3" placeholder="Sujet" required>
          <?php if (isset($erreurs['sujet'])) :  ?>
            <div class="alert alert-danger">
              <?php echo $erreurs['sujet']; ?>
            </div>
          <?php endif   ?>
        </div>
        <div class="mb-4">
          <textarea name="message" class="form-control bg-light border-0 rounded-0 py-3" rows="5" placeholder="Votre message" required></textarea>
          <?php if (isset($erreurs['message'])) :  ?>
            <div class="alert alert-danger">
              <?php echo $erreurs['message']; ?>
            </div>
          <?php endif   ?>
        </div>
        <button type="submit" class="btn-gold">Envoyer</button>
      </form>
    </div>
  </div>
</section>
<?php
include "./includes/footer.php";
?>

<!-- GOOGLE MAP -->