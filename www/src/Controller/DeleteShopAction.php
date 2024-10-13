<?php

namespace App\Controller;

use App\Core\CommandBus;
use App\Handler\Command\DeleteShopCommand;
use App\Response\JsonResponse;
use App\Response\Response;
use App\Service\ShopService;

class DeleteShopAction
{
    private $productService;
    private $commandBus;

    public function __construct(ShopService $productService, CommandBus $commandBus)
    {
        $this->productService = $productService;
        $this->commandBus = $commandBus;
    }

    public function __invoke($params): JsonResponse
    {
        $deleteShopCommand = new DeleteShopCommand($params['id']);
        $this->commandBus->handle($deleteShopCommand);

        return new JsonResponse(['result' => true]);
    }


}