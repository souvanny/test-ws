<?php

namespace App\Controller;

use App\Core\QueryBus;
use App\Handler\Query\GetShopByIdQuery;
use App\Handler\Query\GetShopsByParamsQuery;
use App\Response\JsonResponse;
use App\Service\ShopService;
use Exception;

class GetShopAction
{
    private ShopService $shopService;
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus, ShopService $shopService)
    {
        $this->shopService = $shopService;
        $this->queryBus = $queryBus;
    }

    /**
     * @throws Exception
     */
    public function __invoke($params): JsonResponse
    {
        if (1 === count($params) && isset($params['id'])) {
            $getShopByIdQuery = new GetShopByIdQuery($params['id']);
            $shop = $this->queryBus->handle($getShopByIdQuery);

            $shopDTO = $this->shopService->transformToDTO($shop);

            return new JsonResponse($shopDTO);
        } else {

            $getShopsByParamsQuery = new GetShopsByParamsQuery($params);
            $shops = $this->queryBus->handle($getShopsByParamsQuery);

            $searchShopsDTO = $this->shopService->transformSearchToDTO($shops);

            return new JsonResponse($searchShopsDTO);

        }

    }


}