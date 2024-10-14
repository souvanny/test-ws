<?php

namespace App\Database;

/**
 * à l'instar de Doctrine, c'est ici qu'on manage les entités
 * Un entity manager par repository
 */
class EntityManager
{
    private Database $db;
    private string $entityClass;
    private array $entityConfig = [];
    public function __construct(string $entityClass)
    {
        $this->entityClass = $entityClass;
        $this->loadConfig();
        $this->connectDb();
    }

    public function getDb(): Database
    {
        return $this->db;
    }

    public function getEntityConfig(): array
    {
        return $this->entityConfig;
    }

    private function loadConfig()
    {
        $parts = explode("\\", $this->entityClass);
        $lastPart = end($parts);

        $xml = simplexml_load_file(__DIR__ . '/Orm/'.$lastPart.'.xml') or die("Erreur : Impossible de charger le fichier XML.");

        $entity = $xml->entity;
        $entityName = (string) $entity['name'];
        $entityTable = (string) $entity['table'];

        $this->entityConfig['entityName'] = $entityName;
        $this->entityConfig['entityTable'] = $entityTable;

        $id = $entity->id;
        $idColumn = (string) $id['column'];
        $this->entityConfig['idColumn'] = $idColumn;

        $this->entityConfig['fields'] = [];

        foreach ($entity->field as $field) {
            $fieldName = (string) $field['name'];
            $fieldType = (string) $field['type'];
            $this->entityConfig['fields'][$fieldName] = $fieldType;
        }

    }

    private function connectDb()
    {
        $this->db = new Database('lamp-mariadb106', 'wshop', 'password', 'wshop');

    }


}