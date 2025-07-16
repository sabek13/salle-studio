<?php
// Configuration email centralisée

return [
    // Paramètres SMTP Mailtrap
    'smtp_host' => 'sandbox.smtp.mailtrap.io',
    'smtp_port' => 587,
    'smtp_username' => '5b906a94d19eda',
    'smtp_password' => '98c2b7d9f70c42',
    'smtp_secure' => 'tls',

    // Paramètres par défaut
    'from_email' => 'contact@monsite.com',
    'from_name' => 'Mon Site Web',
    'admin_email' => 'admin@monsite.com',
    'admin_name' => 'Administrateur',

    // Options
    'charset' => 'UTF-8',
    'debug' => true, // Mettre false en production
];
