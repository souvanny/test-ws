<?php

namespace App\Handler\Command;

class CreateShopCommand
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
