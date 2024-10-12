<?php
namespace App\Controller;
use App\Core\CommandBus;
use App\Core\QueryBus;
use App\Handler\Query\GetShopByIdQuery;
use App\Service\ProductService;

class GetShopAction
{
    private $productService;
    private $queryBus;

    public function __construct(QueryBus $queryBus, ProductService $productService) {
        $this->productService = $productService;
        $this->queryBus = $queryBus;
    }

    public function __invoke($params)
    {
        echo "<hr>";
        print_r($params);
        $products = $this->productService->listAll();
        echo "Liste des produits : " . implode(', ', $products) . "<br>";
        echo "<hr>";

        $getShopByIdQuery = new GetShopByIdQuery(1);
        $this->queryBus->handle($getShopByIdQuery);
    }


}