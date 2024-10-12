<?php

namespace App\Handler\Query;

class GetUserByIdQuery
{
    public $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }
}
