<?php

namespace App\Core;

use Exception;

/**
 * Centralise l'envoi et la gestion des commandes dans l'application.
 * Son rôle est de prendre une commande et de la faire traiter par le bon handler
 */
class CommandBus
{
    protected array $handlers = [];

    public function __construct(HandlerLoader $handlerLoader)
    {
        $handlerLoader->loadHandlers(__DIR__ . '/../../src/Handler/Command', CommandHandlerInterface::class, $this);
    }

    public function registerHandler(string $commandClass, callable $handler)
    {
        $this->handlers[$commandClass] = $handler;
    }

    /**
     * @throws Exception
     */
    public function handle($command)
    {
        $commandClass = get_class($command);
        $commandClass .= 'Handler';

        if (!isset($this->handlers[$commandClass])) {
            throw new Exception("Aucun handler trouvé pour la commande : $commandClass");
        }

        return $this->handlers[$commandClass]($command);
    }
}
