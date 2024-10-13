<?php

namespace App\Database;

use App\Database\Entity\Shop;
use PDO;

class EntityRepository
{
    private string $entityClass;

    private $entityManager;

    public function __construct(ManagerRegistry $managerRegistry, string $entityClass)
    {
        echo "EntityRepository CONSTRUCT <br>";
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

        foreach($fields as $field => $type) {
            $methodName = 'set' . ucfirst($field);
            $entity->$methodName($result[$this->camelToSnakeCase($field)]);
        }

        return new Shop($result['id'], $result['name']);
    }

    public function create(): void
    {
        $sql = "INSERT INTO shops (name, is_deleted) VALUES (?, ?)";
        $params = [$this->name, $this->isDeleted ? 1 : 0];
        $this->entityManager->getDb()->query($sql, $params);
    }

    public function remove(): void
    {
        $sql = "DELETE FROM shops WHERE id=?";
        $params = [$this->id];
        $this->entityManager->getDb()->query($sql, $params);
    }

    private function snakeToCamelCase($string) {
        $string = str_replace('_', ' ', strtolower($string));
        $string = ucwords($string);
        $string = str_replace(' ', '', $string);
        $string = lcfirst($string);
        return $string;
    }

    private function camelToSnakeCase($string) {
        $string = preg_replace('/[A-Z]/', '_$0', $string);
        $string = strtolower($string);
        if ($string[0] === '_') {
            $string = substr($string, 1);
        }
        return $string;
    }

}