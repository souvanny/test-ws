<?php

namespace App\Service;

use App\Database\Entity\Shop;
use App\DTO\ShopDTO;

class ShopService
{
    public function transformToDTO(Shop $shop): ShopDTO
    {
        return new ShopDTO(
            $shop->getId(),
            $shop->getName(),
            $shop->getCity()
        );
    }

    public function transformSearchToDTO(array $shops): array
    {
        $returnObject = [
            'count' => count($shops),
        ];
        $list = [];
        foreach ($shops as $shop) {
            $dto = new ShopDTO(
                $shop->getId(),
                $shop->getName(),
                $shop->getCity()
            );
            $list[] = $dto;
        }
        $returnObject['list'] = $list;

        return $returnObject;
    }


}
