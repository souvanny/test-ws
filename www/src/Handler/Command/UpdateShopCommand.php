<?php

namespace App\Handler\Command;

class UpdateShopCommand
{
    public int $id;
    public ?string $name;
    public ?string $city;

    public function __construct(int $id, ?string $name, ?string $city)
    {
        $this->id = $id;
        $this->name = $name;
        $this->city = $city;
    }
}
