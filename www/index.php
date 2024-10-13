<?php

use App\Controller\GetShopAction;
use App\Core\CommandBus;
use App\Core\CommandHandlerInterface;
use App\Core\HandlerLoader;
use App\Core\QueryBus;
use App\Core\QueryHandlerInterface;
use App\Service\ShopService;
use App\Core\ServiceContainer;

spl_autoload_register(function ($class) {

    $prefix = 'App\\';
    $base_dir = __DIR__ . '/src/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        echo "préfixe manquant ===<br>";
        return;
    }

    $relative_class = substr($class, strlen($prefix));

    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }

});


$container = new ServiceContainer();

// Récupérer l'URI
$request = $_SERVER['REQUEST_URI'];

// Retirer les paramètres de requête (ce qui vient après ?)
$request = strtok($request, '?');

// Supprimer le premier slash
$request = trim($request, '/');

// Découper l'URL en segments
$urlSegments = explode('/', $request);

// Décomposer l'URL en contrôleur et action
$controller = !empty($urlSegments[0]) ? ucfirst($urlSegments[0]) . 'Action' : 'HomeAction'; // Contrôleur par défaut

$method = $_SERVER['REQUEST_METHOD'];
$controller = ucfirst(strtolower($method)) . $controller;

$controller = "App\\Controller\\$controller";



//echo "controller: $controller $method ===<br>";

$params = [];

if ('GET' === $method || 'DELETE' === $method) {

    for ($i = 1; $i < count($urlSegments); $i += 2) {
        if (isset($urlSegments[$i + 1])) {
            $params[$urlSegments[$i]] = $urlSegments[$i + 1];
        }
    }

} else if ('POST' === $method) {

//    echo "Traitement POST =====<br> ";

    $rawData = file_get_contents("php://input");

    $params = json_decode($rawData, true);

}



//echo "params : ".print_r($params, true)." <br>";


if (class_exists($controller)) {

    $controllerInstance = $container->get($controller);

    $response = $controllerInstance($params);
    $response->send();

} else {
    echo "Le contrôleur $controller n'existe pas.";
}


