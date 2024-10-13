<?php

namespace App\Core;

use Exception;

class QueryBus
{
    protected array $handlers = [];

    public function __construct(HandlerLoader $handlerLoader)
    {
        $handlerLoader->loadHandlers(__DIR__ . '/../../src/Handler/Query', QueryHandlerInterface::class, $this);
    }


    public function registerHandler(string $queryClass, callable $handler)
    {
        $this->handlers[$queryClass] = $handler;
    }

    /**
     * @throws Exception
     */
    public function handle($query)
    {
        $queryClass = get_class($query);
        $queryClass .= 'Handler';

        if (!isset($this->handlers[$queryClass])) {
            throw new Exception("Aucun handler trouvé pour la requête : $queryClass");
        }

        return $this->handlers[$queryClass]($query);
    }
}
