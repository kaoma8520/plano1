<?php
// Configurações gerais do sistema

// Definindo o fuso horário
date_default_timezone_set('America/Sao_Paulo');

// URL base do sistema
define('BASE_URL', 'http://localhost/motoboy-system/');

// Chave secreta para autenticação
define('SECRET_KEY', 'sua_chave_secreta_aqui');

// Configurações de envio de mensagens via WhatsApp
define('WHATSAPP_API_URL', 'https://api.whatsapp.com/send');
define('WHATSAPP_API_TOKEN', 'seu_token_aqui');

// Configurações da API do Mercado Pago
define('MERCADO_PAGO_CLIENT_ID', 'seu_client_id_aqui');
define('MERCADO_PAGO_CLIENT_SECRET', 'seu_client_secret_aqui');

// Configurações de e-mail (opcional)
define('EMAIL_HOST', 'smtp.seu_email.com');
define('EMAIL_USERNAME', 'seu_email@dominio.com');
define('EMAIL_PASSWORD', 'sua_senha_aqui');
define('EMAIL_PORT', 587);

// Configurações de segurança
define('PASSWORD_HASH_ALGO', PASSWORD_BCRYPT);
define('PASSWORD_HASH_COST', 12);
?>