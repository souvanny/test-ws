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



}