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

  // Regex optimisées selon vos spécifications
  const patterns = {
    // Nom/Prénom: commence par une lettre (maj ou min, avec ou sans accent)
    // Puis autorise lettres, accents, espaces, tirets, apostrophes
    nomPrenom: /^[A-Za-zÀ-ÖØ-öø-ÿ][A-Za-zÀ-ÖØ-öø-ÿ\s\-']{0,29}$/,
    
    // Téléphone: uniquement des chiffres de 0 à 9
    telephone: /^[0-9]+$/,
    
    // Email: lettres, chiffres, accents, uniquement @ comme caractère spécial
    email: /^[A-Za-zÀ-ÖØ-öø-ÿ0-9._%+-]+@[A-Za-zÀ-ÖØ-öø-ÿ0-9.-]+\.[A-Za-z]{2,}$/,
    
    // Sujet et message: tout sauf balises et caractères spéciaux interdits
    texte: /^[^<>&*{}\[\]]+$/
  };

  // Fonction pour créer les conteneurs de messages d'erreur
  function createErrorContainers() {
    const inputs = [nomInput, prenomInput, telephoneInput, emailInput, sujetInput, messageInput];
    
    inputs.forEach(input => {
      if (!input) return; // Ignorer les champs non trouvés
      
      // Créer le conteneur d'erreur s'il n'existe pas déjà
      let errorContainer = input.nextElementSibling;
      if (!errorContainer || !errorContainer.classList.contains('error-message')) {
        errorContainer = document.createElement('div');
        errorContainer.className = 'error-message';
        errorContainer.style.color = '#dc3545';
        errorContainer.style.fontSize = '0.875rem';
        errorContainer.style.marginTop = '0.25rem';
        errorContainer.style.display = 'none';
        
        // Insérer après l'input
        if (input.parentNode) {
          input.parentNode.insertBefore(errorContainer, input.nextSibling);
        }
      }
    });
  }

  // Créer les conteneurs d'erreurs
  createErrorContainers();

  // Fonction pour valider un champ
  function validerChamp(input, pattern, messageErreur) {
    if (!input) return false;
    
    const valeur = input.value.trim();
    const erreurElement = input.nextElementSibling;
    
    // Cas particulier pour le téléphone: vérifier la longueur
    if (input === telephoneInput && pattern.test(valeur)) {
      if (valeur.length < 10 || valeur.length > 15) {
        input.style.borderLeft = '3px solid #dc3545';
        if (erreurElement) {
          erreurElement.textContent = "Le numéro doit contenir entre 10 et 15 chiffres";
          erreurElement.style.display = 'block';
        }
        return false;
      }
    }
    
    // Validation principale
    const estValide = pattern.test(valeur);
    
    if (!estValide) {
      input.style.borderLeft = '3px solid #dc3545';
      if (erreurElement) {
        erreurElement.textContent = messageErreur;
        erreurElement.style.display = 'block';
      }
    } else {
      input.style.borderLeft = '3px solid #28a745';
      if (erreurElement) {
        erreurElement.style.display = 'none';
      }
    }
    
    return estValide;
  }

  // Validation en temps réel
  if (nomInput) {
    nomInput.addEventListener('input', () => {
      validerChamp(nomInput, patterns.nomPrenom, "Nom invalide: doit commencer par une lettre");
    });
  }
  
  if (prenomInput) {
    prenomInput.addEventListener('input', () => {
      validerChamp(prenomInput, patterns.nomPrenom, "Prénom invalide: doit commencer par une lettre");
    });
  }
  
  if (telephoneInput) {
    telephoneInput.addEventListener('input', () => {
      validerChamp(telephoneInput, patterns.telephone, "Téléphone invalide: uniquement des chiffres");
    });
  }
  
  if (emailInput) {
    emailInput.addEventListener('input', () => {
      validerChamp(emailInput, patterns.email, "Adresse email invalide");
    });
  }
  
  if (sujetInput) {
    sujetInput.addEventListener('input', () => {
      validerChamp(sujetInput, patterns.texte, "Caractères non autorisés: < > & * { } [ ]");
    });
  }
  
  if (messageInput) {
    messageInput.addEventListener('input', () => {
      validerChamp(messageInput, patterns.texte, "Caractères non autorisés: < > & * { } [ ]");
    });
  }

  // Réinitialisation du style lors du focus
  const allInputs = [nomInput, prenomInput, telephoneInput, emailInput, sujetInput, messageInput];
  allInputs.forEach(input => {
    if (!input) return;
    
    input.addEventListener('focus', function() {
      this.style.borderLeft = '';
    });
  });

  // Validation lors de la soumission du formulaire
  if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
      // Empêcher l'envoi du formulaire par défaut
      e.preventDefault();
      
      // Validation de tous les champs
      const nomValide = validerChamp(nomInput, patterns.nomPrenom, "Nom invalide: doit commencer par une lettre");
      const prenomValide = validerChamp(prenomInput, patterns.nomPrenom, "Prénom invalide: doit commencer par une lettre");
      const telephoneValide = validerChamp(telephoneInput, patterns.telephone, "Téléphone invalide: uniquement des chiffres");
      const emailValide = validerChamp(emailInput, patterns.email, "Adresse email invalide");
      const sujetValide = validerChamp(sujetInput, patterns.texte, "Caractères non autorisés: < > & * { } [ ]");
      const messageValide = validerChamp(messageInput, patterns.texte, "Caractères non autorisés: < > & * { } [ ]");
      
      // Si tous les champs sont valides, on peut soumettre le formulaire
      if (nomValide && prenomValide && telephoneValide && emailValide && sujetValide && messageValide) {
        console.log("Formulaire validé, prêt à être envoyé");
        // Ici vous pourriez ajouter un appel AJAX pour envoyer les données
        alert("Formulaire validé avec succès!");
        
        // Décommenter pour envoyer le formulaire
        // this.submit();
      } else {
        // Faire défiler jusqu'au premier champ invalide
        const premierChampInvalide = contactForm.querySelector('input[style*="border-left: 3px solid rgb(220, 53, 69)"], textarea[style*="border-left: 3px solid rgb(220, 53, 69)"]');
        if (premierChampInvalide) {
          premierChampInvalide.focus();
        }
      }
    });
  }
});