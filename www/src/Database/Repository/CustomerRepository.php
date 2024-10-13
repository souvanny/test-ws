<?php

namespace App\Database\Repository;

use App\Database\Entity\Customer;
use App\Database\EntityRepository;
use App\Database\ManagerRegistry;

class CustomerRepository extends EntityRepository
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Customer::class);
    }

}