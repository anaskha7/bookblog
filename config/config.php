<?php

// Valor compartido para dar rol de admin en el registro
define('ADMIN_SECRET_CODE', getenv('ADMIN_SECRET_CODE') ?: 'LIBROS2026');


// Ruta base para enlaces
define('BASE_URL', getenv('BASE_URL') ?: 'http://localhost:8000/');

// Webhook de n8n para automatizaciones
define('N8N_WEBHOOK_URL', getenv('N8N_WEBHOOK_URL') ?: 'https://primary.n8n.cloud/webhook/test-path');
