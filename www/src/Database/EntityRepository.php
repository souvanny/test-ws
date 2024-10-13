<?php

namespace App\Database;

use App\Exception\DatabaseException;
use PDO;

class EntityRepository
{
    protected string $entityClass;

    protected EntityManager $entityManager;

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

    /**
     * @throws DatabaseException
     */
    public function find($id)
    {
        $sql = "SELECT * FROM " . $this->entityManager->getEntityConfig()['entityTable'] . " WHERE id = ?";
        $params = [$id];
        $stmt = $this->entityManager->getDb()->query($sql, $params);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            throw new DatabaseException("Entite non trouvé", 404);
        }

        $entity = new $this->entityClass();

        $fields = $this->entityManager->getEntityConfig()['fields'];

        foreach ($fields as $field => $type) {
            $methodName = 'set' . ucfirst($field);
            $entity->$methodName($result[$this->camelToSnakeCase($field)]);
        }
        $entity->setId($result['id']);

        return $entity;
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

    /**
     * @throws DatabaseException
     */
    public function update($entity)
    {
        $idField = $this->entityManager->getEntityConfig()['idColumn'];
        $methodName = 'get' . ucfirst($idField);
        $id = $entity->$methodName();

        $fields = $this->entityManager->getEntityConfig()['fields'];

        $sqlFields = [];
        $params = [];

        foreach ($fields as $field => $type) {
            $sqlFields[] = $this->camelToSnakeCase($field) . "=?";
            $methodName = 'get' . ucfirst($field);
            $params[] = $entity->$methodName();
        }
        $params[] = $id;

        $sql = "UPDATE shops SET " . implode(', ', $sqlFields) . " WHERE $idField = ?";

        $this->entityManager->getDb()->query($sql, $params);

        return $this->find($id);
    }

    /**
     * @throws DatabaseException
     */
    public function remove($entity): void
    {
        $sql = "DELETE FROM shops WHERE id = ?";

        $idField = $this->entityManager->getEntityConfig()['idColumn'];
        $methodName = 'get' . ucfirst($idField);

        $id = $entity->$methodName();

        $params = [$id];
        $this->entityManager->getDb()->query($sql, $params);
    }

    protected function snakeToCamelCase($string)
    {
        $string = str_replace('_', ' ', strtolower($string));
        $string = ucwords($string);
        $string = str_replace(' ', '', $string);
        return lcfirst($string);
    }

    protected function camelToSnakeCase($string)
    {
        $string = preg_replace('/([a-z])([A-Z])/', '$1_$2', $string);
        return strtolower($string);
    }

}