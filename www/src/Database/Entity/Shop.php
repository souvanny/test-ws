<?php

namespace App\Database\Entity;

use App\Database\Database;
use PDO;

class Shop
{
    private ?int $id;
    private ?string $name;

    private ?bool $isDeleted;

    public function __construct(int $id = null, string $name = null, bool $isDeleted = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->isDeleted = $isDeleted;
    }


    public function find($id): ?Shop {
        $db = new Database('lamp-mariadb106', 'wshop', 'password', 'wshop');
        $sql = "SELECT * FROM shops WHERE id = ?";
        $params = [$id];
        $stmt = $db->query($sql, $params);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }
        return new Shop($result['id'], $result['name']);
    }

    public function create(): void {
        $db = new Database('lamp-mariadb106', 'wshop', 'password', 'wshop');
        $sql = "INSERT INTO shops (name, is_deleted) VALUES (?, ?)";
        $params = [$this->name, $this->isDeleted ? 1 : 0];
        $db->query($sql, $params);
    }

    public function remove(): void {
        $db = new Database('lamp-mariadb106', 'wshop', 'password', 'wshop');
        $sql = "DELETE FROM shops WHERE id=?";
        $params = [$this->id];
        $db->query($sql, $params);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(?bool $isDeleted): void
    {
        $this->isDeleted = $isDeleted;
    }

}