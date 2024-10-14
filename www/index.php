<?php

use App\Core\ServiceContainer;
use App\Exception\DatabaseException;
use App\Response\JsonResponse;

require_once("autoloader.php");


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
} else if ('POST' === $method || 'PATCH' === $method) {
    $rawData = file_get_contents("php://input");
    $params = json_decode($rawData, true);
}

if (class_exists($controller)) {
    $controllerInstance = $container->get($controller);

    try {
        $response = $controllerInstance($params);
        $response->send();
    } catch (DatabaseException $exception) {
        $code = $exception->getCode() !== 0 ? $exception->getCode() : 500;
        $response = new JsonResponse(['erreur' => true, 'message' => 'ERREUR DB : ' . $exception->getMessage()], $code);
        $response->send();
    } catch (\Throwable $exception) {
        $response = new JsonResponse(['erreur' => true, 'message' => $exception->getMessage()], 500);
        $response->send();
    }

} else {
    $response = new JsonResponse(['erreur' => true, 'message' => "Le controleur n'existe pas"], 404);
    $response->send();
}


