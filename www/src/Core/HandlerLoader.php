<?php

namespace App\Core;

use ReflectionClass;
use Relay\Exception;

class HandlerLoader
{
    public function loadHandlers($directory, $interface, $bus)
    {
        // Parcourir tous les fichiers PHP du répertoire donné
        foreach (glob($directory . '/*.php') as $file) {
            // Obtenir le nom de la classe à partir du fichier
            $className = $this->getClassNameFromFile($file, $interface);

            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                // Vérifier si la classe implémente l'interface du handler
                if ($reflection->implementsInterface($interface)) {
                    $handlerInstance = $this->get($className);
                    // Enregistrer automatiquement le handler dans le bus
                    $this->registerHandler($handlerInstance, $bus);
                }
            }
        }
    }

    public function get($className)
    {
        // Si le service est déjà instancié, le retourner
        if (isset($this->instances[$className])) {
            return $this->instances[$className];
        }

        // Utiliser la réflexion pour analyser le constructeur de la classe
        $reflectionClass = new ReflectionClass($className);
        $constructor = $reflectionClass->getConstructor();

        if (!$constructor) {
            // Pas de constructeur, instancier directement la classe
            $instance = new $className();
        } else {
            // Trouver les paramètres du constructeur
            $parameters = $constructor->getParameters();
            $dependencies = [];

            foreach ($parameters as $parameter) {
                // Résoudre chaque dépendance par type-hint
                $dependencyClass = $parameter->getType();

                if ($dependencyClass === null) {
                    throw new Exception("Impossible de résoudre la dépendance pour le paramètre \${$parameter->name} de la classe {$className}");
                }

                // Récupérer le nom de la classe à injecter
                $dependencyClassName = $dependencyClass->getName();

                // Récursivement récupérer l'instance de la dépendance
                $dependencies[] = $this->get($dependencyClassName);
            }

            // Instancier la classe avec ses dépendances
            $instance = $reflectionClass->newInstanceArgs($dependencies);
        }

        // Sauvegarder l'instance pour éviter de la recréer
        $this->instances[$className] = $instance;

        return $instance;
    }

    private function getClassNameFromFile($file, $interface)
    {
        // Extraire le nom de la classe à partir du chemin du fichier
        if (false !== strpos($interface, 'QueryHandlerInterface')) {
            $namespace = 'App\\Handler\\Query\\';
        } else {
            $namespace = 'App\\Handler\\Command\\';
        }
        $className = basename($file, '.php');
        return $namespace . str_replace('/', '\\', $className);
    }

    private function registerHandler($handler, $bus)
    {
        if ($handler instanceof CommandHandlerInterface) {
            $bus->registerHandler(get_class($handler), $handler);
        }

        if ($handler instanceof QueryHandlerInterface) {
            $bus->registerHandler(get_class($handler), $handler);
        }
    }
}
