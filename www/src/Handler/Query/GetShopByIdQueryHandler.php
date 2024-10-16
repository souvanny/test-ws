<?php

namespace App\Handler\Query;

use App\Core\QueryHandlerInterface;
use App\Database\Entity\Shop;
use App\Database\Repository\ShopRepository;


class GetShopByIdQueryHandler implements QueryHandlerInterface
{
    private ShopRepository $shopRepository;

    public function __construct(ShopRepository $shopRepository)
    {
        $this->shopRepository = $shopRepository;
    }

    public function __invoke(GetShopByIdQuery $query): Shop
    {
        return $this->shopRepository->find($query->id);
    }
}
