<?php

namespace App\Core;

interface QueryHandlerInterface
{
    public function __invoke(Object $query);
}