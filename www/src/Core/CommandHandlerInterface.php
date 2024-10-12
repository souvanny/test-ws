<?php

namespace App\Core;

interface CommandHandlerInterface
{
    public function __invoke($command);
}