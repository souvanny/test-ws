<?php

namespace App\Database;

class EntityRepository
{
    private string $entityClass;
    public function setEntityClass(string $entityClass): void
    {
        $this->entityClass = $entityClass;
    }
    public function getEntityClass(): string
    {
        return $this->entityClass;
    }
}