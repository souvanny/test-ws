<?php

namespace App\Database\Repository;

use App\Database\Database;
use App\Database\Entity\Shop;
use App\Database\EntityRepository;

class ShopRepository extends EntityRepository
{

    public function __construct()
    {
        $this->setEntityClass(Shop::class);
    }

    public function find($id): ?Shop {
        $db = new Database('lamp-mariadb106', 'wshop', 'password', 'wshop');
        $sql = "SELECT * FROM ? WHERE id = ?";
        $params = [$this->getClassName(), $id];
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


}