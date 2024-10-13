<?php

namespace App\Handler\Query;

use App\Core\QueryHandlerInterface;
use App\Database\Entity\Shop;
use App\Database\Repository\CustomerRepository;
use App\Database\Repository\ShopRepository;


class GetShopByIdQueryHandler implements QueryHandlerInterface
{
    private $shopRepository;

    public function __construct(ShopRepository $shopRepository, CustomerRepository $customerRepository)
    {
        $this->shopRepository = $shopRepository;
    }

    public function __invoke($query): Shop
    {
        $shop = $this->shopRepository->find(5);

        return $shop;
    }
}
