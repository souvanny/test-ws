<?php

namespace App\Database;

use App\Database\Entity\Shop;
use PDO;

class EntityRepository
{
    private string $entityClass;

    private EntityManager $entityManager;

    public function __construct(ManagerRegistry $managerRegistry, string $entityClass)
    {
        $this->entityClass = $entityClass;
        $this->entityManager = $managerRegistry->getManagerForClass($entityClass);
    }

    public function getTableName(): string
    {
        return 'no table name';
    }


    public function setEntityClass(string $entityClass): void
    {
        $this->entityClass = $entityClass;
    }

    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    public function find($id): ?Shop
    {
        $db = new Database('lamp-mariadb106', 'wshop', 'password', 'wshop');
        $sql = "SELECT * FROM " . $this->entityManager->getEntityConfig()['entityTable'] . " WHERE id = ?";
        $params = [$id];
        $stmt = $db->query($sql, $params);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }

        $entity = new $this->entityClass();

        $fields = $this->entityManager->getEntityConfig()['fields'];

        foreach ($fields as $field => $type) {
            $methodName = 'set' . ucfirst($field);
            $entity->$methodName($result[$this->camelToSnakeCase($field)]);
        }

        return new Shop($result['id'], $result['name']);
    }

    public function add($entity)
    {
        $fields = $this->entityManager->getEntityConfig()['fields'];

        $sqlFields = [];
        $sqlValues = [];
        $params = [];

        foreach ($fields as $field => $type) {
            $sqlFields[] = $this->camelToSnakeCase($field);
            $sqlValues[] = '?';
            $methodName = 'get' . ucfirst($field);
            $params[] = $entity->$methodName();
        }

        $sql = "INSERT INTO shops (" . implode(', ', $sqlFields) . ") VALUES (" . implode(', ', $sqlValues) . ")";

        $this->entityManager->getDb()->query($sql, $params);

        $lastId = $this->entityManager->getDb()->lastInsertId();

        $entity->setId($lastId);

        return $entity;
    }

    public function remove($entity): void
    {
        $sql = "DELETE FROM shops WHERE id = ?";

        $idField = $this->entityManager->getEntityConfig()['idColumn'];
        $methodName = 'get' . ucfirst($idField);

        $id = $entity->$methodName();

        $params = [$id];
        $this->entityManager->getDb()->query($sql, $params);
    }

    private function snakeToCamelCase($string)
    {
        $string = str_replace('_', ' ', strtolower($string));
        $string = ucwords($string);
        $string = str_replace(' ', '', $string);
        $string = lcfirst($string);
        return $string;
    }

    private function camelToSnakeCase($string)
    {
        $string = preg_replace('/([a-z])([A-Z])/', '$1_$2', $string);
        return strtolower($string);
    }

}