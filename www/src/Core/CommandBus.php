<?php

namespace App\Core;

class CommandBus
{
    protected $handlers = [];

    public function __construct(HandlerLoader $handlerLoader)
    {
        $handlerLoader->loadHandlers(__DIR__ . '/../../src/Handler/Command', CommandHandlerInterface::class, $this);
    }

    public function registerHandler(string $commandClass, callable $handler)
    {
        $this->handlers[$commandClass] = $handler;
    }

    public function handle($command)
    {
        $commandClass = get_class($command);

        if (!isset($this->handlers[$commandClass])) {
            throw new \Exception("Aucun handler trouvé pour la commande : $commandClass");
        }

        $this->handlers[$commandClass]->handle($command);
    }
}
