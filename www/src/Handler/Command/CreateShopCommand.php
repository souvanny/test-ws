<?php

namespace App\Handler\Command;

class CreateShopCommand
{
    public string $name;
    public string $city;

    public function __construct(string $name, string $city)
    {
        $this->name = $name;
        $this->city = $city;
    }
}
