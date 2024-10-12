<?php
namespace App\Controller;
use App\Services\ProductService;

class PostStoreAction
{
    private $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function __invoke($params)
    {
        print_r($params);
        $products = $this->productService->listAll();
        echo "Liste des produits : " . implode(', ', $products);
    }


}