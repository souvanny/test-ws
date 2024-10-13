<?php

namespace App\Handler\Query;

use App\Core\QueryHandlerInterface;
use App\Database\Entity\Shop;
use App\Database\Repository\ShopRepository;


class GetShopsByParamsQueryHandler implements QueryHandlerInterface
{
    private ShopRepository $shopRepository;

    public function __construct(ShopRepository $shopRepository)
    {
        $this->shopRepository = $shopRepository;
    }

    public function __invoke(GetShopsByParamsQuery $query): array
    {
        return $this->shopRepository->search($query->params);
    }
}
