<?php

namespace App\Handler\Query;

class GetShopByIdQuery
{
    public $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
