<?php

namespace App\Handler\Command;

use App\Core\CommandHandlerInterface;
use App\Database\Entity\Shop;
use App\Database\Repository\ShopRepository;

class CreateShopCommandHandler implements CommandHandlerInterface
{
    private $shopRepository;

    public function __construct(ShopRepository $shopRepository)
    {
        $this->shopRepository = $shopRepository;
    }

    public function __invoke(CreateShopCommand $command): Shop
    {
        $shop = new Shop();
        $shop->setName($command->name);

        return $this->shopRepository->add($shop);
    }
}
