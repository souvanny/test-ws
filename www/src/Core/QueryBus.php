<?php
namespace App\Core;

class QueryBus
{
    protected $handlers = [];

    public function registerHandler(string $queryClass, callable $handler)
    {
        $this->handlers[$queryClass] = $handler;
    }

    public function handle($query)
    {
        $queryClass = get_class($query);

        if (!isset($this->handlers[$queryClass])) {
            throw new \Exception("Aucun handler trouvé pour la requête : $queryClass");
        }

        return $this->handlers[$queryClass]->handle($query);
    }
}
