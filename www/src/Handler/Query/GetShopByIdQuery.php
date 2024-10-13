<?php

namespace App\Handler\Query;

class GetShopByIdQuery
{
    public int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
