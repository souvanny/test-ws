<?php

namespace App\Handler\Command;

use App\Core\CommandHandlerInterface;
use App\Database\Model\Shop;

class CreateShopCommandHandler implements CommandHandlerInterface
{
    public function __invoke($command): void
    {
        $shop = new Shop();
        $shop->setName('kkkkkk');
        $shop->create();
    }
}
