<?php

namespace App\Database\Repository;

use App\Database\Entity\Shop;
use App\Database\EntityRepository;
use App\Database\ManagerRegistry;

class ShopRepository extends EntityRepository
{

    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Shop::class);
    }



}