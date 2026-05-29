<?php

$mail_config = [
    'smtp_host' => getenv('SMTP_HOST') ?: 'smtp.gmail.com',
    'smtp_port' => getenv('SMTP_PORT') ?: 587,
    'smtp_secure' => getenv('SMTP_SECURE') ?: 'tls',
    'smtp_auth_enabled' => getenv('SMTP_AUTH_ENABLED') !== false ? filter_var(getenv('SMTP_AUTH_ENABLED'), FILTER_VALIDATE_BOOLEAN) : true,

    'from_email' => getenv('MAIL_FROM_ADDRESS') ?: 'no-reply@example.com',
    'from_name' => getenv('MAIL_FROM_NAME') ?: 'Secure Authentication System',
    'username' => getenv('SMTP_USERNAME') ?: '',
    'password' => getenv('SMTP_PASSWORD') ?: '',
    'debug' => getenv('MAIL_DEBUG') !== false ? filter_var(getenv('MAIL_DEBUG'), FILTER_VALIDATE_BOOLEAN) : false
];

return $mail_config;
?>
