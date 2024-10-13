<?php

namespace App\Core;

use ReflectionClass;
use Relay\Exception;

class ServiceContainer
{
//    private $services = [];
    private $instances = [];

    // Enregistrer un service (lazy-loaded)
    public function register($name, callable $resolver)
    {
        $this->instances[$name] = $resolver;
    }

    public function set($name, $service)
    {
        $this->instances[$name] = $service;
    }

    // Récupérer un service
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


}
