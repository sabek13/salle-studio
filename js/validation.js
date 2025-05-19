document.addEventListener('DOMContentLoaded', function() {
  // Sélection du formulaire
  const contactForm = document.querySelector('.col-md-6.mb-4 form');
  if (!contactForm) return; // Sortir si le formulaire n'existe pas

  // Récupération des champs du formulaire
  const nomInput = contactForm.querySelector('input[placeholder="Votre nom"]');
  const prenomInput = contactForm.querySelector('input[placeholder="Votre prénom"]');
  const telephoneInput = contactForm.querySelector('input[placeholder="Votre téléphone"]');
  const emailInput = contactForm.querySelector('input[placeholder="Votre email"]');
  const sujetInput = contactForm.querySelector('input[placeholder="Sujet"]');
  const messageInput = contactForm.querySelector('textarea[placeholder="Votre message"]');

  // Tableau des inputs pour la création des conteneurs d'erreur
  const inputs = [nomInput, prenomInput, telephoneInput, emailInput, sujetInput, messageInput];
  
  // Regex optimisées selon vos spécifications
  const patterns = {
    // Nom/Prénom: commence par une lettre (maj ou min, avec ou sans accent)
    // Puis autorise lettres, accents, espaces, tirets, apostrophes
    nomPrenom: /^[A-Za-zÀ-ÖØ-öø-ÿ][A-Za-zÀ-ÖØ-öø-ÿ\s\-']{0,29}$/,
    
    // Téléphone: uniquement des chiffres de 0 à 9 min 10 max 15
    telephone: /^[0-9]{10,15}$/,
    
    // Email: lettres, chiffres, accents, uniquement @ comme caractère spécial
    email: /^[A-Za-zÀ-ÖØ-öø-ÿ0-9._%+-]+@[A-Za-zÀ-ÖØ-öø-ÿ0-9.-]+\.[A-Za-z]{2,}$/,
    
    // Sujet et message: tout sauf balises et caractères spéciaux interdits
    texte: /^[^<>&*{}\[\]]+$/
  };

  // Fonction pour créer les conteneurs de messages d'erreur
  function createErrorContainers(inputs) {
    inputs.forEach(input => {
      if (!input) return; // Ignorer les champs non trouvés
      
      // Créer le conteneur d'erreur s'il n'existe pas déjà
      let errorContainer = input.nextElementSibling;
      if (!errorContainer || !errorContainer.classList.contains('error-message')) {
        errorContainer = document.createElement('div');
        errorContainer.className = 'error-message';
        
        // Insérer après l'input
        if (input.parentNode) {
          input.parentNode.insertBefore(errorContainer, input.nextSibling);
        }
      }
    });
  }

  // Créer les conteneurs d'erreurs
  createErrorContainers(inputs);

  // Configuration de la validation pour chaque champ
  const inputsElements = [
    {
      element: nomInput,
      pattern: patterns.nomPrenom,
      message: "Nom invalide: doit commencer par une lettre"
    },
    {
      element: prenomInput,
      pattern: patterns.nomPrenom,
      message: "Prénom invalide: doit commencer par une lettre"
    },
    {
      element: telephoneInput,
      pattern: patterns.telephone,
      message: "Téléphone invalide: uniquement des chiffres"
    },
    {
      element: emailInput,
      pattern: patterns.email,
      message: "Adresse email invalide"
    },
    {
      element: sujetInput,
      pattern: patterns.texte,
      message: "Caractères non autorisés: < > & * { } [ ]"
    },
    {
      element: messageInput,
      pattern: patterns.texte,
      message: "Caractères non autorisés: < > & * { } [ ]"
    }
  ];

  // Application des écouteurs d'événements pour tous les champs
  inputsElements.forEach((config) => {
    if (config.element) {
      config.element.addEventListener('input', () => {
        validerChamp(config.element, config.pattern, config.message);
      });
      
      // Réinitialisation du style lors du focus
      config.element.addEventListener('focus', function() {
        this.classList.remove('input-valid', 'input-invalid');
      });
    }
  });
  
  // Fonction pour valider un champ
  function validerChamp(input, pattern, messageErreur) {
    if (!input) return false;
    
    const valeur = input.value.trim();
    const erreurElement = input.nextElementSibling;
    
    if (!erreurElement) return false;
    
    // Validation principale
    const estValide = pattern.test(valeur);
    
    // Cas particulier pour le téléphone: vérification déjà intégrée dans la regex
    // qui impose entre 10 et 15 chiffres
    
    if (!estValide) {
      input.classList.remove('input-valid');
      input.classList.add('input-invalid');
      erreurElement.textContent = messageErreur;
      erreurElement.style.display = 'block';
    } else {
      input.classList.remove('input-invalid');
      input.classList.add('input-valid');
      erreurElement.style.display = 'none';
    }
    
    return estValide;
  }

  // Validation lors de la soumission du formulaire
  if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
      // Empêcher l'envoi du formulaire par défaut
      e.preventDefault();
      
      // Validation de tous les champs via inputsElements
      const validationResults = inputsElements.map(config => {
        return validerChamp(config.element, config.pattern, config.message);
      });
      
      // Vérifier si tous les champs sont valides
      const formulaireValide = validationResults.every(isValid => isValid);
      
      // Si tous les champs sont valides, on peut soumettre le formulaire
      if (formulaireValide) {
        console.log("Formulaire validé, prêt à être envoyé");
        // Ici vous pourriez ajouter un appel AJAX pour envoyer les données
        alert("Formulaire validé avec succès!");
        
        // Réinitialiser le formulaire après validation
        contactForm.reset();
        
        // Supprimer les classes de validation
        inputsElements.forEach(config => {
          if (config.element) {
            config.element.classList.remove('input-valid', 'input-invalid');
          }
        });
        
        // Décommenter pour envoyer le formulaire
        // this.submit();
      } else {
        // Faire défiler jusqu'au premier champ invalide
        const premierChampInvalide = contactForm.querySelector('.input-invalid');
        if (premierChampInvalide) {
          premierChampInvalide.focus();
        }
      }
    });
  }
});