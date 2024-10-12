<?php

namespace app\src\core;
class ServiceContainer
{
    private $services = [];
    private $instances = [];

    // Enregistrer un service (lazy-loaded)
    public function register($name, callable $resolver)
    {
        $this->services[$name] = $resolver;
    }

    // Récupérer un service
    public function get($name)
    {
        // Si le service a déjà été instancié, le retourner
        if (isset($this->instances[$name])) {
            return $this->instances[$name];
        }

        // Vérifier que le service est enregistré
        if (!isset($this->services[$name])) {
            throw new Exception("Le service $name n'est pas enregistré dans le container.");
        }

        // Résoudre le service et le stocker pour les prochains appels
        $this->instances[$name] = $this->services[$name]($this);

        return $this->instances[$name];
    }
}
