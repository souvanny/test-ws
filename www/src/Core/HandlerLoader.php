<?php

namespace App\Core;

use ReflectionClass;

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
                    $handlerInstance = $reflection->newInstance();
                    // Enregistrer automatiquement le handler dans le bus
                    $this->registerHandler($handlerInstance, $bus);
                }
            }
        }
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
