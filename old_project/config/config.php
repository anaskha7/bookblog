<?php

// contraseña admin
define('ADMIN_SECRET_CODE', getenv('ADMIN_SECRET_CODE') ?: 'LIBROS2026');


// base
define('BASE_URL', getenv('BASE_URL') ?: 'http://localhost:8000/');

// Webhook de n8n 
define('N8N_WEBHOOK_URL', getenv('N8N_WEBHOOK_URL') ?: 'https://primary.n8n.cloud/webhook/test-path');
