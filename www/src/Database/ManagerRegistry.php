<?php

namespace App\Database;

class ManagerRegistry
{

    private $managers = [];
    public function getManagerForClass(string $entityClass): EntityManager
    {
        if (isset($this->managers[$entityClass])) {
            return $this->managers[$entityClass];
        }
        $instance = new EntityManager($entityClass);
        $this->managers[$entityClass] = $instance;
        return $instance;
    }
}