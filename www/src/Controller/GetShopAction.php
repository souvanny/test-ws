<?php

namespace App\Controller;

use App\Core\QueryBus;
use App\Handler\Query\GetShopByIdQuery;
use App\Service\ShopService;

class GetShopAction
{
    private $shopService;
    private $queryBus;

    public function __construct(QueryBus $queryBus, ShopService $shopService)
    {
        $this->shopService = $shopService;
        $this->queryBus = $queryBus;
    }

    public function __invoke($params)
    {
        $getShopByIdQuery = new GetShopByIdQuery($params['id']);
        $shop = $this->queryBus->handle($getShopByIdQuery);

        $shopDTO = $this->shopService->transformToDTO($shop);

        print_r($shopDTO);
    }


}