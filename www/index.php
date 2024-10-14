<?php

use App\Core\ServiceContainer;
use App\Exception\DatabaseException;
use App\Response\JsonResponse;

// Autoload des fichiers nécessaires, notamment des classes
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
// le nom nom du controller est déduit du verbe et du premier paramètre de l'url

$controller = "App\\Controller\\$controller";

$params = [];


if ('GET' === $method || 'DELETE' === $method) {
    // pour les verbes GET et DELETE on utilisera les paramètres passés dans le chemin de l'url
    for ($i = 1; $i < count($urlSegments); $i += 2) {
        if (isset($urlSegments[$i + 1])) {
            $params[$urlSegments[$i]] = $urlSegments[$i + 1];
        }
    }
} else if ('POST' === $method || 'PATCH' === $method) {
    // pour POST et PATCH on récupère le payload JSON dans le body de la requête
    $rawData = file_get_contents("php://input");
    $params = json_decode($rawData, true);
}

if (class_exists($controller)) {
    // On appelle le services container pour récupérer l'intance d'une classe
    // Ici il s'agit d'un controlleur
    // Les services déclarés dans les constructeurs des controleurs seront injectés
    $controllerInstance = $container->get($controller);

    try {
        // $params est à chaque fois passé
        // il est équivalent à l'object Request de symfony
        $response = $controllerInstance($params);
        $response->send();
    } catch (DatabaseException $exception) {
        // c'est exceptions concernen la bdd
        $code = $exception->getCode() !== 0 ? $exception->getCode() : 500;
        $response = new JsonResponse(['erreur' => true, 'message' => 'ERREUR DB : ' . $exception->getMessage()], $code);
        $response->send();
    } catch (\Throwable $exception) {
        // exception générale
        $response = new JsonResponse(['erreur' => true, 'message' => $exception->getMessage()], 500);
        $response->send();
    }

} else {
    $response = new JsonResponse(['erreur' => true, 'message' => "Le controleur n'existe pas"], 404);
    $response->send();
}


