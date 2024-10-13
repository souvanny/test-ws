<?php

namespace App\Handler\Command;

use App\Core\CommandHandlerInterface;
use App\Database\Entity\Shop;
use App\Database\Repository\ShopRepository;
use App\Handler\Query\GetShopByIdQuery;

class DeleteShopCommandHandler implements CommandHandlerInterface
{
    private $shopRepository;

    public function __construct(ShopRepository $shopRepository)
    {
        $this->shopRepository = $shopRepository;
    }
    public function __invoke(DeleteShopCommand $command)
    {
        $shop = $this->shopRepository->find($command->id);
        if (null !== $shop) {
            $this->shopRepository->remove($shop);

        }

    }
}
