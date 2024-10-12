<?php

namespace App\Handler\Command;

use App\Core\CommandHandlerInterface;
use App\Database\Model\Shop;

class CreateShopCommandHandler implements CommandHandlerInterface
{
    public function __invoke($query)
    {
        // Logique pour récupérer un utilisateur par ID
        echo "Détails de l'utilisateur avec ID : " . $query->userId . "\n";

        $shop = new Shop();
        $shop->setName('kkkkkk');
        $shop->create();


    }
}
