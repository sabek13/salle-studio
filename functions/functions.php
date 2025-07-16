<?php
function footer_link(string $page, string $label): string
{
    return '<li class="footer-link">
                <a class="" href="' . $page . '">' . $label . '</a>
            </li>';
}

?>

<?php
function dropdown_nav_item(string $label, array $activites_menus): string
{
    $html = '<li class="nav-item dropdown">
                <a class="nav-link nav-link-custom dropdown-toggle"
                   href="#"
                   role="button"
                   data-bs-toggle="dropdown">
                    ' . $label . '
                </a>
                <ul class="dropdown-menu">';

    foreach ($activites_menus as $activites_menu) :
        $html .= '<li>
                    <a class="dropdown-item"
                       href="' . $activites_menu['lien'] . '">' . $activites_menu['list'] . '
                    </a>
                  </li>';
    endforeach;


    $html .= '</ul></li>';
    return $html;
}

?>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Envoie un email via Mailtrap
 * 
 * @param array $data Données du formulaire
 * @return array Résultat de l'envoi
 */
function envoyerEmail($data)
{
    // Chargement de la configuration
    $config = require __DIR__ . '/../config/email.php';

    try {
        // Création de l'instance PHPMailer
        $mail = new PHPMailer(true);

        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host = $config['smtp_host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['smtp_username'];
        $mail->Password = $config['smtp_password'];
        $mail->SMTPSecure = $config['smtp_secure'];
        $mail->Port = $config['smtp_port'];
        $mail->CharSet = $config['charset'];

        // Debug (optionnel)
        if ($config['debug']) {
            $mail->SMTPDebug = 2; // 0 = off, 1 = client, 2 = client + server
        }

        // Expéditeur (email du formulaire)
        $mail->setFrom($config['from_email'], $config['from_name']);
        $mail->addReplyTo($data['email'], $data['nom']);

        // Destinataire (votre email)
        $mail->addAddress($config['admin_email'], $config['admin_name']);

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = 'Nouveau message de contact - ' . $data['nom'];

        // Corps de l'email en HTML
        $mail->Body = genererCorpsEmail($data);

        // Version texte (optionnel mais recommandé)
        $mail->AltBody = genererCorpsEmailTexte($data);

        // Envoi
        $mail->send();

        return [
            'success' => true,
            'message' => 'Email envoyé avec succès !'
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Erreur lors de l\'envoi : ' . $e->getMessage()
        ];
    }
}

/**
 * Génère le corps de l'email en HTML
 */
function genererCorpsEmail($data)
{
    $html = '


    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: #f4f4f4; padding: 20px; text-align: center; }
            .content { padding: 20px; }
            .info { background: #e9ecef; padding: 15px; margin: 10px 0; }
            .footer { text-align: center; font-size: 12px; color: #666; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Nouveau Message de Contact</h1>
            </div>
            
            <div class="content">
                <div class="info">
                    <strong>Nom :</strong> ' . htmlspecialchars($data['nom']) . '
                </div>
                
                <div class="info">
                    <strong>Email :</strong> ' . htmlspecialchars($data['email']) . '
                </div>
                
                <div class="info">
                    <strong>Date :</strong> ' . date('d/m/Y à H:i') . '
                </div>
                
                <div class="info">
                    <strong>Message :</strong><br>
                    ' . nl2br(htmlspecialchars($data['message'])) . '
                </div>
            </div>
            
            <div class="footer">
                <p>Email envoyé depuis votre site web</p>
            </div>
        </div>
    </body>
    </html>';

    return $html;
}

/**
 * Génère le corps de l'email en texte brut
 */
function genererCorpsEmailTexte($data)
{
    return "NOUVEAU MESSAGE DE CONTACT\n\n" .
        "Nom: " . $data['nom'] . "\n" .
        "Email: " . $data['email'] . "\n" .
        "Date: " . date('d/m/Y à H:i') . "\n\n" .
        "Message:\n" . $data['message'] . "\n\n" .
        "---\nEmail envoyé depuis votre site web";
}
