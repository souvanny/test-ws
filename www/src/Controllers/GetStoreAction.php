<?php
namespace App\Controllers;
use App\Core\QueryBus;
use App\Services\ProductService;

class GetStoreAction
{
    private $productService;
    private $queryBus;

    public function __construct(ProductService $productService, QueryBus $queryBus) {
        $this->productService = $productService;
        $this->queryBus = $queryBus;
    }

    public function __invoke($params)
    {
        echo "popi";
        print_r($params);
        $products = $this->productService->listAll();
        echo "Liste des produits : " . implode(', ', $products);
    }


}