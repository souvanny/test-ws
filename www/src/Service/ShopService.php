<?php
namespace App\Service;
use App\Database\Entity\Shop;
use App\DTO\ShopDTO;

class ShopService {
    public function transformToDTO(Shop $shop): ShopDTO {
        return new ShopDTO(
            $shop->getId(),
            $shop->getName()
        );
    }
}
