<?php

namespace App\Database\Repository;

use App\Database\Database;
use App\Database\Entity\Customer;
use App\Database\Entity\Shop;
use App\Database\EntityRepository;
use App\Database\ManagerRegistry;

class CustomerRepository extends EntityRepository
{

    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Customer::class);
        echo "CustomerRepository CONSTRUCT <br>";
    }



}