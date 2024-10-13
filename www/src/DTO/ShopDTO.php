<?php

namespace App\DTO;

class ShopDTO
{
    public int $id;
    public string $name;
    public string $city;

    public function __construct(int $id, string $name, string $city)
    {
        $this->id = $id;
        $this->name = $name;
        $this->city = $city;
    }
}
