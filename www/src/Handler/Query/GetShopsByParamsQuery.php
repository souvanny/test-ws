<?php

namespace App\Handler\Query;

class GetShopsByParamsQuery
{
    public array $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }
}
