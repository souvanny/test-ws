<?php

namespace App\Handler\Query;

use App\Core\QueryHandlerInterface;
use App\Database\Entity\Shop;


class GetShopByIdQueryHandler implements QueryHandlerInterface
{
//    private $shopRepository;
//
//    public function __construct(ShopRepository $shopRepository)
//    {
//        $this->shopRepository = $shopRepository;
//    }

    public function __invoke($query)
    {
        // Logique pour récupérer un utilisateur par ID
        echo "Détails de l'utilisateur avec ID : " . $query->userId . "<br>\n";
        $shop = new Shop();

        print_r($shop->find(1));

//        $shop = $this->shopRepository->find($query->userId);
//
//        print_r($shop);

    }
}
