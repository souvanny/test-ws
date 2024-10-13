<?php

namespace App\Database\Repository;

use App\Database\Entity\Shop;
use App\Database\EntityRepository;
use App\Database\ManagerRegistry;
use App\Exception\DatabaseException;
use PDO;

class ShopRepository extends EntityRepository
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Shop::class);
    }

    public function search(array $searchParams): array
    {
        $filters = [];
        $params = [];

        foreach($searchParams as $field => $value) {
            $filters[] = $field . ' LIKE ?';
            $params[] = "%$value%";
        }

        $sql = "SELECT * FROM " . $this->entityManager->getEntityConfig()['entityTable'] . " WHERE " . implode(" AND ", $filters);

        $stmt = $this->entityManager->getDb()->query($sql, $params);

        $resultList = [];
        while ($row = $stmt->fetch()) {
            $entity = new $this->entityClass();

            $fields = $this->entityManager->getEntityConfig()['fields'];

            foreach ($fields as $field => $type) {
                $methodName = 'set' . ucfirst($field);
                $entity->$methodName($row[$this->camelToSnakeCase($field)]);
            }
            $entity->setId($row['id']);
            $resultList[] = $entity;
        }

        return $resultList;
    }

}
