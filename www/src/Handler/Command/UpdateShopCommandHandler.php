<?php

namespace App\Handler\Command;

use App\Core\CommandHandlerInterface;
use App\Database\Entity\Shop;
use App\Database\Repository\ShopRepository;

class UpdateShopCommandHandler implements CommandHandlerInterface
{
    private ShopRepository $shopRepository;

    public function __construct(ShopRepository $shopRepository)
    {
        $this->shopRepository = $shopRepository;
    }

    public function __invoke(UpdateShopCommand $command): Shop
    {
        $shop = $this->shopRepository->find($command->id);
        if (null !==$command->name) {
            $shop->setName($command->name);
        }
        if (null !== $command->city) {
            $shop->setCity($command->city);
        }
        return $this->shopRepository->update($shop);
    }
}
