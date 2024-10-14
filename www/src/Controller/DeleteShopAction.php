<?php

namespace App\Controller;

use App\Core\CommandBus;
use App\Handler\Command\DeleteShopCommand;
use App\Response\JsonResponse;

/**
 * Controleur de suppression de shop
 * Une explication générique est dans PostShopAction (commande, bus, dto))
 */
class DeleteShopAction
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @throws \Exception
     */
    public function __invoke($params): JsonResponse
    {
        $deleteShopCommand = new DeleteShopCommand($params['id']);
        $this->commandBus->handle($deleteShopCommand);

        return new JsonResponse(['result' => true]);
    }

}
