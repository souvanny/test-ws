<?php
namespace App\Controller;
use App\Core\CommandBus;
use App\Handler\Command\CreateShopCommand;
use App\Service\ShopService;

class PostShopAction
{
    private $commandBus;

    public function __construct(CommandBus $commandBus) {
        $this->commandBus = $commandBus;
    }

    public function __invoke($params)
    {

        $createShopCommand = new CreateShopCommand($params['name']);
        $this->commandBus->handle($createShopCommand);

    }


}