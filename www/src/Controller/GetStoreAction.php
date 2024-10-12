<?php
namespace App\Controller;
use App\Core\QueryBus;
use App\Handler\GetUserByIdQuery;
use App\Service\ProductService;

class GetStoreAction
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

        $getUserByIdQuery = new GetUserByIdQuery(1);
        $this->queryBus->handle($getUserByIdQuery);
    }


}