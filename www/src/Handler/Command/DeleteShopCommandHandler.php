<?php

namespace App\Handler\Command;

use App\Core\CommandHandlerInterface;
use App\Database\Entity\Shop;

class DeleteShopCommandHandler implements CommandHandlerInterface
{
    public function __invoke($command)
    {
        $shop = new Shop();
        $shop->find(4)->remove();
    }
}
