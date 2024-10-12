<?php

namespace App\Core;

class QueryBus
{
    protected $handlers = [];

    public function __construct(HandlerLoader $handlerLoader)
    {
        $handlerLoader->loadHandlers(__DIR__ . '/../../src/Handler/Query', QueryHandlerInterface::class, $this);
    }


    public function registerHandler(string $queryClass, callable $handler)
    {
        $this->handlers[$queryClass] = $handler;
    }

    public function handle($query)
    {
        echo "### QueryBus handle ### <br>";
        print_r($this->handlers);

        $queryClass = get_class($query);
        $queryClass .= 'Handler';

        if (!isset($this->handlers[$queryClass])) {
            throw new \Exception("Aucun handler trouvé pour la requête : $queryClass");
        }

        return $this->handlers[$queryClass]($query);
    }
}
