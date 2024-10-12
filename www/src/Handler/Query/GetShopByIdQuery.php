<?php

namespace App\Handler\Query;

class GetShopByIdQuery
{
    public $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }
}
