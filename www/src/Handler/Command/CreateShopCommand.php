<?php

namespace App\Handler\Command;

class CreateShopCommand
{
    public $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
