<?php
namespace App\Controller;
use App\Core\CommandBus;
use App\Handler\Command\CreateShopCommand;
use App\Service\ProductService;

class PostShopAction
{
    private $productService;
    private $commandBus;

    public function __construct(ProductService $productService, CommandBus $commandBus) {
        $this->productService = $productService;
        $this->commandBus = $commandBus;
    }

    public function __invoke($params)
    {
        $createShopCommand = new CreateShopCommand('toto');
        $this->commandBus->handle($createShopCommand);

    }


}