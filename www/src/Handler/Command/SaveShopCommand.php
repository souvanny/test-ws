<?php

namespace App\Handler\Query;

class SaveShopCommand
{
    public $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }
}
