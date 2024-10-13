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

//    echo "class: $class ===<br>";

    $prefix = 'App\\';
    $base_dir = __DIR__ . '/src/';
//    echo "base_dir: $base_dir ===<br>";

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        echo "préfixe manquant ===<br>";
        return;
    }

    $relative_class = substr($class, strlen($prefix));
//    echo "relative_class: $relative_class ===<br>";

    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
//    echo "file: $file ===<br>";

    if (file_exists($file)) {
//        echo "file exists : $file OK ===<br>";
        require $file;
    }

});


//$container = new ServiceContainer();
//
//$productController = $container->get(StoreController::class);
//
//$productController->list();


$container = new ServiceContainer();

//$container = new ServiceContainer();

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



echo "controller: $controller ===<br>";

// Décomposer les paramètres nommés (key-value pairs)
$params = [];
for ($i = 1; $i < count($urlSegments); $i += 2) {
    if (isset($urlSegments[$i + 1])) {
        $params[$urlSegments[$i]] = $urlSegments[$i + 1];
    }
}


echo "params : ".print_r($params, true)." <br>";


if (class_exists($controller)) {

    $controllerInstance = $container->get($controller);

    $controllerInstance($params);

} else {
    echo "Le contrôleur $controller n'existe pas.";
}


