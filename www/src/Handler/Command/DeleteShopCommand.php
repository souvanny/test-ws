<?php

namespace App\Handler\Command;

class DeleteShopCommand
{
    public $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
