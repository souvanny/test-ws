<?php

namespace App\Handler\Query;

class SaveStoreCommand
{
    public $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }
}
