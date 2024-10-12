<?php

namespace App\Handler\Query;

use App\Core\QueryHandlerInterface;
use App\Database\Model\Shop;

class GetShopByIdQueryHandler implements QueryHandlerInterface
{
    public function __invoke($query)
    {
        // Logique pour récupérer un utilisateur par ID
        echo "Détails de l'utilisateur avec ID : " . $query->userId . "<br>\n";
        $shop = new Shop();

        print_r($shop->find(1));

    }
}
