<?php

namespace App\Core;

interface CommandHandlerInterface
{
    public function handle($command);
}