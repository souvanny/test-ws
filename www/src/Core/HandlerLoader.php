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
            $className = $this->getClassNameFromFile($file);

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

    private function getClassNameFromFile($file)
    {
        // Extraire le nom de la classe à partir du chemin du fichier
        $namespace = 'App\\Handler\\';
        $className = basename($file, '.php');
        return $namespace . str_replace('/', '\\', $className);
    }

    private function registerHandler($handler, $bus)
    {
        // Enregistrer les handlers dans le bus approprié
        if ($handler instanceof \App\Core\CommandHandlerInterface) {
            $bus->registerHandler(get_class($handler), $handler);
        }

        if ($handler instanceof \App\Core\QueryHandlerInterface) {
            $bus->registerHandler(get_class($handler), $handler);
        }
    }
}
