<?php

namespace App\Controller;

use App\Core\CommandBus;
use App\Handler\Command\CreateShopCommand;
use App\Response\JsonResponse;
use App\Service\ShopService;

/**
 * Controleur de création de shop
 */
class PostShopAction
{
    private CommandBus $commandBus;
    private ShopService $shopService;

    // constructeur avec services injectés
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
        // CreateShopCommand est une commande qui encapsule toutes les données nécessaires pour effectuer l'action
        $createShopCommand = new CreateShopCommand($params['name'], $params['city']);
        // commandBus centralise l'envoi et la gestion des commandes dans l'application.
        // Son rôle est de prendre une commande et de la faire traiter par le bon handler
        $shop = $this->commandBus->handle($createShopCommand);

        // shopService est appelé pour transformer l'entité en DTO
        $shopDTO = $this->shopService->transformToDTO($shop);

        // retourne une réponse de type JSON qui sera traité dans index.php
        return new JsonResponse($shopDTO);
    }


}