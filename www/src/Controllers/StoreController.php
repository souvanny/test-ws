<?php
namespace App\Controllers;
use App\Services\ProductService;

class StoreController
{
    private $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function list()
    {
        echo "popi";
        $products = $this->productService->listAll();
        echo "Liste des produits : " . implode(', ', $products);
    }


}