<?php
session_start();

require __DIR__ . '/../config/config.php';
require __DIR__ . '/../config/Database.php';

spl_autoload_register(function ($class) {
    $paths = ['controllers', 'models'];
    foreach ($paths as $path) {
        $file = __DIR__ . "/../{$path}/{$class}.php";
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});

$database = new Database();
$db = $database->getConnection();

$controllerParam = $_GET['controller'] ?? 'post';
$action = $_GET['action'] ?? 'index';
$controllerName = ucfirst(strtolower($controllerParam)) . 'Controller';

if (!class_exists($controllerName)) {
    http_response_code(404);
    echo 'Controlador no encontrado';
    exit;
}

$controller = new $controllerName($db);

if (!method_exists($controller, $action)) {
    http_response_code(404);
    echo 'Acción no encontrada';
    exit;
}

$controller->$action();
