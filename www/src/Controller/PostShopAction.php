<?php

namespace App\Controller;

use App\Core\CommandBus;
use App\Handler\Command\CreateShopCommand;
use App\Response\JsonResponse;
use App\Service\ShopService;

class PostShopAction
{
    private $commandBus;

    public function __construct(CommandBus $commandBus, ShopService $shopService)
    {
        $this->shopService = $shopService;
        $this->commandBus = $commandBus;
    }

    public function __invoke($params): JsonResponse
    {
        $createShopCommand = new CreateShopCommand($params['name']);
        $shop = $this->commandBus->handle($createShopCommand);

        $shopDTO = $this->shopService->transformToDTO($shop);

        return new JsonResponse($shopDTO);
    }


}