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
        echo "### registerHandler ### <br>";
        $this->handlers[$commandClass] = $handler;
    }

    public function handle($command)
    {
        echo "### CommandBus handle ### <br>";
        print_r($this->handlers);

        $commandClass = get_class($command);
        $commandClass .= 'Handler';

        if (!isset($this->handlers[$commandClass])) {
            throw new \Exception("Aucun handler trouvé pour la commande : $commandClass");
        }

        $this->handlers[$commandClass]($command);
    }
}
