<?php

// Valor compartido para dar rol de admin en el registro
define('ADMIN_SECRET_CODE', getenv('ADMIN_SECRET_CODE') ?: 'LIBROS2026');

// Webhook n8n
define('N8N_WEBHOOK_URL', getenv('N8N_WEBHOOK_URL') ?: 'http://n8n:5678/webhook/book-events');
define('N8N_WEBHOOK_TOKEN', getenv('N8N_WEBHOOK_TOKEN') ?: 'secreto');

// Ruta base para enlaces
define('BASE_URL', getenv('BASE_URL') ?: '/');
