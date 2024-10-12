<?php

namespace App\Handler;

class GetUserByIdQuery
{
    public $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }
}
