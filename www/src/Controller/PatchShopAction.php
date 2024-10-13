<?php

namespace App\Controller;

use App\Core\CommandBus;
use App\Handler\Command\UpdateShopCommand;
use App\Response\JsonResponse;
use App\Service\ShopService;

class PatchShopAction
{
    private CommandBus $commandBus;
    private ShopService $shopService;

    public function __construct(CommandBus $commandBus, ShopService $shopService)
    {
        $this->shopService = $shopService;
        $this->commandBus = $commandBus;
    }

    /**
     * @throws \Exception
     */
    public function __invoke($params): JsonResponse
    {
        $updateShopCommand = new UpdateShopCommand(intval($params['id']), $params['name'], $params['city']);
        $shop = $this->commandBus->handle($updateShopCommand);

        $shopDTO = $this->shopService->transformToDTO($shop);

        return new JsonResponse($shopDTO);
    }


}