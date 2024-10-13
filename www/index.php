<?php

use App\Core\ServiceContainer;
use App\Exception\DatabaseException;
use App\Response\JsonResponse;

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

$params = [];

if ('GET' === $method || 'DELETE' === $method) {

    for ($i = 1; $i < count($urlSegments); $i += 2) {
        if (isset($urlSegments[$i + 1])) {
            $params[$urlSegments[$i]] = $urlSegments[$i + 1];
        }
    }

} else if ('POST' === $method) {

    $rawData = file_get_contents("php://input");

    $params = json_decode($rawData, true);

}

if (class_exists($controller)) {

    $controllerInstance = $container->get($controller);

    try {
        $response = $controllerInstance($params);
        $response->send();
    } catch (DatabaseException $exception) {
        $response = new JsonResponse(['erreur' => true, 'message' => 'ERREUR DB : ' . $exception->getMessage()], 500);
        $response->send();
    } catch (\Throwable $exception) {
        $response = new JsonResponse(['erreur' => true, 'message' => $exception->getMessage()], 500);
        $response->send();
    }


} else {
    $response = new JsonResponse(['erreur' => true, 'message' => "Le controleur n'existe pas"], 404);
    $response->send();
}


