<?php
namespace App\Controller;
use App\Core\CommandBus;
use App\Handler\Command\DeleteShopCommand;
use App\Service\ShopService;

class DeleteShopAction
{
    private $productService;
    private $commandBus;

    public function __construct(ShopService $productService, CommandBus $commandBus) {
        $this->productService = $productService;
        $this->commandBus = $commandBus;
    }

    public function __invoke($params)
    {
        print_r($params);
        $products = $this->productService->listAll();
        echo "Liste des produits : " . implode(', ', $products);

        $deleteShopCommand = new DeleteShopCommand(2);
        $this->commandBus->handle($deleteShopCommand);



    }


}