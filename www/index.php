<?php
// Fonction d'autoloading des classes


spl_autoload_register(function ($class) {

    echo "class: $class ===<br>";

    // Ajouter un préfixe pour les classes si nécessaire (par exemple "App")
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/src/';
    echo "base_dir: $base_dir ===<br>";

    // Vérifier si la classe utilise le préfixe
    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        echo "préfixe manquant ===<br>";
        return;
    }

    // Obtenir le nom de classe relatif au préfixe
    $relative_class = substr($class, strlen($prefix));
    echo "relative_class: $relative_class ===<br>";

    // Remplacer les backslashes par des slashes et ajouter .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    echo "file: $file ===<br>";

    // Inclure le fichier si il existe
    if (file_exists($file)) {
        echo "file exists : $file OK ===<br>";
        require $file;
    }

});


//spl_autoload_register(function ($className) {
//    echo "className: $className ===<br>";
//    $file = __DIR__ . '/controllers/' . $className . '.php';
//    echo "file: $file ===<br>";
//    if (file_exists($file)) {
//        require $file;
//    } else {
//        echo "Le fichier pour la classe $className n'a pas été trouvé.";
//    }
//});


//spl_autoload_register(function ($className) {
//
//    echo "className: $className ===<br>";
//
//
//    // Convertir les namespaces en chemins de fichiers
//    $file = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
//
//    echo "file: $file ===<br>";
//
//    // Vérifier si le fichier existe
//    if (file_exists($file)) {
//        require $file;
//    } else {
//        echo "Le fichier pour la classe $className n'a pas été trouvé.";
//    }
//});

// Récupérer l'URI
$request = $_SERVER['REQUEST_URI'];

// Retirer les paramètres de requête (ce qui vient après ?)
$request = strtok($request, '?');

// Supprimer le premier slash
$request = trim($request, '/');

// Découper l'URL en segments
$urlSegments = explode('/', $request);

// Décomposer l'URL en contrôleur et action
$controller = !empty($urlSegments[0]) ? "App\\Controllers\\".ucfirst($urlSegments[0]) . 'Controller' : 'HomeController'; // Contrôleur par défaut

echo "controller: $controller ===<br>";

$action = !empty($urlSegments[1]) ? $urlSegments[1] : 'index';  // Action par défaut

// Décomposer les paramètres nommés (key-value pairs)
$params = [];
for ($i = 2; $i < count($urlSegments); $i += 2) {
    if (isset($urlSegments[$i + 1])) {
        $params[$urlSegments[$i]] = $urlSegments[$i + 1];
    }
}

// Instancier le contrôleur et appeler la méthode d'action
if (class_exists($controller)) {
    $controllerInstance = new $controller();
    if (method_exists($controllerInstance, $action)) {
        $controllerInstance->$action($params);  // Appeler la méthode avec les paramètres
    } else {
        echo "L'action $action n'existe pas dans le contrôleur $controller.";
    }
} else {
    echo "Le contrôleur $controller n'existe pas.";
}
?>
