<?php
namespace App\Controllers;
use App\Services\ProductService;

class GetStoreAction
{
    private $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function __invoke($params)
    {
        echo "popi";
        print_r($params);
        $products = $this->productService->listAll();
        echo "Liste des produits : " . implode(', ', $products);
    }


}